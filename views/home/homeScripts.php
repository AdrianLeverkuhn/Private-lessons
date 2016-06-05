<!--
tu130060
sa130068
-->
<meta charset="UTF-8">
	<title>Document</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/psi.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<!--Funkcije za podesavanje ocena preporucenih predavaca na responzivnoj stranici-->
	<script>
	$( window ).resize(function() {
 			 $( ".grade" ).each(function() {
 			 	$(this).width($(this).siblings(".tut-image").first().width());
 			 	var a = parseInt($(this).siblings(".tut-image").first().css("margin-left"));
 			 	$(this).css("left",15 + a + "px");
 			 });
		});

	$( window ).load(function() {
 			 $( ".grade" ).each(function() {
 			 	$(this).width($(this).siblings(".tut-image").first().width());
 			 	var a = parseInt($(this).siblings(".tut-image").first().css("margin-left"));
 			 	$(this).css("left",15 + a + "px");
 			 });
		});
	</script>

	<meta name="viewport" content="width=device-width, initial-scale=1">