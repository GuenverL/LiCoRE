<!DOCTYPE html>
<html>
    <?php include("./views/layout/head.php"); ?>

    <body>
        <div id="wrap-content">

            <?php include("./views/layout/navbar-top.php"); ?>

            <div class="container" style="margin-top:30px;">
                <div class="row">
                    <div class="col-md-4">
                        <?php include("./views/liste-competences.php"); ?>
                    </div>

                    <div class="col-md-4">
                        <?php include("./views/competences_a_valider.php"); ?>
                    </div>

                    <div class="col-md-4">
                        <?php include("./views/arbre-competences.php"); ?>
                    </div>
                </div>
            </div>

        </div>

        <?php include("./views/layout/footer.php"); ?>

        <?php include("./views/layout/scripts.php"); ?>

    </body>

</html>
