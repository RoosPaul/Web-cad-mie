<?php

class profile {
    private $model;

    public function __construct() {
        if (!isset($_SESSION['pseudo'])) {
            header('location: home');
        }
        else {
            require(ROOT . "/model/profileModel.php");
            $this->model = new user_profile();
            require(ROOT . "/view/profile/profile_home.php");
        }
    }

    public function index() {
    }

    public function info() {
        $data = $this->model->get_old_data();
        require(ROOT . "/view/profile/profile_info.php");
    }

    public function change() {
        $data = $this->model->get_old_data();
        if (isset($_POST['submit_register'])) {
            $check = $this->model->check_inscription($_POST);
            if ($check !== false ) {
                echo '<div class="alert alert-success" role="alert"><g>Bien joué
                !</g>
                Votre compte a bien était modifié.</div>';
                $_SESSION['pseudo'] = $_POST['pseudo'];
                require(ROOT . "/view/profile/profile_change.php");
            }
            else {
                echo '<div class="alert alert-warning" role="alert"><g>Attention
                !</g>
                Votre compte n\'a pas pu être modifié.</div>';
                require(ROOT . "/view/profile/profile_change.php");
            }
        }
        elseif (isset($_POST['submit_preference'])) {
            $this->model->update_preference($_POST);
            echo '<div class="alert alert-success" role="alert"><g>Bien joué !
            </g>
                Vos préférences ont bien était modifiées.</div>';
        }
            $preference =
            $this->model->get_user_preference($_SESSION['id_user']);
            require(ROOT . "/view/profile/profile_change.php");
    }

    public function delete() {
        require(ROOT . "/view/profile/profile_delete.php");
        if (isset($_POST['choice'])) {
            if ($_POST['choice'] === "non"){
                $redirection = "/" . DIRNAME;
                header("location: $redirection");
            }

            else {
                $this->model->delete_account();
            }
        }
    }
}
