<div class="panel panel-default">
    <div class="panel-heading">
        Liste des compétences
    </div>
    <div class="panel-body">
        <ul class="treeview">
            <li><a href="#">Liste des compétences</a>
                <ul>
                    <li><a href="#">Disciplinaires</a>
                        <ul>
                            <li><a href="#">Mathématiques</a></li>
                            <li><a href="#">Physique, chimie</a></li>
                            <li><a href="#">Sciences de la vie</a></li>
                            <li><a href="#">Sciences pour l'ingénieur</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Préprofessionnelles</a></li>
                    <li><a href="#">Transversales et linguistiques</a></li>
                </ul>
            </li>
        </ul>

        <ul class="treeview">
            <li><a href="#">Liste des compétences</a>
                <ul>
                    <li><a href="#">Disciplinaires</a>
                        <?php
                        foreach($mentions as $mention) {
                            echo '<li><a href="#">';
                            echo $mention;
                            echo '</a></li>';
                        }
                        ?>
                    </li>
                    <li><a href="#">Préprofessionnelles</a></li>
                    <li><a href="#">Transversales et linguistiques</a></li>
                </ul>
            </li>
        </ul>

    </div>
</div>
