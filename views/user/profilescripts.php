<!--
tu130060
sa130068
-->
<?php
if ($loggedIn):
    if ($_SESSION['userID'] == $profileID):
        ?>
        <meta charset="UTF-8">
        <title>Document</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/css/psi.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/css/star-rating.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/css/jasny-bootstrap.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>/js/jquery.star-rating.js"></script>
        <script src="<?php echo base_url(); ?>/js/jasny-bootstrap.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>   

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <script>
            function getDisciplines() {
                var subjects = document.getElementById("subject");
                var id = subjects.options[subjects.selectedIndex].value;
                $.ajax({
                    type:'POST',
                    url:'<?php echo site_url() . "/search/getdisciplines"; ?>',
                    data:{'id':id},
                    success:function(data){
                        var disciplines = document.getElementById("disciplines");
                        disciplines.innerHTML = data;
                        //alert(data);
                    }
                });
            }
        </script>
        <?php
    elseif ($isAdmin):
        ?>
        <meta charset = "UTF-8">
        <title>Document</title>

        <!--Latest compiled and minified CSS -->
        <link rel = "stylesheet" href = "http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel = "stylesheet" href = "<?php echo base_url(); ?>/css/psi.css">
        <link rel = "stylesheet" href = "<?php echo base_url(); ?>/css/star-rating.css">

        <!--jQuery library -->
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>/js/jquery.star-rating.js"></script>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
    else:
        ?>
        <meta charset="UTF-8">
        <title>Document</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/css/psi.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/css/star-rating.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>/js/jquery.star-rating.js"></script>

        <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php
    endif;
else:
    ?>
    <meta charset="UTF-8">
    <title>Document</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/css/psi.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/css/star-rating.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>/js/jquery.star-rating.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
<?php
endif;
?>