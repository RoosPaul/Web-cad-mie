<div class="row">
    <div class="col-xs-12">
        <form action="inscription" method="post" class="col-xs-6">
            <h4>Nom</h4>
            <input type="text" name="nom" class="form-control">
            <h4>Prenom</h4>
            <input type="text" name="prenom" class="form-control">
            <h4>Pseudo</h4>
            <input type="text" name="pseudo" class="form-control">
            <h4>date de naissance</h4>
            <input type="date" name="date" class="form-control">
            <h4>Sexe</h4>
            <label class="radio-inline">
                <input type="radio" name="radio" value="homme" CHECKED>Homme
            </label>
            <label class="radio-inline">
                <input type="radio" name="radio" value="femme">Femme
            </label>
            <label class="radio-inline">
                <input type="radio" name="radio" value="autres">Autres
            </label>
            <h4>Lieu</h4>
            <input type="text" name="ville" class="form-control" placeholder="ville"><br>
            <input type="text" name="departement" class="form-control" placeholder="département"><br>
            <input type="text" name="region" class="form-control" placeholder="région"><br>
            <input type="text" name="country" class="form-control" placeholder="pays"><br>
            <h4>E-mail</h4>
            <input type="email" name="email" class="form-control">
            <h4>Mot de passe</h4>
            <input type="password" name="pass" class="form-control">
            <h4>Confirmation mot de passe</h4>
            <input type="password" name="cpass" class="form-control">
            <button type="submit" name="submit_register" class="form-control btn btn-default vert-offset-top-2">Submit</button>
        </form>
    </div>
</div>