<!--
tu130060
sa130068
-->

<!-- Telo strane-->
<div class="page container">
<ul class="nav nav-tabs"> <!-- Tabovi-->
    <li><a href="<?php echo site_url()."/user/profile/".$_SESSION['userID']; ?>">Profil</a></li><!--Vodi ka profilu-->
    <li class="active"><a href="#">Lozinka</a></li><!-- Aktivna stranica za izmenu lozinke-->
    <li><a href="<?php echo site_url()."/messages/"; ?>">Poruke <span class="badge"><?php echo $numOfMessages; ?></span></a></li><!-- Vodi do strane za slanje/pregled poruka-->
    <?php
        if ($isAdmin):?>
            <li><a href="<?php echo site_url()."/messages/reports"; ?>">Prijave <span class="badge"><?php echo $numOfReports; ?></span></a></li>
        <?php
        endif;
        ?>
</ul>

<div class = "col-xs-12 col-sm-5 col-md-4 col-lg-3">
	<form class="change-password-form" action="<?php echo site_url()."/user/attemptPasswordChange"; ?>" method="post"><!--Formular za promenu lozinke-->
                <?php
                    if($failed & WRONGPASSWORD):
                        echo '<div class="error-message">Netačna lozinka</div>';
                    endif;
                ?>
		<div class="form-group">
			<label for="#old-password">Stara lozinka</label>
			<input name="oldPass" class="form-control" id="old-password" type="password">
		</div>
                
                <?php
                    if($failed & WRONGPASSWORDFORMAT):
                        echo '<div class="error-message">Lozinka ne zadovoljava format</div>';
                    endif;
                ?>
		<div class="form-group">
			<label for="#new-password1">Nova lozinka</label>
			<input name="newPass" class="form-control" id="new-password1" type="password">
		</div>
                
                <?php
                    if($failed & PASSWORDNOMATCH):
                        echo '<div class="error-message">Lozinke se ne poklapaju</div>';
                    endif;
                ?>
		<div class="form-group">
			<label for="new-password2">Ponovljena nova lozinka</label>
			<input name="newPass1" class="form-control" id="new-password2" type="password">
		</div>

		<button type="submit" class="btn btn-default btn-lg">Promeni lozinku</button>
	</form>
</div>

</div>
<script>
$(document).ready(function() {
	$(".change-password-form").validate({
				rules: {
					"oldPass": {required: true, minlength:8},
					"newPass": {required: true, minlength:8},
					"newPass1": {required: true, minlength: 8, equalTo:"#new-password1"}
				},
				messages: {
					"oldPss": {required: "Unesite staru lozinku!", minlength:"Lozinka mora sadržati najmanje 8 karaktera!"},
					"newPass": {required: "Unesite novu lozinku!", minlength:"Lozinka mora sadržati najmanje 8 karaktera!"},
					"newPass1": {required: "Unesite novu lozinku!", minlength:"Lozinka mora sadržati najmanje 8 karaktera!", equalTo:"Lozinke se ne podudaraju!"}
				}
			});
});

</script>