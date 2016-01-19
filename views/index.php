<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Projet Licore</title>
        <link href="./css/bootstrap.min.css" rel="stylesheet" />
        <link href="./css/bootstrap2-toggle.min.css" rel="stylesheet">
        <link href="./css/style.css" rel="stylesheet" />
    </head>

    <body>
        <div id="wrap-content">

            <?php include("./views/navbar_top.php"); ?>

            <div class="container" style="margin-top:30px;">
                <div class="row">
                    <div class="col-md-4">
                        <?php include("./views/liste_competences.php"); ?>
                    </div>

                    <div class="col-md-4">
                        <?php include("./views/competences_a_valider.php"); ?>
                    </div>

                    <div class="col-md-4">
                        <?php include("./views/arbre_competences.php"); ?>
                    </div>
                </div>
            </div>

        </div>

        <?php include("./views/footer.php"); ?>

        <script src="./js/jquery-1.11.3.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <script src="./js/bootstrap2-toggle.min.js"></script>
        <script src="./js/treeview.js"></script>
        <script src="./js/validationcompetences.js"></script>
    </body>

</html>
