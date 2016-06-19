<!--
tu130060
sa130068
-->
<div class="container main-body">

<div class="col-sm-5 col-sm-offset-1 student-register">

<form id="student-form" role="form" action="<?php echo site_url("home/attemptReister"); ?>" method="post">
	<div class="form-group">
			<label class="control-label" for="student-nick">Nadimak</label>
			<input  class="form-control" name="nick" id="student-nick"/>
			<?php
                        if(($failed & TUTOR) == 0 && ($failed & NICKNAME) != 0):
                            echo '<div class="error-message">Nadimak je ili već zauzet ili ima preko 20 karaktera</div>';
                        endif;
                        ?>
	</div>

	<div class="form-group">
		<label for="student-email">E-mail</label>
		<input type="email" name="email" class="form-control" id="student-email" placeholder="email@email.com">
                <?php
                if (($failed & TUTOR) == 0 && ($failed & EMAILFORMAT) != 0):
                    echo '<div class="error-message">Email je u pogrešnom formatu</div>';
                elseif (($failed & TUTOR) == 0 && ($failed & EMAIL) != 0):
                    echo '<div class="error-message">Email je već zauzet</div>';
                endif;
                ?>
	</div>

	<div class="form-group">
		<label for="student-password">Lozinka</label>
		<input type="password" name="pass" class="form-control" id="student-password">
                <?php
                if(($failed & TUTOR) == 0 && ($failed & PASSWORDFORMAT) != 0):
                    echo '<div class="error-message">Lozinka ne ispunjava uslove</div>';
                endif;
                ?>
	</div>

	<div class="form-group">
		<label for="student-password-confirm">Ponovljena lozinka</label>
		<input type="password" name="pass2" class="form-control" id="student-password-confirm">
                <?php
                if(($failed & TUTOR) == 0 && ($failed & PASSWORDMATCH) != 0):
                    echo '<div class="error-message">Lozinke se ne podudaraju</div>';
                endif;
                ?>
	</div>

	<button type="submit" name="submit" value="student" class="btn btn-lg btn-default">Postani korisnik</button>
</form>
</div>

<div class="col-sm-5 tutor-register">
<form role="form" id="tutor-form" action="<?php echo site_url("home/attemptReister"); ?>" method="post">
	<div class="form-group">
                <?php
                if(($failed & TUTOR) != 0 && ($failed & REALNAME) != 0):
                    echo '<div class="error-message">Imena smeju da sadrže samo slova</div>';
                endif;
                ?>
		<label for="tutor-name">Ime</label>
		<input class="form-control" name="ime" id="tutor-name" placeholder="Petar" required>
	</div>

	<div class="form-group">
                <?php
                if(($failed & TUTOR) != 0 && ($failed & REALNAME) != 0):
                    echo '<div class="error-message">Imena smeju da sadrže samo slova</div>';
                endif;
                ?>
		<label for="tutor-surname">Prezime</label>
		<input class="form-control" name="prezime" id="tutor-name" placeholder="Petrovic" required>
	</div>

	<div class="form-group">
		<label for="email">E-mail</label>
		<input type="email" name="email" class="form-control" id="tutor-email" placeholder="email@email.com" required>
                <?php
                if (($failed & TUTOR) != 0 && ($failed & EMAILFORMAT) != 0):
                    echo '<div class="error-message">Email je u pogrešnom formatu</div>';
                elseif (($failed & TUTOR) != 0 && ($failed & EMAIL) != 0):
                    echo '<div class="error-message">Email je već zauzet</div>';
                endif;
                ?>
	</div>

	<div class="form-group">
		<label for="password">Lozinka</label>
		<input type="password" name="pass" class="form-control" id="tutor-password" minlength="8" required>
		<?php
                if(($failed & TUTOR) != 0 && ($failed & PASSWORDFORMAT) != 0):
                    echo '<div class="error-message">Lozinka ne ispunjava uslove</div>';
                endif;
                ?>
	</div>

	<div class="form-group">
		<label for="password-confirm">Ponovljena lozinka</label>
		<input type="password" name="pass2" class="form-control" id="tutor-password-confirm" minlength="8"  required>
		<?php
                if(($failed & TUTOR) != 0 && ($failed & PASSWORDMATCH) != 0):
                    echo '<div class="error-message">Lozinke se podudaraju</div>';
                endif;
                ?>
	</div>
    
        <div class="form-group">
		<label for="tutor-city">Grad</label>
                <select name="city" class="form-control" id="tutor-city">
                    <?php
                    foreach (CITIES as $city):
                        echo '<option id="' . $city . '" value="' . $city . '">' . $city . '</option>';
                    endforeach;
                    ?>
                </select>
	</div>

	<div class="form-group">
                <?php
                if(($failed & TUTOR) != 0 && ($failed & PHONE) != 0):
                    echo '<div class="error-message">Unesite validan telefon</div>';
                endif;
                ?>
		<label for="tutor-phone">Telefon</label>
		<input type="number" class="form-control" id="tutor-phone" name="phone">
	</div>

	<button type="submit" name="submit" value="tutor" class="btn btn-lg btn-primary">Postani predavač</button>
</form>

</div>
</div>

<script>
$(document).ready(function() {
	$("#student-form").validate({
				rules: {
					"nick": {required: true},
					"email": {required: true, email:true},
					"pass": {required: true, minlength:8},
					"pass2": {required: true, minlength:8, equalTo:"#student-password"},
				},
				messages: {
					"student-password-confirm": {required: "Unesite lozinku!", minlength:"Lozinka mora sadržati najmanje 8 karaktera!", equalTo:"Lozinke se ne podudaraju!"},
					"student-password": {required: "Unesite lozinku!", minlength:"Lozinka mora sadržati najmanje 8 karaktera!"},
					"student-email": {required: "Unesite e-mail!", email:"Unesite ispravan e-mail!"},
					"student-nick": {required: "Unesite nadimak!"}
				}
			});
                        
        $("#tutor-form").validate({
				rules: {
					"ime": {required:true},
					"prezime": {required:true},
					"email": {required: true, email:true},
					"pass": {required: true, minlength:8},
					"pass2": {required: true, minlength:8, equalTo:"#tutor-password"},
					"tutor-phone": {required: true, minlength:6, digits:true}
				},
				messages: {
					"tutor-password-confirm": {required: "Unesite lozinku!", minlength:"Lozinka mora sadržati najmanje 8 karaktera!", equalTo:"Lozinke se ne podudaraju!"},
					"tutor-password": {required: "Unesite lozinku!", minlength:"Lozinka mora sadržati najmanje 8 karaktera!"},
					"tutor-email": {required: "Unesite e-mail!", email:"Unesite ispravan e-mail!"},
					"tutor-name": {required: "Unesite ime!"},
					"tutor-surname": {required: "Unesite prezime!"},
					"tutor-phone": {required: "Unesite broj telefona!", minlength:"Broj telefona mora da ima najmanje 6 cifara!", digits:"Broj telefona sme da sadrzi samo cifre!"}
				}
			});
    });
</script>