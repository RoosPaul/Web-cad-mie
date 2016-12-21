<form action="inscription" method="post" class="col-xs-6">
    <h4>Entrer le token que vous avez reçu par mail.</h4>
    <input type="text" name="token" class="form-control">
    <input type="hidden" name="ctoken" value="<?php echo $this->token ?>" class="form-control">
    <input type="hidden" name="email" value="<?php echo $check ?>" class="form-control">

    <input type="submit" name="submit_token" class="form-control vert-offset-top-2">
</form>