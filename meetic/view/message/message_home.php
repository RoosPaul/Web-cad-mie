<div class="row vert-offset-top-3">
    <div class="col-xs-3">
        <ul class="nav nav-pills nav-stacked">
            <li role="presentation" class="active">
                <a href="/<?php echo DIRNAME;?>/message">Ceux qui vous ont répondu :</a></li>
            <?php
            for ($i = 0; $i < count($data); $i++){
                echo '<li role="presentation" class="conv">
                <a href="/'. DIRNAME . '/message/conversation/'.
                $data[$i]['pseudo'].'">' . $data[$i]['pseudo'] . '</a></li>';
            }
            ?>
            <li role="presentation" class="active">
                <a href="<?php echo '/'. DIRNAME . '/message/send_message/'?>">Nouveau message +</a></li>
            <li role="presentation" class="rainbow">
                <a href="<?php echo '/'. DIRNAME . '/message/deleted/'?>">Message supprimé</a></li>
        </ul>
    </div>
</div>
