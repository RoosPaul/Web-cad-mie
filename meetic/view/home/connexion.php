<div class="row">
    <div class="col-xs-12">
        <form action="/<?php echo DIRNAME?>/home/connexion" method="post" class="col-xs-6">
            <h4>Login</h4>
            <input type="text" name="pseudo" class="form-control" placeholder="pseudo ou adresse mail">
            <h4>Mot de passe</h4>
            <input type="password" name="pass" class="form-control" placeholder="Password">
            <button type="submit" name="connexion_submit" class="form-control btn btn-default vert-offset-top-2">Connexion</button>
            <a href="/<?php echo DIRNAME;?>/home/inscription">Toujours pas inscris ?
            Venez nous rejoindre directement sur cette page !</a>
        </form>
    </div>
</div>