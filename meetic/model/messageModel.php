<?php

class user_message extends database {
    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_menu() {
        $req = $this->bdd->prepare("SELECT user.pseudo FROM message
            INNER JOIN user ON user.id_user = message.id_from WHERE
            (id_to=:id_user OR id_from=:id_user) GROUP BY user.pseudo");
        $req->execute(array('id_user' => $_SESSION['id_user']));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }
    
    public function show_conversation($id) {
        $req = $this->bdd->prepare("SELECT * FROM message INNER JOIN user
            ON user.id_user = message.id_from WHERE ((id_to=:id_user AND
            id_from=:id_other) OR (id_to=:id_other AND id_from=:id_user))
        AND message.message_delete=0 ORDER BY message.date");

        $req->execute(array(
            'id_user' => $_SESSION['id_user'],
            'id_other' => $id[0]['id_user']
        ));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        
        return $data;
    }
    
    public function show_delete_conversation() {
        $req = $this->bdd->prepare("SELECT * FROM message INNER JOIN user
            ON user.id_user = message.id_from
        WHERE (id_to=:id_user OR id_from=:id_user)
        AND message.message_delete=1 ORDER BY message.date");


        $req->execute(array(
            'id_user' => $_SESSION['id_user'],
        ));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function add_message($id_user) {
        $id_from = $_SESSION['id_user'];
        $id_to = $id_user;

        $req = $this->bdd->prepare("INSERT INTO message
            (id_from, id_to, content) VALUES (:id_from, :id_to, :content)");
        $req->execute(array(
            'id_from' => $id_from,
            'id_to' => $id_to,
            'content' => $_POST['content']
        ));
    }

    public function get_id_user($pseudo) {
        $req = $this->bdd->prepare("SELECT id_user FROM user
            WHERE pseudo=:pseudo");
        $req->execute(array('pseudo' => $pseudo));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    
    public function delete_message($id_message) {
        $req = $this->bdd->prepare("UPDATE message SET message_delete=1
        WHERE id_message=:id_message");
        $req->execute(array('id_message' => $id_message));

    }
    
    public function keep_message($id_message) {
        $req = $this->bdd->prepare("UPDATE message SET message_delete=0
        WHERE id_message=:id_message");
        $req->execute(array('id_message' => $id_message));
    }
}