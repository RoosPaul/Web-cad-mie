<div class="row">
    <div class="col-xs-12">
        <h4><u>Rechercher quelqu'un par sexe/age/ville/département/région/pays</u></h4>
        <form action="/<?php echo DIRNAME;?>/home" method="post" class="form-inline">
            <select name="gender" class="form-control">
                <option value="homme">Homme</option>
                <option value="femme">Femme</option>
                <option value="autres">Autres</option>
            </select>
            <select class="form-control" name="age">
                <option value="18-25">18 et 25</option>
                <option value="25-35">25 et 35</option>
                <option value="35-45">35 et 45</option>
                <option value="45+">45 et plus</option>
            </select>
            <input type="text" placeholder="Département" name="department"
                   class="form-control">
            <input type="text" placeholder="Région" name="region"
                   class="form-control">
            <input type="text" placeholder="Pays" name="country"
                   class="form-control">
            <input type="text" placeholder="Ville" name="city1"
                   class="form-control">

            <a href="#" id="more" class="form-control btn btn-success">Rajouter une autre ville</a>
            <button type="submit" class="form-control btn btn-primary" name="search">Rechercher</button>
        </form>
    </div>
</div>