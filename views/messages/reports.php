<!--
tu130060
sa130068
-->
<?php

if (isset($_SESSION['userID'])):?>

<!-- Modal -->
<div class="modal fade" id="message1-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel1">Prijavio: </h4>
                <h4 class="modal-title" id="report-title"><!--Vraca se preko ajaxa--></h4>
            </div>
            <div class="modal-body" id="report-body">
                <!--Vraca se preko ajaxa-->
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" onclick="sentence(this)" id="report-action" class="btn btn-primary"><!--Vraca se preko ajaxa--></button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>        
            </div>
        </div>
    </div>
</div>



<div class="page container">
<ul class="nav nav-tabs">
  <li><a href="<?php echo site_url()."/user/profile/".$_SESSION['userID']; ?>">Profil</a></li>
  <li><a href="<?php echo site_url()."/user/passwordchange/".$_SESSION['userID']; ?>">Lozinka</a></li>
  <li><a href="<?php echo site_url()."/messages/inbox"; ?>">Poruke <span class="badge"><?php echo $numOfMessages; ?></span></a></li>
  <li class="active"><a href="">Prijave <span class="badge"><?php echo $numOfReports; ?></span></a></li>
</ul>


<div class = "col-xs-6 col-xs-offset-3 messages">
    <?php
    $start = ($page - 1) * 10;
    $end = ($page * 10 < sizeof($reports) ? $page * 10 : sizeof($reports));
    for($cnt = $start; $cnt < $end; $cnt++):?>
        <div class="row message <?php if (!$reports[$cnt]['read']): echo "unread"; endif; ?>">
            Protiv: 
            <a href="<?php echo site_url()."/user/profile/".$reports[$cnt]['idReported']; ?>">
                <?php echo $reports[$cnt]['nameReported']; ?>
            </a>
            <span class="subject-message">
                Od:
                <a onclick="getReport(this)" id="<?php echo $reports[$cnt]['idReport']; ?>" data-toggle="modal" data-target="#message1-modal" href="#">
                    <?php echo $reports[$cnt]['nameReporting']; ?>
                </a>
            </span>
            <span class="date-message">
                Stigla: <?php echo $reports[$cnt]['date']; ?>
            </span>
        </div>
    <?php
    endfor;?>
	<ul class="pager">
        <?php 
        $e = $page - 1;
        if ($e > 0):?>
 	<li><a href="<?php echo site_url()."/messages/reports/".$e; ?>">Previous</a></li>
        <?php endif;
        $e = $page + 1;
        if ($e < $total):?>
  	<li><a href="<?php echo site_url()."/messages/reports/".$e; ?>">Next</a></li>
        <?php endif; ?>
	</ul>
</div>
</div>
<?php
endif;?>