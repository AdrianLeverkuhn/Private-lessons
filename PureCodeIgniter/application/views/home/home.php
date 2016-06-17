<!--
tu130060
sa130068
-->
<div class="container no-padding">
<div class="col-sm-12">
<div class="row">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
      </ol>


      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img class="first-slide center-block" src="/img/slide1.jpg" alt="First slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Privatni časovi iz engleskog A1-C2<br/>Spremanje za CAE, CPE, TOEFL, IELTS</h1>
              <!--<p><a class="btn btn-lg btn-primary" href="#" role="button">Saznaj više</a></p>-->
            </div>
          </div>
        </div>
        <div class="item">
          <img class="second-slide center-block" src="/img/slide2.jpg" alt="Second slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Škola gitare za početnike</h1>
              <!--<p><a class="btn btn-lg btn-primary" href="#" role="button">Saznaj više</a></p>-->
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.carousel -->
    </div>
    </div>
</div>
<div class="predavaci container">
<div class="row"><h2 class="center-block">Preporučeni predavači</h2></div>
	<div class="row">
		<?php
			if (isset($results[0])):	
		?>

		<div class="col-sm-4">
		<a class="link-tutor" href="<?php echo site_url()."/user/profile/".$results['idTutor']; ?>">
			<img  src="<?php echo $results[0]['slika']; ?>" class="tut-image img-rounded img-responsive center-block" />
		
			<div class="grade">
			<div class="grade-name"><?php echo $results[0]['ime']; ?></div>
				<div class="grade-stars"<!--<?php echo $results[0]['ukupnaOcena']; ?>-->>
					<span class="glyphicon glyphicon-star"></span>
					<span class="glyphicon glyphicon-star"></span>
					<span class="glyphicon glyphicon-star"></span>
					<span class="glyphicon glyphicon-star"></span>
					<span class="glyphicon glyphicon-star"></span>
				</div>
			</div>
			</a>
		</div>
		<?php
		endif;
		if(isset($results[1])):
		?>
		<div class="col-sm-4">
		<a class="link-tutor" href="<?php echo site_url()."/user/profile/".$results['idTutor']; ?>">
			<img  src="<?php echo $results[1]['slika']; ?>" class="tut-image img-rounded img-responsive center-block" />
		
			<div class="grade">
			<div class="grade-name"><?php echo $results[1]['ime']; ?></div>
				<div class="grade-stars"<!--<?php echo $results[1]['ukupnaOcena']; ?>-->>
					<span class="glyphicon glyphicon-star"></span>
					<span class="glyphicon glyphicon-star"></span>
					<span class="glyphicon glyphicon-star"></span>
					<span class="glyphicon glyphicon-star"></span>
					<span class="glyphicon glyphicon-star"></span>
				</div>
			</div>
			</a>
		</div>
		<?php
		endif;
		if(isset($results[2])):
		?>
		<div class="col-sm-4">
		<a class="link-tutor" href="<?php echo site_url()."/user/profile/".$results['idTutor']; ?>">
			<img  src="<?php echo $results[2]['slika']; ?>" class="tut-image img-rounded img-responsive center-block" />
		
			<div class="grade">
			<div class="grade-name"><?php echo $results[2]['ime']; ?></div>
				<div class="grade-stars"<!--<?php echo $results[2]['ukupnaOcena']; ?>-->>
					<span class="glyphicon glyphicon-star"></span>
					<span class="glyphicon glyphicon-star"></span>
					<span class="glyphicon glyphicon-star"></span>
					<span class="glyphicon glyphicon-star"></span>
					<span class="glyphicon glyphicon-star"></span>
				</div>
			</div>
			</a>
		</div>
		<?php
		endif;
		?>
	</div>
	<div class="row">
	<div class="moreTeachers"><a href="#">...</a></div>
	</div>
</div>

<!--
<div class="rateTutorExample container">
	<div class="row"><h2>Oceni predavača</h2></div>
	<div class"row">
	
		<div class="col-sm-6 rating-custom">
		<div class="grade-stars">
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
		</div>

		<div class="reviewer">Ocenila Brana</div>
			<div class="review-example">
				<div class="review-text">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, corporis, pariatur. Accusamus ab animi laudantium quas doloremque error, sed itaque cumque similique minima illo tempora delectus, harum asperiores nihil perspiciatis<a href="#">...</a>
				</div>
				<div class="tutor-data-example">
					<div class="row"><div class="col-sm-4 col-md-3 col-lg-2">Predavač</div></div>
					<div class="row">
						<div class="col-xs-3 col-sm-4 col-md-3 col-lg-2"><a href="#"><img src="http://placehold.it/70x70" class="img-responsive"/></a></div>
						<div class="col-xs-4 col-sm-4"><a href="#">Igor T.<br/>Beograd</a></div>
					</div>
				</div>
			</div>
		</div>

	<div class="col-sm-6 rating-custom">
		<div class="grade-stars">
						<span class="glyphicon glyphicon-star-empty"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
	</div>
		<div class="reviewer">Ocenila Brana</div>
			<div class="review-example">
				<div class="review-text">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, corporis, pariatur. Accusamus ab animi laudantium quas doloremque error, sed itaque cumque similique minima illo tempora delectus, harum asperiores nihil perspiciatis<a href="#">...</a>
				</div>
				<div class="tutor-data-example">
					<div class="row"><div class="col-sm-4 col-md-3 col-lg-2">Predavač</div></div>
					<div class="row">
						<div class="col-xs-3 col-sm-4 col-md-3 col-lg-2"><a href="#"><img src="http://placehold.it/70x70" class="img-responsive"/></a></div>
						<div class="col-xs-4 col-sm-4"><a href="#">Igor T.<br/>Beograd</a></div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
-->
<div class="callToActionSection container">

	<div class="tutor-call">
		<h3>Držiš privatne časove?</h3>
		<p>Mi ćemo ti pomoći da preneseš svoje znanje</p>
		<button  type="submit" class="btn btn-primary btn-lg">Postani predavač</button>
	</div>

	<div class="student-call">
		<h3>Tražiš predavača?</h3>
		<p>Časovi matematike, engleskog, gitare, programiranja...</p>
		<button  type="submit" class="btn btn-default btn-lg">Nađi predavača</button>
	</div>
</div>

<footer class="container">

	<div class="col-sm-3"> 
		<ul>
		 	<li><h3>O nama</h3></li>
		 	<li><a href="#">Ko smo mi</a></li>
		 	<li><a href="#">Oglašavanje</a></li>
		 	<li><a href="#">FAQ</a></li>
		 	<li><a href="#">Kontakt</a></li>
		 	<li><a href="#">Privatnost podataka</a></li>
		 	<li><a href="#">Uslovi korišćenja</a></li>
		 </ul>
	 </div>


	<div class="col-sm-3">
		<ul>
		 	<li><h3>Privatni časovi</h3></li>
		 	<li><a href="#">Nađi profesora</a></li>
		 	<li><a href="#">Postani predavač</a></li>
		 	<li><a href="#">Registruj se</a></li>
		 </ul>
	</div>

	<div class="col-sm-3">
		<ul>
		 	<li><h3>Predmeti</h3></li>
		 	<li><a href="#">Matematika</a></li>
		 	<li><a href="#">Fizika</a></li>
		 	<li><a href="#">Hemija</a></li>
		 	<li><a href="#">Programiranje</a></li>
		 	<li><a href="#">Engleski jezik</a></li>
		 	<li><a href="#">Još predmeta...</a></li>
		 </ul>	
	</div>

	<div class="col-sm-3">
			<ul>
		 	<li><h3>Škole</h3></li>
		 	<li><a href="#">Osnovna škola</a></li>
		 	<li><a href="#">Srednja škola</a></li>
		 	<li><a href="#">ETF</a></li>
		 	<li><a href="#">MATF</a></li>
		 	<li><a href="#">FON</a></li>
		 	<li><a href="#">FTN</a></li>
		 	<li><a href="#">Još škola...</a></li>
		 </ul>
	</div>
</footer>

</body>
</html>