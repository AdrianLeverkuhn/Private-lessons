<!--
tu130060
sa130068
-->
<meta charset="UTF-8">
<title>Document</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/css/psi.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/css/star-rating-svg.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/css/jasny-bootstrap.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>/js/jquery.star-rating-svg.js"></script>
<script src="<?php echo base_url(); ?>/js/jasny-bootstrap.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>   

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

<meta name="viewport" content="width=device-width, initial-scale=1">


<script>
    function getMessage(ele) {
        var id = ele.id;
        var subject = document.getElementById("message-title");
        subject.innerHTML = ele.innerHTML;
        var subj = document.getElementById("message-subject");
        subj.value = ele.innerHTML;
        var msg = document.getElementById("message-"+ele.id);
        msg.className = "row message";
        var link = document.getElementById("reply-form");
        link.action = "<?php echo site_url()."/messages/reply/"; ?>" + ele.name;
        var response = document.getElementById("message-respond");
        $.ajax({
            type:'POST',
            url:'<?php echo site_url() . "/messages/getmessagebody"; ?>',
            data:{'id': id},
            success:function(data){
                var bod = document.getElementById("message-body");
                bod.innerHTML = data;
            },
        });
    }
</script>

<script>
    function getReport(ele) {
        var id = ele.id;
        var subject = document.getElementById("report-title");
        subject.innerHTML = ele.innerHTML;
        $.ajax({
            type:'POST',
            url:'<?php echo site_url() . "/messages/getReportText"; ?>',
            data:{'id': id},
            success:function(data){
                var bod = document.getElementById("report-body");
                bod.innerHTML = data;
            },
        });
        var bod = document.getElementById("report-action");
        bod.name = ele.id;
        $.ajax({
            type:'POST',
            url:'<?php echo site_url() . "/messages/getReportBanned"; ?>',
            data:{'id': id},
            success:function(data){
                var bod = document.getElementById("report-action");
                bod.innerHTML = data;
            },
        });
    }
</script>

<script>
    function sentence(ele) {
        var id = ele.name;
        $.ajax({
            type:'POST',
            url:'<?php echo site_url() . "/user/sentence"; ?>',
            data:{'id': id},
            success:function(data){
                ele.innerHTML =data;
            },
        });
    }
</script>