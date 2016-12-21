<?php

class message {
    private $model;

    public function __construct() {
        if (!isset($_SESSION['pseudo'])) {
            header('location: home');
        }
        else {
            require(ROOT . "/model/messageModel.php");
            $this->model = new user_message();
            $data = $this->model->get_menu();
            require(ROOT . "/view/message/message_home.php");
        }
    }

    public function index() {

    }

    public function conversation($tab) {
        $id = $this->model->get_id_user($tab);
        if (isset($_POST['add_message']) && $_POST['content'] !== "") {
            $this->model->add_message($id[0]['id_user']);
        }
        if (isset($_POST['message_to_delete'])) {
            $this->model->delete_message($_POST['message_to_delete']);
        }
        $data = $this->model->show_conversation($id);
        require(ROOT . "/view/message/message_conversation.php");
        require(ROOT . "/view/message/message_add.php");
    }

    public function deleted() {
        if (isset($_POST['message_to_keep'])) {
            $this->model->keep_message($_POST['message_to_keep']);
        }
        $data = $this->model->show_delete_conversation();
        require(ROOT . "/view/message/message_deleted.php");
    }
    
    public function send_message($to){
        require(ROOT . "/view/message/send_message.php");
        if(isset($_POST['send_message'])){
            $id_user = $this->model->get_id_user($_POST['to']);
            $id_user = $id_user[0]['id_user'];
            if ($id_user !== false)
                $this->model->add_message($id_user);
            else
                echo 'Cette personne n\'existe pas ! :(';

        }
    }
}