<div class="row vert-offset-top-3">
    <div class="col-xs-7">
        <h3>Répondre :</h3>
        <form action="/<?php echo DIRNAME;?>/message/conversation/<?php echo $tab?>" method="post">
            <textarea class="form-control" name="content"></textarea>
            <button type="submit" class="form-control btn btn-default vert-offset-top-2"
                    name="add_message" id="envoie">Envoyé</button>
        </form>
    </div>
</div>
