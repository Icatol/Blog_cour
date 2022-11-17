<?php

$utilisateursCookie = new utilisateursManager($bdd);
if (isset($_COOKIE['sid'])) {
    //print_r2("dans le isset");
    $users = $utilisateursCookie->getBySid($_COOKIE['sid']);
    //var_dump($value);
    if ($utilisateursCookie->getBySid($_COOKIE['sid'])) {
        $isConnectSid = true;
    } else {
        $isConnectSid = false;
    }
} else {
    //print_r2("Pas de COOKIE");
    $isConnectSid = false;
}
