<!--
tu130060
sa130068
-->
<div class="page container">
    <nav class="search-menu">
        <div class="row">
            <div class="col-xs-12 menu-body">
                    <div class="form-group col-xs-4 col-xs-offset-1">
                        <label>Cena</label>
                        <input form="searchForm" name="cenaMin" id="price-low">
                        <label>-</label>
                        <input form="searchForm" name="cenaMax" id="price-high">
                    </div>
                    <div class="form-group col-xs-4">
                        <label>Oblast</label>
                        <select form="searchForm" name="subject" id="subject" onchange="getDisciplines()">
                            <option value="-1">--</option>
                            <?php
                            foreach ($subjects as $subject):
                                echo "<option id=\"".$subject['idPredmet']."\" value=\"".$subject['idPredmet']."\">" . $subject['naziv'] . "</option>";
                            endforeach;
                            ?>
                        </select>
                        <select form="searchForm" name="discipline" id="disciplines">
                        </select>
                    </div>

                    <div class="form-group col-xs-3">
                        <label>Vrsta</label>
                        <select form="searchForm" name="type">
                            <option value="-1">--</option>
                            <option value="<?php echo GROUP; ?>">Grupni</option>
                            <option value="<?php echo ONLINE; ?>">Online</option>
                        </select>
                    </div>
            </div>
        </div>
    </nav>
    <?php
        if (sizeof($results) == 0):?>
            <div class="col-xs-12 search-fail">
                <div class="row">
                    <h2>Nema rezultata :(</h2>
                </div>
            </div>
    <?php
        else:
    ?>
    
    <nav class="sort-menu">
        <div class="row">
            <div class="col-xs-offset-1 col-xs-11 menu-body">
                <div class="sort-text">Sortiraj po: </div>
                <ul>
                    <li><a href="<?php echo site_url() . "/search/sortresults/".PRICEHIGH; ?>">Opadajućoj ceni</a></li>
                    <li><a href="<?php echo site_url() . "/search/sortresults/".PRICELOW; ?>">Rastućoj ceni</a></li>
                    <li><a href="<?php echo site_url() . "/search/sortresults/".RELEVANCE; ?>">Relevantnosti</a></li>
                    <li><a href="<?php echo site_url() . "/search/sortresults/".RATING; ?>">Oceni</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="col-xs-offset-1 col-xs-10">
        <?php
        if(sizeof($results) != 0):
            for ($i = ($page - 1) * 10; $i < ($page * 10 < $total ? $page * 10 : $total); $i++)
            {?>
                <div class = "search-profile row">
                    <div class = "col-xs-2">
                        <div class = "row">
                            <a href = "<?php echo site_url() . "/profile/" . $results[$i]['idTutor']; ?>">
                                <img src = "<?php echo $results[$i]['slika']; ?>" class = "img-responsive">
                            </a>
                        </div>
                    </div>
                    <div class = "col-xs-7">
                        <a href = "<?php echo site_url() . "/user/profile/" . $results[$i]['idTutor']; ?>">
                            <h4><?php echo $results[$i]['ime'] . " " . $results[$i]['prezime']; ?></h4>
                        </a>
                        <p><?php echo $results[$i]['biografija']; ?></p>
                    </div>
                    <div class = "col-xs-3">
                        <div class = "row price-field">
                            <div class = "price-heading">Već od</div>
                            <div class = "price"><?php echo $results[$i]['cena']; ?></div>
                        </div>

                        <div class = "row">
                            <div class = "my-rating">
                                <div class="my-rating"><input id="input-7-xs" name="input-7" class="rating rating-loading"  value="<?php echo $results[$i]['ukupnaOcena'] / 2;?>" data-min="0" data-max="5" data-step="0.5" data-display-only="true" data-size="sm"></input></div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        ?>
        <div class="col-xs-12">
            <div class="row">
                <ul class="pager">
                    <?php
                        $j = $page > 3? $page : 1;
                        $end = $page > 3 ? $page + 2 : 5;
                        if ($end > ceil($total / 10)):
                            $end = ceil($total / 10);
                        endif;
                        for (; $j < $end; $j++):
                            echo "<li><a href=\"" . site_url() . "/search/gotopage/" . $j . "\">".$j."</a></li>";
                        endfor;
                        $first = floor(($page + 10) / 10);
                        if ($first < ceil($total / 10)):
                            echo "<li>...</li>";
                            echo "<li><a href=\"". site_url()."/search/gotopage/".$first."\">".$first."</a></li>";
                        endif;
                        $second = floor(($page + 10) / 10);
                        if ($second < ceil($total / 10)):
                            echo "<li>...</li>";
                            echo "<li><a href=\"". site_url()."/search/gotopage/".$second."\">".$second."</a></li>";
                        endif;
                    ?>
                </ul>
            </div>
        </div>
        <?php
        endif;?>
    </div>
    <?php
        endif;
    ?>
</div>