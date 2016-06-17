<!--
tu130060
sa130068
-->
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


<script>
    function getDisciplines() {
        var subjects = document.getElementById("subject");
        var id = subjects.options[subjects.selectedIndex].value;
        if (id == "-1")
        {
            var disciplines = document.getElementById("disciplines");
            disciplines.innerHTML = "<option value=\"-1\">--</option>";
            return;
        }
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

<script>
    window.onload = function(){
        getDisciplines();
    }
</script>


<script>
    $(function () {

        // basic use comes with defaults values
        $(".my-rating").starRating({
            initialRating: 4,
            starSize: 25,
            readOnly: true
        });
    });
</script>