var express = require('express');
var app = express();
var http = require('http').Server(app);
var MongoClient = require("mongodb").MongoClient;
var io = require('socket.io')(http);
var bodyParser = require('body-parser');
var session = require('express-session');
var sess;
var me;
var admin;

app.use("/assets", express.static(__dirname + "/assets"));
app.use(bodyParser.urlencoded({extended: true}));
app.engine('.html', require('ejs').__express);
app.set('views', __dirname + "/views");
app.set('view engine', 'html');
app.use(bodyParser.json());

app.use(session({
	secret: 'keyboard cat',
	resave: true,
	saveUninitialized: true,
	cookie: { maxAge: 60000 }
}));


app.get('/',function(req,res){
	sess = req.session;
	if(sess.username) {
		res.redirect('/home');
	}
	else {
		res.render('login.html');
	}
});

app.post('/register',function(req,res){
	console.log("toto");
	sess = req.session;
	if(sess.username) {
		res.redirect('/home');
	}
	else {
		if (req.body.password === req.body.cpass) {
			console.log("les pass corresponsent");
			MongoClient.connect("mongodb://localhost:27017/users", function(error, db) {
				if (error) return funcCallback(error);
				db.collection("users").find({name: req.body.pseudo}).toArray(function (error, results) {
					if (error) throw error;
					if (results.length === 0) {
						db.collection("users").insert({name: req.body.pseudo, pass: req.body.cpass, admin: false});
					}
				});
			});
		}
		res.redirect('register');
	}
});

app.post('/login',function(req,res){
	var tmp = false;
	sess = req.session;
	var login = false;
	MongoClient.connect("mongodb://localhost:27017/users", function(error, db) {
		if (error) return funcCallback(error);
		db.collection("users").find().toArray(function (error, results) {
			if (error) throw error;
			results.forEach(function (i, e) {
				if (i.name === req.body.username && i.pass === req.body.password) {
					tmp = true;
					admin = i.admin;
				}
			});
			if (tmp) {
				login = true;
				me = req.body.username;

				sess.username = req.body.username;
				sess.password = req.body.password;
				res.redirect('/home');
			}
			else {
				console.log('test');
				res.redirect('/home');
			}
		});
	});
});

io.on('connection', function(socket){
	socket.room = "default";
	socket.join(socket.room);
	socket.username = me;
	socket.admin = admin;
	socket.emit('connected', socket.username);
	console.log(socket.admin);
	console.log('user connected');
	var msg = socket.username + " a rejoint le channel " + socket.room;
	io.in(socket.room).emit('cmd', msg);
	socket.on('chat message', function(msg){
		var tab = msg.val.split(" ");
		if (tab[0] === "/nick") {
			if (typeof tab[1] != "undefined"){
				socket.username = tab[1];
				msg = msg.user + " a changé son nickname en " + socket.username;
				io.in(socket.room).emit('cmd', msg);
			}
			else {
				msg.val = "Il faut rajouter un nickname";
			}
		}
		else if (tab[0] === "/list") {
			io.in(socket.room).emit('cmd', "Liste des rooms :");
			MongoClient.connect("mongodb://localhost:27017/rooms", function(error, db) {
				db.collection('rooms').find().toArray(function(err, results) { 
					if (!err) { if (results.length > 0){
						console.log(results);
						results.forEach(function (i, e) {
							io.in(socket.room).emit('cmd', i.name);
						});
					}
					else {
						console.log('pas de rooms');
					}
				}
			});
			});
		}
		else if (tab[0] === "/join") {
			if (typeof tab[1] != "undefined") {
				MongoClient.connect("mongodb://localhost:27017/rooms", function(error, db) {
					db.collection('rooms').find( { "name": tab[1] } ).toArray(function(err, results) { 
						if (!err) { if (results.length > 0){
							console.log(results);
						}
						else {
							db.collection('rooms').insertOne( {
								"name": tab[1]
							});
						}
					}
				});

				});
				socket.room = tab[1];
				socket.join(socket.room);
				io.in(socket.room).emit('cmd', "L'utilisateur " + socket.username + " a rejoint le channel " + socket.room);
			}
			else
				msg.val = "Il faut rajouter un channel";
		}
		else if (tab[0] === "/part") {
			socket.room = tab[1];
			socket.leave(socket.room);
			io.in(socket.room).emit('cmd', socket.username + "vient de partir de " + socket.room);
		}
		else if (tab[0] === "/users") {
			io.in(socket.room).emit('cmd', "Liste des utilisateurs sur ce channel :");
			for (var socketId in io.sockets.sockets) {
				io.in(socket.room).emit('cmd', io.sockets.sockets[socketId].username);
			}	
		}
		else if (tab[0] === "/msg") {
			if (typeof tab[1] != "undefined" && typeof tab[2] != "undefined") {

			}
			else if (typeof tab[1] != "undefined") {
				io.in(socket.room).emit('cmd', tab[1]);
			}
		}
		else {
			io.in(socket.room).emit('chat message', {'name' : socket.username + " [" + socket.room + "]" , 'msg' : msg.val});
		}
	});
});

app.get('/home',function(req,res){
	sess = req.session;
	console.log(sess.username);
	if(sess.username) {
		res.render('index', {user: sess.username});
	} else {
		res.write('<h1>Please login first.</h1>');
		res.end('<a href="/">Login</a>');
	}
});

app.get('/logout',function(req,res){
	req.session.destroy(function(err) {
		if(err) {
			console.log(err);
		} else {
			res.redirect('/');
		}
	});
});

app.get('/register', function(req, res){
	console.log("test");
	res.sendFile(__dirname + '/views/register.html');
});

app.post('/update', function(req, res) {
	MongoClient.connect("mongodb://localhost:27017/users", function(error, db) {
		if (req.body.password === req.body.cpass) {
			db.collection("users").update(
				{ "name" : me },
				{
					$set: { "name": req.body.pseudo, "pass": req.body.cpass },
					$currentDate: { "lastModified": true }
				}
				);
			me = req.body.pseudo;
		}
	});
	res.redirect('/update');
});
app.get('/update', function(req, res){
	console.log("test");
	MongoClient.connect("mongodb://localhost:27017/users", function(error, db) {
		db.collection('users').find( { "name": me } ).toArray(function(err, results) {
			results.forEach(function (i, e) {
				console.log("toto : " + i.name);
				res.render('update', {name: i.name, pass: i.pass});
			});
		});
	});
	// res.sendFile(__dirname + '/views/update.html');
});


http.listen(3000, function(){
	console.log('listening on *:3000');
});