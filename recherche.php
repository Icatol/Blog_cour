<?php include './includes/header.inc.php'; ?>
<!-- Responsive navbar-->
<?php include './includes/nav.inc.php'; ?>
<!-- Page content-->
<div class="container">
    <div class="text-center mt-5">
        <h1>A Bootstrap 5 Starter Template</h1>
        <p class="lead">A complete project boilerplate built with Bootstrap</p>
        <p>Bootstrap v5.1.3</p>
    </div>

    <?php
    include './includes/script.inc.php';
    include './classes/articles.class.php';
    include './config/check_connexion.conf.php';

    if (!empty($_GET['search'])) {
        $articlesManager = new articlesManager($bdd);
        $listArticles = $articlesManager->getListArticlesFromRecherche($_GET['search']);
    } else {
        $listArticles = [];
    }
    ?>


    <form id="" method="GET" action="recherche.php">
        <div class="row mb-5">
            <div class="col-6">
                <input type="text" class="form-control" name="search" value="" placeholder="Mot clé....">
            </div>
            <div class="col-6">
                <button type="submit" id="submit" value="recherche" class="btn btn-primary">Rechercher</button>
            </div>
        </div>
    </form>


    <div class="row">
        <?php
        foreach ($listArticles as $articles) {
            /* @var $articles articles */
        ?>
            <div class="col-6 mb-4">
                <div class="card">
                    <img src="img/<?= $articles->getId() ?>.jpg" style="max-width: 200px;" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?= $articles->getTitre() ?></h5>
                        <p class="card-text"><?= $articles->getTexte() ?></p>
                        <a href="#" class="btn btn-info"><?= $articles->getDate() ?></a>
                        <a href="articles.php?id=<?= $articles->getId() ?>" class="btn btn-warning">Modifier</a>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

</div>