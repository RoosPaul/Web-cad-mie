<div class="row profile_menu">
    <form action="/<?php echo DIRNAME;?>/profile/change" method="post" class="col-xs-6">
        <h2>Vos informations</h2>
        <h4>Pseudo</h4>
        <input type="text" name="pseudo" class="form-control" value="<?php echo $data[0]['pseudo']?>">
        <h4>Lieu</h4>
        <input type="text" name="ville" class="form-control" placeholder="ville" value="<?php echo $data[0]['city']?>"><br>
        <input type="text" name="departement" class="form-control" placeholder="département" value="<?php echo $data[0]['department']?>"><br>
        <input type="text" name="region" class="form-control" placeholder="région" value="<?php echo $data[0]['region']?>"><br>
        <input type="text" name="country" class="form-control" placeholder="pays" value="<?php echo $data[0]['country']?>"><br>
        <h4>E-mail</h4>
        <input type="email" name="email" class="form-control" value="<?php echo $data[0]['email']?>">
        <h4>Mot de passe</h4>
        <input type="password" name="pass" class="form-control">
        <h4>Confirmation mot de passe</h4>
        <input type="password" name="cpass" class="form-control">
        <button type="submit" name="submit_register" class="form-control btn btn-primary vert-offset-top-2">
            Changez vos informations
        </button>
    </form>
    <form action="/<?php echo DIRNAME;?>/profile/change" method="post" class="col-xs-6">
        <h2>Vos préférences</h2>
        <h4>Sexe</h4>

        <select name="gender" class="form-control">
            <?php
            if ($preference['gender'] === 'homme')
                echo '<option value="homme" selected>Homme</option>';
            else
                echo '<option value="homme">Homme</option>';
            if ($preference['gender'] === 'femme')
                echo '<option value="femme" selected>Femme</option>';
            else
                echo '<option value="femme">Femme</option>';
            if ($preference['gender'] === 'autres')
                echo '<option value="autres" selected>Autres</option>';
            else
                echo '<option value="autres">Autres</option>';
                    ?>
        </select><br>
        <h4>Ville</h4>
        <input type="text" name="city" class="form-control" value="<?php echo $preference['city'];?>"><br>
        <h4>Département</h4>
        <input type="text" name="department" class="form-control" value="<?php echo $preference['department'];?>"><br>
        <h4>Région</h4>
        <input type="text" name="region" class="form-control" value="<?php echo $preference['region'];?>"><br>
        <h4>Pays</h4>
        <input type="text" name="country" class="form-control" value="<?php echo $preference['country'];?>"><br>
        <h4>Âge</h4>
        <select class="form-control" name="age">
            <?php

            if ($preference['age'] === '18-25')
                echo '<option value="18-25" selected>18 et 25</option>';
            else
                echo '<option value="18-25" >18 et 25</option>';
            if ($preference['age'] === '25-35')
                echo '<option value="25-35" selected>25 et 35</option>';
            else
                echo '<option value="25-35">25 et 35</option>';
            if ($preference['age'] === '35-45')
                echo '<option value="35-45" selected>35 et 45</option>';
            else
                echo '<option value="35-45">35 et 45</option>';
            if ($preference['age'] === '45+')
                echo '<option value="45+" selected>45 et plus</option>';
            else
                echo '<option value="45+">45 et plus</option>';

            ?>
        </select><br>
        <button type="submit" name="submit_preference" class="form-control btn btn-primary vert-offset-top-1">
            Changez vos préférences</button>
    </form>
</div>