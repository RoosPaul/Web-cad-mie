<div class="row vert-offset-top-5">
    <?php
    for ($i = 0; $i < count($data); $i++) {
        echo "
        <div class='col-xs-6 profile col-xs-offset-3'>";
        if ($data[$i]['gender'] === "homme")
            echo "<img class='center-block img-responsive' alt='img-profil'
        src='/".DIRNAME."/images/big_man.png'>";
        else
            echo "<img class='center-block img-responsive' alt='img-profil'
        src='/".DIRNAME."/images/big_woman.png'>";
        echo "
        <p>Prénom : ".$data[$i]['last_name']."<br>Nom : ".$data[$i]['last_name']
        ."<br>Pseudo : " . $data[$i]['pseudo']. "<br>Pays : "
        .$data[$i]['country']."<br> Région : ".$data[$i]['region']
        ."<br>Département : ".$data[$i]['department']."<br>
        Ville : ".$data[$i]['city']."<br>Âge : "
        .(abs(($data[$i]['birthday'] - date()) - 2016))."ans<br>Adresse mail : "
        .$data[$i]['email'] ."</p>
        <form action='/".DIRNAME ."/message/send_message/".$data[$i]['pseudo']
        ."' method='post'>
            <button class='btn btn-primary center-block'>Envoyer un message !
            </button></form>";
            if ($data[$i][0] === 0){
            echo '<form action="/'.DIRNAME.'/home/profile/'.$data[$i]['pseudo'].
            '" method="post">
        <button name="like" value="'.$data[$i]['id_user'].'" class="btn btn-primary center-block vert-offset-top-1">
        Like</button></form></div>';
        }
        else {
         echo '<form action="/'.DIRNAME.'/home/profile/'.$data[$i]['pseudo'].
            '" method="post">
        <button name="unlike" value="'.$data[$i]['id_user'].'" class="btn btn-primary center-block vert-offset-top-1">
        Unlike</button></form></div>';   
        }
    }
    ?>
</div>