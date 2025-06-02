<div class="container mt-5">
    <h2>Find the best</h2>
    <div class="row shop_collection">
        <div class="col col-md-4 mt-5 pr-5">
            <a href="<?php echo base_url().'shop/shoppage/maru';?>"> <img src="<?php echo base_url(); ?>/assets/img/maru.jpg" alt="Shop's image"></a>
            <div class="row mt-3">
                <div class="col col-md-6">
                        <h3>Maru</h3>
                        <div class="rating pb-3">
                            <?php echo $marucommentcount; ?> comments
                        </div>

                </div>
                <div class="col col-md-4 p-md-0">
                    <div class="shopcontent pr-4">
                        <div class="bookmark pt-1">
                            <a role="button" href="<?php echo base_url().'home/shop/maru';?>"><i class="<?php echo $marustatus; ?>" style="color:red;"></i></a>
                        </div>
                        <div class="comment mt-2"><?php echo $marucount; ?> likes</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col col-md-4 mt-5 pr-5">
            <a href="<?php echo base_url().'shop/shoppage/jackpot';?>"><img src="<?php echo base_url(); ?>/assets/img/jackpot.jpg" alt="Shop's image"></a>
            <div class="row mt-3">
                <div class="col col-md-6">
                        <h3>Jackpot</h3>
                        <div class="rating pb-3">
                            <?php echo $jackpotcommentcount; ?> comments
                        </div>           
                </div>
                <div class="col col-md-4 p-md-0">
                    <div class="shopcontent pr-4">
                        <div class="bookmark pt-1">
                            <a role="button" href="<?php echo base_url().'home/shop/jackpot';?>"><i class="<?php echo $jackpotstatus; ?>" style="color:red;"></i></a>
                        </div>
                        <div class="comment mt-2"><?php echo $jackpotcount; ?> likes</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col col-md-4 mt-5  pr-5">
            <a href="<?php echo base_url().'shop/shoppage/nandos';?>"><img src="<?php echo base_url(); ?>/assets/img/nandos.png" alt="Shop's image"></a>
            <div class="row mt-3">
                <div class="col col-md-6">
                        <h3>Nando's</h3>
                        <div class="rating pb-3">
                            <?php echo $nandoscommentcount; ?> comments
                        </div>
                </div>
                <div class="col col-md-4 p-md-0">
                    <div class="shopcontent pr-4">
                        <div class="bookmark pt-1">
                            <a role="button" href="<?php echo base_url().'home/shop/nandos';?>"><i class="<?php echo $nandosstatus; ?>" style="color:red;"></i></a>
                        </div>
                        <div class="comment mt-2"><?php echo $nandoscount; ?> likes</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h2 class="pt-3">All shops</h2>
    <!-- //Foreach all shops -->
    <div class="row shop_collection"><?php echo $result; ?></div>

</div>

