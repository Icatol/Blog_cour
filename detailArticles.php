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
    if (isset($_GET['id'])) {
        $articlesManagerId = new articlesManager($bdd);
        $getArticlesId = $articlesManagerId->get($_GET['id']);

        //print_r2($getArticlesId);
    }

    ?>

    <div class="row">
        <img src="img/<?= $_GET['id'] ?>.jpg" style="max-width: 200px;" class="card-img-top" alt="...">
        <h1> <?= ($getArticlesId->getTitre()) ?> </h1>
        <h3> <?= ($getArticlesId->getTexte()) ?> </h3>


        <form action="detailsArticles.php" method="post" enctype="multipart/form-data">
            <!-- Id attribut hidden-->
            <input type="text" name="id" value="<?= $getArticlesId->getId() ?>" hidden>
            <!-- Titre input type text-->
            <div class="row">
                <div class="col">
                    <label for="Text" class="form-label">Pseudo</label>
                    <input class="form-control" type="text" name="titre" placeholder="Votre Pseudo" aria-label="default input example" required>
                </div>
                <div class="col">
                    <label for="Text" class="form-label">Email</label>
                    <input class="form-control" type="text" name="titre" placeholder="Votre adresse mail" aria-label="default input example" required>
                </div>
            </div>
            <!-- Contenue textarea-->
            <div class="mb-3">
                <label for="Textarea" class="form-label">Contenue de l'article</label>
                <textarea class="form-control" name="texte" placeholder="Contenue de votre article" id="exampleFormControlTextarea1" rows="3" required></textarea>
            </div>
            <!-- Bouton type submit-->
            <input type="submit" class="btn btn-primary" value="Commentez" name="bouton">
        </form>
    </div>
</div>