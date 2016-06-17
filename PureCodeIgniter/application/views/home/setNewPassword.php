<!--
tu130060
sa130068
-->

<div class="loginPage container">
    <div class=" col-sm-offset-1 col-sm-5">
        <h3>Unesite novu Lozinku</h3>
        <form id="passwordchange-form" role="form" action="<?php echo site_url("home/attemptSetNewPassowrd"); ?>" method="post">
            <?php
            if ($failed & EMPTYPASSWORD):
                echo '<div class="error-message">Unesite lozinku</div>';
            elseif ($failed & PASSWORDFORMAT):
                echo '<div class="error-message">Lozinka mora da sadrži najmanje 8 karaktera i barem jedan broj</div>';
            endif;
            ?>
            <div class="form-group">
                <label for="password">Lozinka</label>
                <input type="password" class="form-control" name="pass" id="email"/>
            </div>
            
            <?php
            if ($failed & EMPTYPASSWORDCONFIRM):
                echo '<div class="error-message">Morate potvrditi lozinku</div>';
            elseif ($failed & PASSWORDMATCH):
                echo '<div class="error-message">Lozinke se moraju poklapati</div>';
            endif;
            ?>
            <div class="form-group">
                <label for="password-confirm">Ponovljena Lozinka</label>
                <input type="password" name="pass1" class="form-control" id="password"/>
            </div>

            <button type="submit"  class="btn btn-lg btn-primary">Promeni lozinku se</button>
        </form>
    </div>

<div class="hidden-xs col-sm-6 col-md-5 col-lg-4 col-lg-offset-1">
<img src="<?php echo base_url(); ?>img/sloth.png" class="img-responsive center-block" >
</div>

</div>
<script>
$(document).ready(function() {
	$("#passwordchange-form").validate({
				rules: {
					"pass": {required: true, minlength:8},
					"pass1": {required: true, minlength:8, equalTo:"#password"},
				},
				messages: {
					"password": {required: "Unesite lozinku!", minlength:"Lozinka mora sadržati najmanje 8 karaktera!"},
					"password-confirm": {required: "Potvrdite lozinku", minlength:"Lozinka mora sadržati najmanje 8 karaktera!", equalTo:"Lozinke se ne podudaraju!"},
				}
			});
});

</script>

