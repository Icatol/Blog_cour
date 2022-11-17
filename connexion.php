<?php
/*-----------------------------
----PARTIE INCLUDE/REQUIRE-----
-----------------------------*/
include './includes/header.inc.php';
include './includes/nav.inc.php';


/*-----------------------------
--------PARTIE VARIABLE--------
-----------------------------*/
$loader = new \Twig\Loader\FilesystemLoader('templates/');
$twig = new \Twig\Environment($loader, ['debug' => true]);


/*-----------------------------
--PARTIE CONDITION ET BOUCLE---
-----------------------------*/
//Condition si le bouton de connexion à été utilisé
if (!empty($_POST['bouton'])) {

    //echo 'le formulaire est posté';
    //print_r2($_POST);
    //print_r2($_FILES);
    //Création de l'utilisateur
    $utilisateursFormulaire = new utilisateurs();
    $utilisateursFormulaire->hydrate($_POST);
    //print_r2($utilisateursFormulaire);


    $utilisateursManager = new utilisateursManager($bdd);
    $utilisateursEnBdd = $utilisateursManager->getByEmail($utilisateursFormulaire->getEmail());

    //echo "test";
    //print_r2($utilisateursEnBdd);

    $isConnect = password_verify($utilisateursFormulaire->getMdp(), $utilisateursEnBdd->getMdp());

    //dump($isConnect);

    //Si l'utilisateur arrive à se connecter crée un cookie d'identification
    if ($isConnect == true) {
        $sid = md5($utilisateursEnBdd->getEmail() . time());
        //echo $sid;
        //Création du cookie
        setcookie('sid', $sid, time() + 86400);
        //Mise en bdd du sid
        $utilisateursEnBdd->setSid($sid);
        //dump($utilisateursEnBdd);
        $utilisateursManager->updateByEmail($utilisateursEnBdd);
        //dump($utilisateurManager->get_result());
    }

    //Si l'utilisateur arrive à se connecter retour au l'accueil sinon afffiche une erreur et le fait rester sur cette page
    if ($isConnect == true) {
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'Vous êtes connecté !';
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['notification']['result'] = 'danger';
        $_SESSION['notification']['message'] = 'Vérifiez votre login / mot de passe !';
        header("Location: connexion.php");
        exit();
    }
}


/*-----------------------------
--------PARTIE AFFICHAGE-------
-----------------------------*/
//AFFICHAGE TWIG
echo $twig->render(
    'connexion.html.twig',
    [
        'session' => $_SESSION
    ]
);

//SUPPRESION VARIABLE SESSION notification
unset($_SESSION['notification']);
