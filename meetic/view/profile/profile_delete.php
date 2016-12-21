<div class="row">
    <div class="col-xs-12">
        <h2>Êtes vous sûr de vouloir supprimer votre compte ?</h2>
        <form action="/<?php echo DIRNAME;?>/profile/delete" method="post" class="vert-offset-top-3">
            <button type="submit" name="choice" value="oui" class="btn btn-default col-xs-6 refuse">Oui, je suis
            prêt à le supprimer définitivement !</button>
            <button type="submit" name="choice" value="non" class="btn btn-default col-xs-6 accept">Non, je vous retourner
            sur l'accueil !</button>
        </form>
    </div>
</div>
