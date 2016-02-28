<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Projet Licore - <?= $titre ?></title>
        <link href="./css/bootstrap.min.css" rel="stylesheet" />
        <link href="./css/style.css" rel="stylesheet" />
    </head>

    <body>

        <?php include(DOC_ROOT_PATH . '/views/layout/navbar-top.php'); ?>

        <div class="container">
            <div class="row">
                <?= $contenu ?>
            </div>
        </div>

        <?php include(DOC_ROOT_PATH . '/views/layout/footer.php'); ?>

        <?php include(DOC_ROOT_PATH . '/views/layout/scripts.php'); ?>

    </body>

</html>
