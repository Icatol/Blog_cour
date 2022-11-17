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
$i = 1;
$nav = "";
if ($isConnectSid == true) {
    $sid = true;
} else {
    $sid = false;
}



/*-----------------------------
--PARTIE CONDITION ET BOUCLE---
-----------------------------*/

//var_dump($_SESSION['notification']);

//Condition si la variable page est dans la global $_GET
if (empty($_GET['page'])) {
    $_GET['page'] = 1;
}
$page = !empty($_GET['page']) ? $_GET['page'] : 1;

//Condition si le bouton de recheche est utilisé
if (!empty($_GET['search'])) {
    //$printValeur = ($_GET['search']);
    //$printValeur .= ("search non vide avec valeur");

    $articlesManager = new articlesManager($bdd);
    $listArticles = $articlesManager->getListArticlesFromRecherche($_GET['search']);

    $nbPages = 0;
} else {
    //$printValeur = ("search vide");

    $articlesManager = new articlesManager($bdd);
    $nbArticlesTotalAPublie = $articlesManager->countArticles();

    $nbPages = ceil($nbArticlesTotalAPublie / nb_articles_par_page);

    $indexDepart = ($page - 1) * nb_articles_par_page;

    $listArticles = $articlesManager->getListArticlesAAfficher($indexDepart, nb_articles_par_page);
}

//print_r2($listeArticles);
//var_dump($bdd);

//print_r2($articles);
//var_dump($bdd);

//print_r2($utilisateurs);


/*-----------------------------
--------PARTIE AFFICHAGE-------
-----------------------------*/
//AFFICHAGE TWIG
echo $twig->render(
    'index.html.twig',
    [
        'session' => $_SESSION,
        'listArticles' => $listArticles,
        'nav' => $nav,
        'nbPages' => $nbPages,
        'get' => $_GET,
        'sid' => $sid
    ]
);

//SUPPRESION VARIABLE SESSION notification
unset($_SESSION['notification']);
