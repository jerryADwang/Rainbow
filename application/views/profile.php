<div class="container">
    <div class="profile">
        <h1>My details</h1>  
        <?php echo form_open_multipart('upload/do_upload');?>
        <div class="details">
            <div class="offset-1 pt-2 pb-5">
                <div class="row align-items-bottom mt-5">
                    <div class="col col-md-2" id="userimage">
                        <img src="<?php echo $path ?>" alt="User Profile Image">
                    </div>

                    <div class="col col-md-8" id="emailname">
                        <div class="row pl-3 mt-3" id="username">
                            <?php echo $username ?> &nbsp; <span class="membership"><?php echo $membership ?></span>
                        </div>
                        <div class="row mt-2 pl-3" id="email">
                            <?php echo $email ?>
                        </div>
                        <div class="row mt-2 pl-3" id="location">
                            <a href="<?php echo base_url().'location';?>"><i class="bi bi-cursor-fill"></i>&#32My location</a>
                        </div>
                    </div> 
                    <div class="col col-md-2 pl-5">
                        <a href="<?php echo base_url().'updatedetails';?>">Change</a>
                    </div>

                    <div class="input-group input-group-sm col mt-4">
                        <div class="col-md-12">
                            <input id="choose-file"type="file" name="userfile" > 
                            <?php echo $error;?>
                        </div>
                        <div class="col-md-12">
                            <input id="upload" type="submit" value="upload">
                        </div>
                    </div>


                    <div class="col col-md-12 mt-1 pl-5" id="contact_detail">
                        <div class="row pl-3 mt-3" id="header">
                            Phone 
                        </div>

                        <div class="row mt-2 pl-3">
                            <?php echo $phone ?>
                        </div>
                    </div>

                    <div class="col col-md-10  pl-5" id="contact_detail">
                        <hr style="border: 1px solid #53818F;">
                        <div class="row pl-3 mt-3" id="header">
                            Password
                        </div>
                        <div class="row mt-2 pl-3">
                            *****************
                        </div>
                    </div>
                    <div class="col col-md-2  pl-5 pt-5">
                        <a href="<?php echo base_url().'updatepassword';?>">Change</a>
                    </div>
                </div>

            </div>
        </div>
        <?php echo form_close(); ?>
    </div>



</div>
