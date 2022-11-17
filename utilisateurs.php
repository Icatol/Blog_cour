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
/* SI BOUTON UTILISER ENTRE DANS LA CONDITION ET CREE L'UTILISATEUR */
if (!empty($_POST['bouton'])) {
    $utilisateurs = new utilisateurs();
    $utilisateurs->hydrate($_POST);

    $utilisateurs->setMdp(password_hash($utilisateurs->getMdp(), PASSWORD_DEFAULT));

    //print_r2($utilisateurs);

    $utilisateursManager = new utilisateursManager($bdd);
    $utilisateursManager->add($utilisateurs);

    //print_r2($utilisateursManager);

    $messageNotif = $utilisateursManager->get_result() == true ? "Votre utilisateur a été ajouté" : "Erreur survenue lors de l'ajout de votre utilisateur";
    $resultNotif = $utilisateursManager->get_result() == true ? "success" : "danger";

    $_SESSION['notification']['result'] = $resultNotif;
    $_SESSION['notification']['message'] = $messageNotif;

    header("Location: index.php");
    exit();
}

/*-----------------------------
--------PARTIE AFFICHAGE-------
-----------------------------*/
/* AFFICHAGE TWIG */
echo $twig->render(
    'utilisateurs.html.twig',
    [
        'session' => $_SESSION
    ]
);
