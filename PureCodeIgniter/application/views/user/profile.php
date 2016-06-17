<!--
tu130060
sa130068
-->
<?php
    if ($loggedIn)
    {
        ?>
        <div class="modal fade" id="message-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Pošalji poruku za:</br>
                                <?php
                                if ($isTutor):
                                    echo $firstName . " " . $lastName;
                                else:
                                    echo $displayName;
                                endif;
                                ?>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo site_url() . "/messages/send/". $profileID; ?>" method="post">
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
<?php
        
        if ($_SESSION['userID'] == $profileID)
        {
            ?>
<!--Change profile info. ID = profile-modal-->
        <div id="profile-modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Izmeni osnovne podatke</h4>
                    </div>
                    <form action="<?php echo site_url();
                                        echo $isTutor?
                                                "/user/editinfo/".$_SESSION['userID']:
                                                "/user/becometutor/".$_SESSION['userID'];?>"
                        method="post" enctype="multipart/form-data">
                        <div class="modal-form-left">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 150px; height: 150px;"><img src="<?php echo $image; ?>"></div>
                                <div>
                                    <span class="btn btn-default btn-file"><span class="fileinput-new">Odaberi sliku</span><span class="fileinput-exists">Izmeni</span><input name="userfile" id="new-profile-image"type="file" ></span>
                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Ukloni</a>
                                </div>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="onAddress" type="checkbox" id="form-addr-chk" value="Yes" 
                                            <?php
                                            if ($onAddress):
                                                echo 'checked';
                                            endif;
                                            ?>>
                                    Dolazim na adresu
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="online" type="checkbox" id="form-onl-chk" value="Yes" 
                                            <?php
                                            if ($online):
                                                echo 'checked';
                                            endif;
                                            ?>>
                                    Držim online časove
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="group" type="checkbox" id="form-grp-chk" value="Yes" 
                                            <?php
                                            if ($group):
                                                echo 'checked';
                                            endif;
                                            ?>>
                                    Držim grupne časove
                                </label>
                            </div>
                        </div>

                        <div class="modal-form-right">
                            <div class=form-group>
                                <label for="form-edit-name">Ime</label>
                                <input name="fname" id="form-edit-name" value="<?php echo $firstName; ?>">
                            </div>
                            <div class=form-group>
                                <label for="form-edit-surname">Prezime</label>
                                <input name="lname" id="form-edit-surname" value="<?php echo $lastName; ?>">
                            </div>
                            <div class=form-group>
                                <label for="form-edit-city">Grad</label>
                                <select name="city" id="form-edit-city">
                                    <?php
                                    foreach (CITIES as $city):
                                        echo '<option id="'.$city.'" value="'.$city.'">'.$city.'</option>';
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                            <div class=form-group>
                                <label for="form-edit-email">Email</label>
                                <input name="email" id="form-edit-email" value="<?php echo $email; ?>">
                            </div>
                            <div class=form-group>
                                <label for="form-edit-phone">Telefon</label>
                                <input name="phone" id="form-edit-phone" value="<?php echo $contact; ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Izađi</button>
                            <button type="submit" class="btn btn-primary" value="upload">Sačuvaj</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <?php
            if ($isTutor):
                ?>
<!--Change biography. ID = bio-modal-->
        <div id="bio-modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Izmeni biografiju</h4>
                    </div>
                    <form action="<?php echo site_url()."/user/editbio/".$_SESSION['userID']; ?>" method="post">
                        <textarea name="biography" id="edit-bio-textarea"><?php echo $biography; ?></textarea>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Izađi</button>
                            <button type="submit" class="btn btn-primary">Sačuvaj</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
<!--Add a tutoring type. ID = tutor-modal-->
        <div id="tutor-modal" class="modal  fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Dodaj čas</h4>
                    </div>
                    <form action="<?php echo site_url()."/user/addadvert/"; ?>" method="post">
                        <div class=form-group>
                            <label for="form-edit-subject">Oblast</label>
                            <select name="subject" id="subject" onload="getDisciplines()" onchange="getDisciplines()">
                            <?php
                            foreach ($subjects as $subject):
                                echo "<option id=\"".$subject['idPredmet']."\" value=\"".$subject['idPredmet']."\">" . $subject['naziv'] . "</option>";
                            endforeach;
                            ?>
                        </select>
                        <select name="disciplines" id="disciplines">
                            
                        </select>
                        </div>

                        <!--<div class=form-group>
                            <label for="form-edit-topic">Podoblast</label>
                            <select name="discipline" id="form-edit-topic"> <!--Placeholder dok ne uradim JS za ovo-->
                                <!--<option>Operativni sistemi</option>
                                <option>C/C++</option>
                                <option>Pascal</option>
                                <option>Web development</option>
                            </select>
                        </div>-->

                        <div class=form-group>
                            <label for="form-edit-price">Cena (u RSD)</label>
                            <input name="price" id="form-edit-price" type="number" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Izađi</button>
                            <button type="submit" class="btn btn-primary">Sačuvaj</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
<!--Add a work experience. ID = work-modal-->
        <div id="work-modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Dodaj radno iskustvo</h4>
                    </div>
                    <form action="<?php echo site_url()."/user/addjob/".$_SESSION['userID']; ?>" method="post">
                        <div class=form-group>
                            <label for="form-edit-job">Naziv posla</label>
                            <input name="jobName" id="form-edit-job" required>
                        </div>

                        <div class=form-group>
                            <label for="form-edit-employer">Poslodavac</label>
                            <input name="employer" id="form-edit-employer" required>
                        </div>

                        <div class=form-group>
                            <label for="#datetimepicker1">Od:</label>
                            <div class='input-group date' id='datetimepicker1'>
                                <input name="startDate" type='text' class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                        <div class=form-group>
                            <label for="#datetimepicker2">Do:</label>
                            <div class='input-group date' id='datetimepicker2'>
                                <input name="endDate" id="datetimepicker2-input" type='text' class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class=form-group>
                            <input name="stillWorking" type="checkbox" id="present-checkbox">
                            <label id="present-label" for="#present-checkbox">Još traje</label>  	
                        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Sačuvaj</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Izađi</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
<!--Add education. ID = edu-modal-->
        <div id="edu-modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Dodaj obrazovanje</h4>
                    </div>
                    <form action="<?php echo site_url()."/user/addeducation/".$_SESSION['userID']; ?>" method="post">
                        <div class=form-group>
                            <label for="form-edit-edu">Naziv</label>
                            <input name="name" id="form-edit-edu" required>
                        </div>

                        <div class=form-group>
                            <label for="form-edit-institution">Institucija</label>
                            <input name="school" id="form-edit-institution" required>
                        </div>

                        <div class=form-group>
                            <label for="#datetimepicker3">Datum:</label>
                            <div class='input-group date' id='datetimepicker3'>
                                <input name="startDate" type='text' class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                        <div class=form-group>
                            <label for="#datetimepicker4">Do:</label>
                            <div class='input-group date' id='datetimepicker4'>
                                <input name="endDate" id="datetimepicker4-input" type='text' class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class=form-group>
                            <input name="ongoing" type="checkbox" id="present-checkbox-2">
                            <label id="present-label" for="#present-checkbox-2">Još traje</label>  	
                        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Sačuvaj</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Izađi</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
<!--Add a certificate. ID = cert-modal-->
        <div id="cert-modal" class="modal  fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Dodaj sertifikat</h4>
                    </div>
                    <form action="<?php echo site_url()."/user/addcertificate/".$_SESSION['userID']; ?>" method="post">
                        <div class="form-group">
                            <label for="form-certificate-name">Naziv sertifikata</label>
                            <input name="name" id="form-certificate-name" required>
                        </div>

                        <div class="form-group">
                            <label for="form-certificate-institution">Naziv institucije</label>
                            <input name="institution" id="form-certificate-institution" required>
                        </div>

                        <div class=form-group>
                            <div class=form-group>
                                <label for="#datetimepickercert">Do:</label>
                                <div class='input-group date' id='datetimepickercert'>
                                    <input name="expires" id="datetimepickercert-input" type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Izađi</button>
                            <button type="submit" class="btn btn-primary">Sačuvaj</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
            <?php
            endif;
        }
        else
        {
            ?>
<!--Report a user. ID = report-modal-->
            <div class="modal fade" id="report-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Prijavi korisnika</h4>
                            </div>
                            <div class="modal-body">
                                <form action="<?php echo site_url()."/user/report/".$profileID; ?>" method="post">
                                    <div class="form-group">
                                        <label for="reason">Razlog prijave</label>
                                        <textarea name="reason" id="reason"placeholder="Želim da prijavim korisnika zbog..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Prijavi</button>
                                    <button class="btn btn-default" data-dismiss="modal">Otkaži</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
        }
    }
?>

<div class="page container">
    <?php
    if($loggedIn && $_SESSION['userID'] == $profileID):
    ?>
        <ul class="nav nav-tabs">
            <li class="active"><a href="<?php echo site_url()."/user/profile/".$profileID; ?>">Profil</a></li>
            <li><a href="<?php echo site_url()."/user/passwordchange/"; ?>">Lozinka</a></li>
            <li><a href="<?php echo site_url()."/messages/"; ?>">Poruke <span class="badge"><?php echo $numOfMessages; ?></span></a></li>
            <?php
            if ($isAdmin):?>
                <li><a href="<?php echo site_url()."/messages/reports"; ?>">Prijave <span class="badge"><?php echo $numOfReports; ?></span></a></li>
            <?php
            endif;
            ?>
        </ul>
    <?php
    endif;
    ?>
    <div class="col-sm-12 col-md-10 col-md-offset-1">

        <div class="row basic-profile"><!--Kartica sa osnovnim podacima-->
            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 no-padding-left"><img src="<?php echo $image;?>" class="img-responsive img-rounded"></div><!--Slika-->
            <div class="col-xs-4 col-sm-5 col-md-5 col-lg-5">
                <div class="row"><div class="profile-name"
                    <?php
                    if (strlen($firstName) + strlen($lastName) + 1 >= 20):
                        ?>
                                          style="font-size: 1.3em;"

                                          <?php
                                      elseif (strlen($firstName) + strlen($lastName) + 1 >= 25):
                                          ?>
                                          style="font-size: 1em;"

                                          <?php
                                      endif;
                                      ?>>
                                      <?php
                                      if ($isTutor):
                                          echo $firstName . " " . $lastName;

                                      else:
                                          echo $displayName;
                                      endif;
                                      ?>
                    </div>

                    <?php
                        if ($loggedIn):
                            if ($profileID == $_SESSION['userID']):
                            ?>
                                <a href="#" data-toggle="modal" data-target="#profile-modal" ><div class="glyphicon glyphicon-pencil"></div></a>
                            <?php
                            else:
                                if ($isAdmin):
                                    if ($banned):
                                        ?>
                                        <a href="<?php echo site_url() . "/user/unban/" . $profileID; ?>" ><div class="glyphicon glyphicon-ok"></div></a>
                                    <?php else:
                                    ?>
                                        <a href="<?php echo site_url() . "/user/ban/" . $profileID; ?>" ><div class="glyphicon glyphicon-remove"></div></a>
                                <?php
                                    endif;
                                else:
                                    ?>
                                    <a href="#" data-toggle="modal" data-target="#report-modal" ><div class="glyphicon glyphicon-flag"></div></a>
                                <?php
                                endif;
                            endif;
                        endif;
                    ?>
                </div>
                
                <div class="row">
                    <div class="profile-city"><?php echo $region;?></div>
                </div>

                <div class="row">
                    <div class="profile-email"><?php echo $email;?></div>
                </div>

                <div class="row">
                    <div class="profile-phone"><?php echo $contact;?></div>
                </div>
                </div>

                


            
            <div class="rate-data col-xs-3 col-sm-3 col-md-2 col-lg-2 pull-right">
                <?php
                if($isTutor):
                echo '<div class="row"><!--Bedzevi koje ima korisnik-->';
                if ($onlineClass)
                {
                    echo "<div class=\"glyphicon glyphicon-globe\"></div>";
                }
                /*if ($userModel['heart'])
                {
                    echo '<div class="glyphicon glyphicon-heart"></div>';
                }
                if ($userModel['check'])
                {
                    echo '<div class="glyphicon glyphicon-check"></div>';
                }*/
                if ($onAddressClass)
                {
                    echo '<div class="glyphicon glyphicon-home"></div>';
                }
                if ($groupClass)
                {
                    echo '<div class="glyphicon glyphicon-user"></div>';
                }
                echo '</div>';
                ?>
                <div class="row">
                    <div class="my-rating">
                    <div class="my-rating"><input id="input-7-xs" name="input-7" class="rating rating-loading"  value="<?php echo $rating / 2;?>" data-min="0" data-max="5" data-step="0.5" data-display-only="true" data-size="xxs"></input></div>
                </div>
                </div>
                <?php
                endif;
                if($loggedIn && $_SESSION['userID'] != $profileID):?>
                <div class="row">
                    <!--TO DO-->
                    <a data-toggle="modal" data-target="#message-modal" href="#" class="btn btn-primary">Pošalji poruku</a><!--Ako je korisnik ulogovan, treba da vodi na stranu za slanje poruke, sa vec popunjenim primaocem. U suprotnom na stranu za registraciju-->
                </div>
                <?php
                endif;?>
            </div>
        </div>
        <?php
        if ($isTutor):?>
        <div class="css/list-of-subjects col-xs-12">
            <div class="row">
                <?php
                if ($loggedIn && $profileID == $_SESSION['userID']):?>
                    <h2>Časovi<a data-toggle="modal" data-target="#tutor-modal" href="#"><div class="glyphicon glyphicon-plus"></div></a></h2>
                <?php
                else:
                    ?>
                    <h2>Drži časove:</h2>
                <?php
                endif;
                ?>
            </div>
            <div class="row">
                <table class="table"><!--Spisak casova koje drzi. Popunajva se iz baze-->
                    <thead>
                        <tr>
                            <th>Oblast</th>
                            <th>Podoblast</th>
                            <th>Cena po času</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($adverts as $cas):
                            echo "<tr><td>" . $cas['oblast'] . "</td><td>" . $cas['podoblast'] . "</td><td>" . $cas['cena'] . " RSD</td>";
                            if ($loggedIn && $_SESSION['userID'] == $profileID):
                                ?>
                                <td><a href="<?php echo site_url()."/user/removeadvert/".$cas['id']; ?>"><div class="glyphicon glyphicon-remove"></div></a></td>
                                <?php
                            endif;
                            echo "</tr>";
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    
        <div class="biography col-xs-12"><!--Biografija. Popunajva se iz baze-->
            <div class="row"><h2>Biografija
                <?php
                if ($loggedIn && $profileID == $_SESSION['userID']):
                    ?>
                        <a data-toggle="modal" data-target="#bio-modal" href="#"><div class="glyphicon glyphicon-pencil"></div></a>
                    <?php
                endif;?></h2>
                <p><?php echo $biography; ?></p>
            </div>
        </div>

        <div class="experience col-xs-12">
            <h2 class="row">Radno iskustvo
            <?php
                if ($loggedIn && $profileID == $_SESSION['userID']):
                    ?>
                    <a data-toggle="modal" data-target="#work-modal" href="#"><div class="glyphicon glyphicon-plus"></div></a>
                    <?php
                endif;
            ?>
            </h2><!--Radno iskustvo. Isto se popunjava iz baze-->
            <?php
                foreach($workExperience as $job):
                    echo '<div class="experience-item"><!--Pocetak bloka-->';
                    echo '<div class="row">';
                    echo '<div class="col-sm-6 no-padding-left">';
                    echo '<div class="experience-name pull-left">'.$job['naziv'];
                    if ($loggedIn && $profileID == $_SESSION['userID']):
                        ?>
                        <a href="<?php echo site_url()."/user/removeJob/".$job['idPosao']; ?>"><div class="glyphicon glyphicon-remove"></div></a>
                        <?php  
                    endif;
                    echo '</div>';
                    echo '<div class="experience-time pull-right">'.$job['period'].'</div>';
                    echo '</div></div>';

                    echo '<div class="row experience-employer">'.$job['poslodavac'].'</div>';
                    echo '<div class="experience-text row">'.$job['opis'].'</div></div><!--Kraj bloka-->';
                endforeach;
            ?>
        </div>

        <div class="education col-xs-12"><!-- Obrazovanje. Isto se vuce iz baze-->
            <h2 class="row">Obrazovanje
            <?php
            if ($loggedIn && $profileID == $_SESSION['userID']):
                ?>
                    <a data-toggle="modal" data-target="#edu-modal" href="#"><div class="glyphicon glyphicon-plus"></div></a>
                <?php  
            endif;
            ?>
            </h2>
            <?php
                foreach($education as $skola):
                    echo '<div class="experience-item"><!-- Pocetak bloka-->';
                    echo '<div class="row">';
                    echo '<div class="col-sm-6 no-padding-left">';
                    echo '<div class="experience-name pull-left">'.$skola['institucija'];

                    if ($loggedIn && $profileID == $_SESSION['userID']):
                        ?>
                            <a href="<?php echo site_url()."/user/removeDucation/".$skola['idObrazovanje']; ?>"><div class="glyphicon glyphicon-remove"></div></a>
                        <?php
                    endif;

                    echo '</div>';
                    echo '<div class="experience-time pull-right">'.$skola['period'].'</div>';
                    echo '</div>';
                    echo '</div>';

                    echo '<div class="row experience-employer">'.$skola['nivo'].'</div>';
                    echo '<div class="experience-text row">'.$skola['opis'].'</div>';
                    echo '</div><!--Kraj bloka-->';
                endforeach;
            ?>
        </div>

        <div class="certificates col-xs-12">
            <div class="row"><h2>Sertifikati:
            <?php
            if ($loggedIn && $profileID == $_SESSION['userID']):
                ?>
                    <a data-toggle="modal" data-target="#cert-modal" href="#"><div class="glyphicon glyphicon-plus"></div></a>
                <?php  
            endif;
            ?></h2>
            </div><!--Sertifikati. Popunjavaju se iz baze-->
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Naziv sertifikata</th>
                            <th>Ustanova</th>
                            <th>Datum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($certificates as $certificate):
                                echo '<tr><!--Pocetak bloka-->';
                                echo '<td>'.$certificate['naziv'].'</td>';
                                echo '<td>'.$certificate['ustanova'].'</td>';
                                echo '<td>'.$certificate['datum'].'</td>';
                                if ($loggedIn && $profileID == $_SESSION['userID']):
                                    ?>
                                    <td><a href="<?php echo site_url()."/user/removeCertificate/".$certificate['idSertifikat']; ?>"><div class="glyphicon glyphicon-remove"></div></a</td>
                                    <?php  
                                endif;
                                echo '</tr><!--Kraj bloka-->';
                            endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    if ($loggedIn && $_SESSION['userID'] != $profileID):
    ?>
        <div class="reviews col-xs-12">
            <?php
            if ($loggedIn):
                ?>
                <form method="post" action="<?php echo site_url()."/user/rate/".$profileID; ?>">
                    <div class="row"><input id="7-xs" name="rating" class="rating rating-loading"  value="3" data-min="0" data-max="5" data-step="0.5" data-display-only="false" data-size="xs"></input></div>
                    <div class="row">
                        <textarea name="comment" id="review-box" placeholder="Unesite tekst recenzije"></textarea>
                    </div>
                    <div class="row"><button type="submit" class="btn btn-primary">Oceni</button></div>
                </form>
                <?php
            endif;
        endif;
        if (sizeof($ratings) == 0):   
        else:
            foreach ($ratings as $rating):?>
                <div class="review-item-profile">
                <div class="row"><input id="input-7-xs" name="input-7" class="rating rating-loading"  value="<?php echo $rating['ocena'];?>" data-min="0" data-max="5" data-step="0.5" data-display-only="true" data-size="xs"></input></div>
		
                
                
                <div class="row"><p><?php echo $rating['text'];?></p></div>
                <div class="row"><div class="profile-reviewer"><?php echo $rating['ocenjivac']; ?></div>
                </div>
                <?php
            endforeach;
        endif;
        ?>
        </div>
    <?php
        endif;
        ?>
    </div>

</div>
</div>
<script>
$("#present-checkbox").click(function() {
    $("#datetimepicker2-input").prop("disabled", this.checked); 
});

$("#present-checkbox-2").click(function() {
    $("#datetimepicker4-input").prop("disabled", this.checked); 
});

$(function() {
	$('#datetimepickercert').datetimepicker();
	$('#datetimepicker1').datetimepicker();
	$('#datetimepicker2').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepicker1").on("dp.change", function (e) {
            $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker2").on("dp.change", function (e) {
            $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
        });

    $('#datetimepicker3').datetimepicker();
	$('#datetimepicker4').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepicker3").on("dp.change", function (e) {
            $('#datetimepicker4').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker3").on("dp.change", function (e) {
            $('#datetimepicker4').data("DateTimePicker").maxDate(e.date);
        });
});
</script>