<?php

class user_profile extends database
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_old_data() {
        $req = $this->bdd->prepare("SELECT * FROM user WHERE pseudo=:pseudo");
        $req->execute(array('pseudo' => $_SESSION['pseudo']));
        $data = $req->fetchAll();
        return $data;
    }

    public function check_inscription($tab)
    { //check les variables données pour l'inscription
        $good = [];
        foreach ($tab as $key => $value) {
            if ($value === "" && $key !== "submit_register")
                array_push($good, $key);
        }
        if (!filter_var($tab['email'], FILTER_VALIDATE_EMAIL))
            array_push($good, 'email');

        if ($tab['pass'] !== $tab['cpass'])
            array_push($good, 'password');


        if (count($good) > 0) {
            echo 'Les éléments suivant sont incorrects<br>';
            foreach ($good as $value) {
                echo $value . "<br>";
            }
            return false;
        } else {
            $req = $this->bdd->prepare("SELECT pseudo FROM user WHERE
                pseudo=:pseudo");
            $req->execute(array('pseudo' => $tab['pseudo']));
            $result = $req->fetchAll();

            $req2 = $this->bdd->prepare("SELECT email FROM user
                WHERE email=:email");
            $req2->execute(array('email' => $tab['email']));
            $result2 = $req2->fetchAll();
            if (count($result) > 0 && $_SESSION['pseudo'] !==
                $result[0]['pseudo']) {
                echo '<div class="alert alert-warning" role="alert">
            <g>Attention !</g>Ce pseudo est déjà utilisé.</div>';
                return false;
            }
            if (count($result2) > 0 && $_SESSION['email'] !== $tab['email']) {
                echo '<div class="alert alert-warning" role="alert"><g>Attention
                !</g>Cette adresse mail est déjà utilisé.</div>';
                return false;
            }

            $this->update_member($tab);
            header("Refresh:0");
            return $tab['email'];
        }
    }

        public function update_member($tab)
    {
        $req = $this->bdd->prepare("UPDATE user SET pseudo=:pseudo,
                    city=:city, department=:department, region=:region,
                    country=:country, email=:email, password=:password WHERE
                    pseudo=:session_pseudo");
        $req->execute(array(
            'pseudo' => $tab['pseudo'],
            'city' => $tab['ville'],
            'department' => $tab['departement'],
            'region' => $tab['region'],
            'country' => $tab['country'],
            'email' => $tab['email'],
            'password' => hash("sha256", $tab['pass']),
            'session_pseudo' => $_SESSION['pseudo']
        ));
    }

    public function get_user_preference($id_user) {
        $req = $this->bdd->prepare("SELECT * FROM preference WHERE
            id_user=:id_user");
        $req->execute(array('id_user' => $id_user));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        if ($data === false) {
            $req = $this->bdd->prepare("INSERT INTO preference
            (id_user, gender, city, department, region, country, age)
            VALUES
            (:id_user, :gender, :city, :department, :region, :country , :age)");
            $req->execute(array(
                'id_user' => $id_user,
                'gender' => 'homme',
                'city' => "",
                'department' => "",
                'region' => "",
                'country' => "",
                'age' => "18-25"
                ));
        }
        return $data;
    }

    public function delete_account() {
        $req = $this->bdd->prepare("UPDATE user SET active=2 WHERE
                    pseudo=:session_pseudo");
        $req->execute(array(
            'session_pseudo' => $_SESSION['pseudo']
        ));
        $_SESSION = array();
        session_destroy();
        $redirection = "/" . DIRNAME;
        header("location: $redirection");
    }

    public function update_preference($tab) {
        $req = $this->bdd->prepare("UPDATE preference SET
            gender=:gender, city=:city,
        department=:department, region=:region, country=:country, age=:age
        WHERE id_user=:id_user");
        $req->execute(array(
            'gender' => $tab['gender'],
            'city' => $tab['city'],
            'department' => $tab['department'],
            'region' => $tab['region'],
            'country' => $tab['country'],
            'age' => $tab['age'],
            'id_user' => $_SESSION['id_user']
        ));
    }

}