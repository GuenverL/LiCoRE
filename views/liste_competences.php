<div class="panel panel-default">
    <div class="panel-heading">
        Liste des compétences
    </div>
    <div class="panel-body">

        <ul class="treeview">
            <li><a href="#">Liste des compétences</a>
                <ul>
                    <?php
                    foreach($categories as $categorie) {
                        echo '<li><a href="#">';
                        echo $categorie.nom;
                        echo '</a>';
                        if(!empty($categorie.mentions)) {
                            echo '<ul>';
                            foreach($categorie.mentions as $mention) {
                                echo '<li><a href="#">';
                                echo $mention;
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
