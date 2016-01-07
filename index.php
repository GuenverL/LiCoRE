<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Projet Licore</title>
        <link href="./css/bootstrap.min.css" rel="stylesheet" />
        <link href="./css/style.css" rel="stylesheet" />
    </head>

    <body>

        <div class="container" style="margin-top:30px;">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
        <div class="panel-heading">Treeview List</div>
        <div class="panel-body">
            <!-- TREEVIEW CODE -->
            <ul class="treeview">
                <li><a href="#">Tree</a>
                	<ul>
            			<li><a href="#">Branch</a></li>
            			<li><a href="#">Branch</a>
            				<ul>
            					<li><a href="#">Stick</a></li>
            					<li><a href="#">Stick</a></li>
            					<li><a href="#">Stick</a>
            						<ul>
            							<li><a href="#">Twig</a></li>
            							<li><a href="#">Twig</a></li>
            							<li><a href="#">Twig</a></li>
            							<li><a href="#">Twig</a>
            								<ul>
            									<li><a href="#">Leaf</a></li>
            									<li><a href="#">Leaf</a></li>
            									<li><a href="#">Leaf</a></li>
            									<li><a href="#">Leaf</a></li>
            									<li><a href="#">Leaf</a></li>
            									<li><a href="#">Leaf</a></li>
            									<li><a href="#">Leaf</a></li>
            									<li><a href="#">Leaf</a></li>
            									<li><a href="#">Leaf</a></li>
            								</ul>
            							</li>
            							<li><a href="#">Twig</a></li>
            							<li><a href="#">Twig</a></li>
            						</ul>
            					</li>
            					<li><a href="#">Stick</a></li>
            				</ul>
            			</li>
            			<li><a href="#">Branch</a></li>
            			<li><a href="#">Branch</a></li>
            		</ul>
            	</li>
            </ul>
            <!-- TREEVIEW CODE -->
        </div>
    </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Compétences à valider</div>
                <div class="panel-body">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a role="button" data-toggle=collapse href="#collapseOne" aria-controls="collapseOne" aria-expanded="false">
                                        Compétence 1
                                    </a>
                                </h3>
                            </div>
                            <div id="collapseOne" class="collapse">
                                <div class="list-group">
                                    <button class="list-group-item" >sous-compétence 1-1</button>
                                    <button class="list-group-item" >sous-compétence 1-2</button>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a role="button" data-toggle=collapse href="#collapseTwo" aria-controls="collapseTwo" aria-expanded="false">
                                        Compétence 2
                                    </a>
                                </h3>
                            </div>
                            <div id="collapseTwo" class="collapse">
                                <div class="list-group">
                                    <button class="list-group-item" >sous-compétence 2-1</button>
                                    <button class="list-group-item" >sous-compétence 2-2</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <script src="./js/jquery-1.11.3.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <script src="./js/treeview.js"></script>
    </body>

</html>
