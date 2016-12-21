var socket = io();
var nick_tmp = "";
$('form').submit(function(){
	socket.emit('chat message', {user: "<%= user %>", val: $('#m').val()});
	$('#m').val('');
	return false;
});
socket.on('chat message', function(data){
	$('#messages').append($('<li>').text(data.name + " : " + data.msg));				
});

socket.on('change_nick', function (nick) {
	console.log(nick);
	nick_tmp = nick;
});

socket.on('connected', function (nick) {
	console.log('ok');
	$('#identity').html("<p class='navbar-text'>Vous êtes connecté en tant que " + nick + '</p><ul class="nav navbar-nav"><li><a href="/logout">Logout</a></li><li><a href="/update">Mon compte</a></li></ul>');
});

socket.on('cmd', function(msg){
	$('#messages').append($('<li style="background-color: #00CCFF">').text(msg));
});