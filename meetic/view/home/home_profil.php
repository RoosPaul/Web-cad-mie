<div class="row vert-offset-top-5">
    <?php
    for ($i = 0; $i < count($data); $i++) {
        echo "
        <div class='col-xs-3 profile col-xs-offset-1'>";
        if ($data[$i]['gender'] === "homme")
            echo "<img class='center-block img-responsive'
        alt='small-profil-img' src='/".DIRNAME."/images/man.png'>";
        else
            echo "<img class='center-block img-responsive'
        alt='small-profil-img' src='/".DIRNAME."/images/woman.png'>";
        echo "
        <p>Pseudo : " . $data[$i]['pseudo'].
        "<br>Pays : ".$data[$i]['country']."<br>
        Région : ".$data[$i]['region']."<br>Département : ".
        $data[$i]['department']."<br>Ville : ".$data[$i]['city']
        ."<br>Âge : ".(abs(($data[$i]['birthday'] - date()) - 2016))." ans</p>
        <form action='/".DIRNAME ."/home/profile/".$data[$i]['pseudo']
        ."' method='post'>
            <button class='btn btn-primary center-block'>Voir le profil !
            </button></form></div>";
    }
    ?>
</div> 