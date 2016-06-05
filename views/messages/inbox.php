<!--
tu130060
sa130068
-->
<!-- Modal -->
<div class="modal fade" id="message1-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">

        <div class="modal-content">
            <form action="<?php echo site_url() . "/messages/reply";   ?>" method="post" id="reply-form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="message-title"></h4>
                    <input type="hidden" name="subject" id="message-subject"/>
                </div>
                <div id="message-body" class="modal-body">
                </div>
                <div class="form-group">
                    <label for="reason">Odgovor:</label>
                    <textarea name="text" id="reason"placeholder="Unesite Vaš odgovor..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Odgovori</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>        
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="message-send-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Pošalji poruku za:</br>
                    <?php
                    /*if ($isTutor):
                        echo $firstName . " " . $lastName;
                    else:
                        echo $displayName;
                    endif;*/
                    ?>
                </h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo site_url() . "/messages/send/" . $profileID; ?>" method="post">
                    <div class="form-group">
                        <label for="form-edit-name">Tema</label>
                        <input name="subject" id="form-edit-name" value="">
                        <label for="reason">Poruka:</label>
                        <textarea name="text" id="reason"placeholder="Unesite Vašu poruku..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Pošalji</button>
                    <button class="btn btn-default" data-dismiss="modal">Otkaži</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="page container">
<ul class="nav nav-tabs">
    <li><a href="<?php echo site_url()."/user/profile/".$_SESSION['userID']; ?>">Profil</a></li>
    <li><a href="<?php echo site_url()."/user/passwordchange/"; ?>">Lozinka</a></li>
    <li class="active"><a href="#">Poruke <span class="badge"><?php echo $numOfMessages; ?></span></a></li>
    <?php if ($isAdmin): ?>
      <li><a href="<?php echo site_url() . "/messages/reports"; ?>">Prijave <span class="badge"><?php echo $numOfReports; ?></span></a></li>
    <?php
    endif;
    ?>
</ul>

<!--
Moramo prvo bolje d aosmislimo jedinstvenost imena-->
<div class = "col-xs-6 col-sm-5 col-sm-offset-1">
	<form action="<?php echo site_url()."/messages/sendbyname/".$page; ?>" method="post" class="send-message-form">
		<div class="form-group">
			<label for="#recipient">To:</label>
                        <?php if ($fail == 1): ?>
                            <div class="error-message">Korisnik sa datim imenom ne postoji</div>
                        <?php endif; ?>
			<input name="sendTo" class="form-control" id="recipient" required>
		</div>

		<div class="form-group">
			<label for="#subject">Subject:</label>
			<input name="subject" class="form-control" id="subject" required>
		</div>

		<div class="form-group">
			<textarea name="content" class="form-control"></textarea>
		</div>

		<button type="submit" class="btn btn-default btn-lg">Pošalji</button>
	</form>
</div>

<div class = "col-xs-6 col-sm-5 messages">
    <?php
        $start = ($page - 1) * 10;
        $end = $page * 10 < sizeof($messages)? $page + 10: sizeof($messages);
        for($cnt = $start; $cnt < $end; $cnt++):
            echo '<div id = "message-';
            echo $messages[$cnt]['idPoruka'];
            echo '" class="row message ';
            if (!$messages[$cnt]['read']):
                echo 'unread';
            endif;
            echo '">Od: <a href="';
            echo site_url()."/user/profile/".$messages[$cnt]['senderId'];
            echo '">';
            echo $messages[$cnt]['senderName'];
            echo '</a> <span  class="subject-message">Subject: <a class="message-link" data-toggle="modal"';
            echo "id=".$messages[$cnt]['idPoruka'];
            echo ' onclick="getMessage(this)" data-target="#message1-modal" href="#" name="'.$messages[$cnt]['senderId'].'">';
            echo $messages[$cnt]['subject'];
            echo '</a></span> <span class="date-message">Stigla: ';
            echo $messages[$cnt]['dateSent'];
            echo '</span></div>';
	endfor;
    ?>
    <ul class="pager">
        <?php
        $e = $page-1;
        if ($e > 0):
        ?>
        <li><a href="<?php echo site_url()."/messages/inbox/".$e; ?>">Previous</a></li>
        <?php
        endif;
        $e = $page+1;
        if ($e <= $total):
        ?>
        <li><a href="<?php echo site_url()."/messages/inbox/".$e; ?>">Next</a></li>
        <?php
        endif;
        ?>
    </ul>
</div>
</div>