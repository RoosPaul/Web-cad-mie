<div class="row vert-offset-top-3">
    <div class="col-xs-7" id="message_del">
        <?php
        for ($i = count($data) - 1; $i >= 0; $i--    ){
            echo "<div>" . htmlspecialchars($data[$i]['content']) .
                "</div><div class='vert-offset-top-2'><i>Envoyé à ".
                $data[$i]['date']." Par ".$data[$i]['pseudo']."</i>
                <form action='/". DIRNAME . "/message/deleted/".$tab
                ."' method='post'><button type='submit' value='".
                $data[$i]['id_message']."'
                name='message_to_keep'
                class='btn btn-default'>Récuperer ce message</button></form>
                </div><hr>";
        }
        ?>
    </div>
</div>
