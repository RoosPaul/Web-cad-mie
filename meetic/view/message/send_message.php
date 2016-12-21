<div class="row vert-offset-top-3">
    <div class="col-xs-7">
        <form action="/<?php echo DIRNAME;?>/message/send_message" method="post">
            <h3>Destinataire (pseudo) :</h3>
            <input type="text" class="form-control" name="to" value="<?php echo $to ;?>">
            <h3>Message :</h3>
            <textarea class="form-control" name="content"></textarea>
            <button type="submit" class="form-control btn btn-default vert-offset-top-2"
                    name="send_message">Envoyé</button>
        </form>
    </div>
</div>
