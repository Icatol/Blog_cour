<?php
/*-----------------------------
----PARTIE INCLUDE/REQUIRE-----
-----------------------------*/
include './includes/nav.inc.php';
include './includes/header.inc.php';
include './includes/script.inc.php';
include './classes/articles.class.php';
include './config/check_connexion.conf.php';


/*-----------------------------
--------PARTIE VARIABLE--------
-----------------------------*/
$loader = new \Twig\Loader\FilesystemLoader('templates/');
$twig = new \Twig\Environment($loader, ['debug' => true]);


/*-----------------------------
--PARTIE CONDITION ET BOUCLE---
-----------------------------*/
//Conditon si formulaire envopyer ou non
if (!empty($_POST['bouton'])) {
    $articles = new articles();
    $articles->hydrate($_POST);
    $articles->setDate(date('Y-m-d'));

    $articlesManager = new articlesManager($bdd);
    $articlesManager->set_article($articles);

    //print_r2($articlesManager);

    if ($_POST['id'] == "") {
        $articlesManager->add($articles);
    } else {
        $articlesManager->update($articles);
    }

    //print_r2($articlesManager);

    //Si article inséré, on traite l'image
    if ($articlesManager->get_result() == true) {
        if ($_FILES['image']['error'] == 0) {
            if ($_POST['id'] == "") {
                $nomImage = $articlesManager->get_getLastInsertId();
            } else {
                $nomImage = $_POST['id'];
            }
            $from = $_FILES['image']['tmp_name'];
            move_uploaded_file($from, __DIR__ . "/img/" . $nomImage . ".jpg");
        }
    }
    //echo ("image ajouté");

    $messageNotif = $articlesManager->get_result() == true ? "Votre article a été ajouté/modifier" : "Erreur survenue lors de l'ajout ou modification de votre article";
    $resultNotif = $articlesManager->get_result() == true ? "success" : "danger";

    $_SESSION['notification']['result'] = $resultNotif;
    $_SESSION['notification']['message'] = $messageNotif;

    header("Location: index.php");
    exit();
}

//Verification et récupération d'article en base via l'id
if (isset($_GET['id'])) {
    $boutonForm = "Modifier article";
    $check = "checked";
    //echo ($_GET['id']);

    //$articlesId = new articles();

    $articlesManagerId = new articlesManager($bdd);
    $getArticlesId = $articlesManagerId->get($_GET['id']);

    var_dump($getArticlesId);
} else {
    $boutonForm = "Ajouter article";
    $check = "";

    $articlesId = new articles();
    $getArticlesId = $articlesId->hydrate($_POST);

    //print_r2($getArticlesId);
}

/*-----------------------------
--------PARTIE AFFICHAGE-------
-----------------------------*/
/* AFFICHAGE TWIG */
echo $twig->render(
    'articles.html.twig',
    [
        'session' => $_SESSION,
        'boutonForm' => $boutonForm,
        'check' => $check,
        'getArticleId' => $getArticlesId
    ]
);

/* SUPPRESION VARIABLE SESSION notification */
unset($_SESSION['notification']);
