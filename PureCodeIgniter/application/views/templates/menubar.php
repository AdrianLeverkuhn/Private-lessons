<!--
tu130060
sa130068
-->
</head>

<body>
<!-- Glavni meni-->
	<div class="nav navbar-default navbar-fixed-top" > <!--Navigacija-->
		<div class="container" > <!--Kontejner koji sadrzi oba reda i logo -->
			<div class="col-sm-10 col-sm-offset-1 menu-body" ><!--Telo menija. Zauzima kolone 2-11
			<!--Logo, buttons-->
			<div class="navbar-header col-sm-2"> <!--Logo i dugmad za prikaz u mobilnom rezimu-->
				
				<!--Dugme za prikaz prijave-->
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="glyphicon glyphicon-align-justify"></span>
				</button>
				<!--Dugme za prikaz pretrage-->
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="glyphicon glyphicon-search"></span>
				</button>
				<!--Logo-->
				<div class="navbar-brand"><a href = "<?php echo site_url(); ?>"><img src="<?php //echo site_url(); ?>/img/sloth2.png" class="sloth"></a></div>

			</div>
			

			<!-- Linkovi za prijavu i registraciju -->
			<!-- Ako je korisnik ulogovan, zameniti ih sa boldovanim nazivom korisnika koji vodi na profilnu stranu i linkom za odjavu-->
			<div class="col-sm-9">
				<div class="row collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<div class=" col-sm-offset-7 col-sm-7 col-md-offset-8 col-lg-offset-8">
						<ul class="nav navbar-nav logreg">
                                                    <?php 
                                                        if (isset($_SESSION['userID'])):?>
							<li><a href="<?php echo site_url()."/user/profile/".$_SESSION['userID']; ?>"><?php echo $_SESSION['userName']; ?></a></li>
							<li><a href="<?php echo site_url("home/logout"); ?>">Log out</a></li>
                                                    <?php
                                                        else:?>
                                                        <li><a href="<?php echo site_url("home/register"); ?>">Registracija</a></li>
							<li><a href="<?php echo site_url("home/login"); ?>">Prijava</a></li>
                                                    <?php
                                                        endif;?>
						</ul>
					</div>
				</div>

				<!-- Deo menija za pretragu -->
				<div class="row collapse navbar-collapse" id="bs-example-navbar-collapse-2">

						<form id="searchForm" action="<?php echo site_url()."/search"; ?>" method ="post" class="form-inline">

							<div class="form-group col-sm-5 col-md-7">
								<label class="sr-only" for="searchBoxMain">Traži</label>
								<input name="searchString" type="search" class="form-control" id="searchBoxMain"
                                                                        <?php
                                                                        if(isset($_SESSION['initialSearcgString'])):
                                                                            echo 'value="'.$_SESSION['initialSearcgString'].'"';
                                                                        else:
                                                                            echo 'placeholder="Traži"';
                                                                        endif;
                                                                        ?>>
							</div>


							<div class="col-sm-4 col-md-3">
								<select name="city" class="form-control select-city">
                                                                    <?php
                                                                    foreach (CITIES as $city):
                                                                        echo '<option id="' . $city . '" value="' . $city . '">' . $city . '</option>';
                                                                    endforeach;
                                                                    ?>
								</select>
							</div>

							<div class="col-sm-3 col-md-2">
								<button id="menuButton" type="submit" class="btn btn-primary btn-block">Traži</button>
							</div>

						</form>
							
				</div>

			</div>
			</div>
		</div>
	</div>

<!--menu end-->