<?php

class home {

    private $model;
    protected $token;


    public function __construct() {
        require(ROOT . "/model/userModel.php");
        $this->model = new user();
    }


    public function index() {
        require (ROOT . "/view/home/home_form.php");
        if (isset($_POST['search'])) {
            $tab = [];
            foreach ($_POST as $key => $value) {
                if (preg_match("#^city#", $key)) {
                    array_push($tab, $value);
                }
            }
            if ($_POST['age'] === '18-25') {
                $first_date = 18;
                $last_date = 25;
            } elseif ($_POST['age'] === '25-35') {
                $first_date = 25;
                $last_date = 35;
            } elseif ($_POST['age'] === '35-45') {
                $first_date = 35;
                $last_date = 45;
            } else {
                $first_date = 45;
                $last_date = 150;
            }
            $data = $this->model->get_search($_POST, $first_date, $last_date,
                $tab);
        }
        else {
            $preference =
            $this->model->get_user_preference($_SESSION['id_user']);
            $data = $this->model->preference_search($preference);
        }
        require (ROOT . "/view/home/home_profil.php");
    }

    public function profile($pseudo) {
        $data = $this->model->get_profile($pseudo);
        for ($i = 0; $i < count($data); $i++) {
            $check = $this->model->check_if_fav($data[$i]['id_user']);
            array_push($data[$i], $check);
        }
        if (isset($_POST['like'])) {
            $this->model->add_to_fav($_POST['like']);
        }
        if (isset($_POST['unlike'])) {
            $this->model->delete_to_fav($_POST['unlike']);
        }
        if ($data === [])
            echo 'Aucun utilisateur trouvé sous le pseudo : ' . $pseudo . ' ';
        else
            require (ROOT . "/view/home/home_user.php");
    }

    public function logout() {
        $_SESSION = array();
        session_destroy();
        $redirection ='/' . DIRNAME . '/home';
        header("Location: $redirection");
    }

    public function inscription() { //si form envoyé check des vars
        if (isset($_POST['submit_token'])){
            if ($_POST['token'] === $_POST['ctoken']) {
                $this->model->valid_account($_POST['email']);
                $this->token = "";
            }
            else
                echo 'token mauvais';
        }
        if (isset($_POST['submit_register'])) {
            $check = $this->model->check_inscription($_POST);
            if($check !== false){
                echo '<div class="alert alert-success" role="alert"><g>Bien joué
                !</g>
                Votre compte a bien était ajouté.</div>';
                while ($this->token < 11) {
                    $this->token += rand();
                }
                $this->model->send_token($this->token, $check);
                include (ROOT . "/view/home/token.php");
            }
            else {
                include('view/home/inscription.php');
            }
        }
        else {
            
            include('view/home/inscription.php');
        }
    }

    public function connexion() { // si form envoyé check des variables
        if (isset($_POST['connexion_submit'])) {
            $check = $this->model->check_connexion($_POST);
            if ($check) {
                $redirection ='/' . DIRNAME . '/home';
                header("Location: $redirection");
            }
            else {
                echo '<div class="alert alert-warning vert-offset-top-2"><g>
                Erreur !</g> Les informations de 
                connection sont incorrect...</div>';
                include(ROOT . '/view/home/connexion.php');
            }
        }
        else {
            include('view/home/connexion.php');
        }
    }
    public function deconnexion() {

    }

    public function error() {
        include ("error.php");
    }
}
