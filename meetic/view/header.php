<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php
        if ($url == "")
            echo 'index';
        else
            echo $url;
        ?></title>
    <link href="/PHP_my_meetic/styles.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/PHP_my_meetic/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/PHP_my_meetic/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">
    <script type="text/javascript" src="jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="jquery.js"></script>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<body>
<header>
    <nav class="navbar navbar-default nav-bar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/<?php echo DIRNAME;?>/home">My meetic</a>
            </div>
            <?php
            if (isset($_SESSION['pseudo'])) {
                echo "<p class=\"navbar-text \">Connecté en tant que ".$_SESSION['pseudo']."</p>";
                echo '<form action="/'. DIRNAME.'/home/logout"><button type="submit"
                class="btn btn-default navbar-btn navbar-right">déconnexion</button></form>';
            }
            ?>
        </div>
    </nav>
    <div class="container">
        <ul class="nav nav-pills nav-justified">
            <li role="presentation" class="active btn1"><a href="/<?php echo DIRNAME;?>/home">Home</a></li>
            <li role="presentation" class="active btn1"><a href="/<?php echo DIRNAME;?>/profile">Profile</a></li>
            <li role="presentation" class="active btn1"><a href="/<?php echo DIRNAME;?>/message">Messages</a></li>
            <li role="presentation" class="active btn1"><a href="/<?php echo DIRNAME;?>/selection">Sélection</a></li>
        </ul>
    </div>
</header>
<div class="container"> 