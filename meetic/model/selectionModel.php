<?php

class favorite extends database {
    public function __construct()
    {
        parent::__construct();
    }

    public function get_my_favorite() {
    	$req = $this->bdd->prepare("SELECT * FROM favorite WHERE
    		id_follower = :id_user");
    	$req->execute(array("id_user" => $_SESSION['id_user']));
    	$data = $req->fetchAll(PDO::FETCH_ASSOC);
    	return $data;
    }

    public function id_to_pseudo($id_user) {
    	$req = $this->bdd->prepare("SELECT pseudo FROM user WHERE id_user=:id_user");
        $req->execute(array('id_user' => $id_user));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    public function get_profile($pseudo){
        $req = $this->bdd->prepare("SELECT * FROM user WHERE pseudo=:pseudo");
        $req->execute(array('pseudo' => $pseudo));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}