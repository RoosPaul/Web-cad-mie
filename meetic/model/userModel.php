<?php
class user extends database {

    public function __construct()
    {
        parent::__construct();
    }


    public function check_connexion($tab)
    { //check si les ids correspondent dans la db
        $good = true;
        foreach ($tab as $key => $value) {
            if($value === "" && $key !== 'connexion_submit')
                $good = false;
        }
        if ($good === false)
            echo 'Login ou mot de passe incorrect';
        else {
            $req = $this->bdd->prepare("SELECT pseudo, id_user, email FROM user
                WHERE (pseudo=:pseudo OR
                email=:email) AND password=:password AND active=1");
            $req->execute(array(
                'pseudo' => $tab['pseudo'],
                'email' => $tab['pseudo'],
                'password' => hash('sha256', $tab['pass'])
                ));
            $data = $req->fetchAll();
            if (count($data) === 0) {
                return false;
            } else {
                $_SESSION['id_user'] = $data[0]['id_user'];
                $_SESSION['pseudo'] = $data[0]['pseudo'];
                $_SESSION['email'] = $data[0]['email'];
                return true;
            }
        }
    }

    public function send_token($token, $email) {
        $message = "Bonjour,\r\npour finaliser votre compte veuillez entrer ce
        token\r\n".$token;

        $message = wordwrap($message, 70, "\r\n");

        mail($email, 'Confirmation de votre compte', $message);
    }

    public function check_inscription($tab)
    { //check les variables données pour l'inscription
    $good = [];
    foreach ($tab as $key => $value) {
        if ($value === "" && $key !== "submit_register")
            array_push($good, $key);
        elseif ($key === "date"){

        }
    }
    if (abs(($tab['date'] - date()) - 2016) <= 18) {
        array_push($good, 'Âge non valide');
    }

    if (!filter_var($tab['email'], FILTER_VALIDATE_EMAIL))
        array_push($good, 'email');

    if ($tab['pass'] !== $tab['cpass'])
        array_push($good, 'password');


    if (count($good) > 0) {
        foreach ($good as $value) {
            echo '<div class="alert alert-warning" role="alert"><g>Attention
            !</g>
            L\'élément '.$value.' est incorrect !</div>';
        }
        return false;
    }
    else {
        $req = $this->bdd->prepare("SELECT pseudo FROM user WHERE
            pseudo=:pseudo");
        $req->execute(array('pseudo' => $tab['pseudo']));
        $result = $req->fetchAll();

        $req2 = $this->bdd->prepare("SELECT email FROM user WHERE
            email=:email");
        $req2->execute(array('email' => $tab['email']));
        $result2 = $req2->fetchAll();
        if (count($result) > 0) {
            echo '<div class="alert alert-warning" role="alert"><g>Attention
            !</g>
            Ce pseudo est déjà utilisé.</div>';
            return false;
        }

        if (count($result2) > 0) {
            echo '<div class="alert alert-warning" role="alert"><g>Attention
            !</g>
            Cette adresse mail est déjà utilisé.</div>';
            return false;
        }

        $this->create_member($tab);
        return $tab['email'];
    }
}

public function valid_account($mail) {
    $req = $this->bdd->prepare("UPDATE user SET active = 1 WHERE email =
        :email ");
    $req->execute(array('email' => $mail));
}

public function create_member($tab)
{
    if ($tab['radio'] === "on")
        $tab['radio'] = "homme";
    $req = $this->bdd->prepare("INSERT INTO user (last_name, first_name,
        pseudo,  birthday, gender,
        city, department, region, country, email, password)
        VALUES (:last_name, :first_name, :pseudo,
        :birthday, :gender, :city, :department, :region, :country,
        :email, :password)");
    $req->execute(array(
        'last_name' => $tab['nom'],
        'first_name' => $tab['prenom'],
        'pseudo' => $tab['pseudo'],
        'birthday' => $tab['date'],
        'gender' => $tab['radio'],
        'city' => $tab['ville'],
        'department' => $tab['departement'],
        'region' => $tab['region'],
        'country' => $tab['country'],
        'email' => $tab['email'],
        'password' => hash("sha256", $tab['pass'])
        ));
}

public function get_search($tab, $first_date, $last_date, $city_tab){
    $cpt = count($city_tab);
    $city_request = 'SELECT * FROM user WHERE gender LIKE :gender 
    AND (';
    $execute_request['gender'] = "%" . $tab['gender'] . "%";
    for ($i = 1; $i <= $cpt; $i++) {
        if ($i < $cpt)
            $city_request = $city_request . "city LIKE :city" . $i . " OR ";
        else
            $city_request = $city_request . "city LIKE :city" . $i;
        $execute_request["city$i"] = "%" . $tab["city$i"] . "%";
    }
    $city_request = $city_request . ') AND department LIKE :department
    AND region LIKE :region AND country LIKE :country
    AND FLOOR(DATEDIFF(CURRENT_DATE, birthday) / 365.25) BETWEEN :first_date
    AND :last_date';


    $execute_request['department'] = "%" . $tab['department'] . "%";
    $execute_request['region'] = "%" . $tab['region'] . "%";
    $execute_request['country'] = "%" . $tab['country'] . "%";
    $execute_request['first_date'] = $first_date;
    $execute_request['last_date'] = $last_date;
    echo '<br>';

    $req = $this->bdd->prepare("$city_request");
    $req->execute($execute_request);
    $data = $req->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

public function get_user_preference($id_user) {
    $req = $this->bdd->prepare("SELECT * FROM preference WHERE
        id_user=:id_user");
    $req->execute(array('id_user' => $id_user));
    $data = $req->fetch(PDO::FETCH_ASSOC);
    return $data;
}

public function preference_search($tab) {
    if ($tab['age'] === '18-25') {
        $first_date = 18;
        $last_date = 25;
    } elseif ($tab['age'] === '25-35') {
        $first_date = 25;
        $last_date = 35;
    } elseif ($tab['age'] === '35-45') {
        $first_date = 35;
        $last_date = 45;
    } else {
        $first_date = 45;
        $last_date = 150;
    }

    $req = $this->bdd->prepare("SELECT * FROM user WHERE gender=:gender AND
        city
        LIKE :city AND department LIKE :department AND region LIKE :region AND
        country LIKE :country AND
        FLOOR(DATEDIFF(CURRENT_DATE, birthday) / 365.25)
        BETWEEN :first_date AND :last_date");
    $req->execute(array(
        'gender' => $tab['gender'],
        'city' => "%" .$tab['city'] . "%",
        'department' => "%" .$tab['department'] . "%",
        'region' => "%" .$tab['region'] . "%",
        'country' => "%" .$tab['country'] . "%",
        'first_date' => $first_date,
        'last_date' => $last_date
        ));
    $data = $req->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

public function get_profile($pseudo){
    $req = $this->bdd->prepare("SELECT * FROM user WHERE pseudo=:pseudo");
    $req->execute(array('pseudo' => $pseudo));
    $data = $req->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

public function add_to_fav($id_user) {
    $req = $this->bdd->prepare("INSERT INTO favorite VALUES
        (:id_session, :id_user)");
    $req->execute(array(
        'id_session' => $_SESSION['id_user'],
        'id_user' => $id_user
        ));
}

public function delete_to_fav($id_user) {
    $req = $this->bdd->prepare("DELETE FROM favorite
        WHERE id_follower=:id_session AND id_following=:id_user");
    $req->execute(array(
        'id_session' => $_SESSION['id_user'],
        'id_user' => $id_user
        ));
}

public function check_if_fav($id_user) {
    $req = $this->bdd->prepare("SELECT * FROM favorite WHERE
        id_follower=:id_session AND id_following=:id_user");
    $req->execute(array(
        'id_session' => $_SESSION['id_user'],
        'id_user' => $id_user
        ));
    $find = $req->rowCount();
    return $find;
}
}