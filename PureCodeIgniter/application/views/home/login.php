<!--
tu130060
sa130068
-->

<div class="loginPage container">
<div class=" col-sm-offset-1 col-sm-5">
<h3>Prijava</h3>
    <?php
    if ($loginFailed == 1):
        echo '<div class="error-message">Kombinacija e-mail - lozinka je pogrešna</div>';
    elseif ($loginFailed == -1):
        echo '<div class="error-message">Zbog prijava protiv Vas, morali smo da Vam zabranimo pristup našem sajtu.</div>';
    endif; ?>
	<form id="login-form" role="form" action="<?php echo site_url("home/attemptLogIn"); ?>" method="post">
	
		<div class="form-group">
			<label for="email">E-mail</label>
			<input type="email" class="form-control" name="email" id="email" placeholder="email@email.com"/>
		</div>

		<div class="form-group">
			<label for="password">Lozinka</label>
			<input type="password" name="pass" class="form-control" id="password"/>
		</div>

		<button type="submit"  class="btn btn-lg btn-primary">Prijavi se</button>
	</form>
	<div class="moreLogin">
		<p>
                    <a href="<?php echo site_url()."/home/passwordRecovery"; ?>">Zaboravili ste lozinku?</a> | 
                    <a href="<?php echo site_url()."/home/register"; ?>">Registruj se</a>
                </p>
	</div>
</div>

<div class="hidden-xs col-sm-6 col-md-5 col-lg-4 col-lg-offset-1">
<img src="<?php echo base_url(); ?>img/sloth.png" class="img-responsive center-block" >
</div>

</div>
<script>
$(document).ready(function() {
	$("#login-form").validate({
				rules: {
					"email": {required: true, email:true},
					"pass": {required: true, minlength:8},
				},
				messages: {
					"password": {required: "Unesite lozinku!", minlength:"Lozinka mora sadržati najmanje 8 karaktera!"},
					"email": {required: "Unesite e-mail!", email:"Unesite ispravan e-mail!"},
				}
			});
});

</script>