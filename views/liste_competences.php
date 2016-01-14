<div class="panel panel-default">
    <div class="panel-heading">
        Liste des compétences
    </div>
    <div class="panel-body">
        <?php var_dump($categories); ?>

        <ul class="treeview">
            <li><a href="#">Liste des compétences</a>
                <ul>
                    <?php
                    foreach($categories as $categorie) {
                        echo '<li><a href="#">';
                        echo ucfirst($categorie["nom"]);
                        echo '</a>';
                        if(!empty($categorie["mentions"])) {
                            echo '<ul>';
                            foreach($categorie["mentions"] as $mention) {
                                echo '<li><a href="#">';
                                echo ucfirst($mention);
                                echo '</a></li>';
                            }
                            echo '</ul>';
                        }
                        echo '</li>';
                    }
                    ?>
                </ul>
            </li>
        </ul>

    </div>
</div>
