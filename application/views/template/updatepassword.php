<div class="container">
        <div class="col-8 offset-2 pt-2 pb-5">
            <div class="change-email pl-5 pr-5">
                <h2>Change your password</h2>
                <?php echo form_open(base_url().'updatepassword/update'); ?>        
                <div class="input-group mt-5 pb-5">
					<input type="password" id="showbutton1" class="form-control form-control-lg" placeholder="Current password" aria-label="123456" aria-describedby="showpassword" required="required" name="currentpassword">
					<a class="btn showhidden" type="button" id="showhidden1"  onclick="toggleshow1()">Show</a>
				</div>
                <div class="input-group">
					<input type="password" id="showbutton2" class="form-control form-control-lg" placeholder="New password" aria-label="123456" aria-describedby="showpassword" required="required" name="newpassword">
					<a class="btn showhidden" type="button" id="showhidden2"  onclick="toggleshow2()">Show</a>
				</div>
                <br>
                <div class="error" style="color:red;"><?php echo form_error('newpassword'); ?></div>

                <div class="form-group">
				    <?php echo $error; ?>
				</div>

                <div class="button mt-5 pb-5">
                    <div class="col mt-4 pb-4">
                        <button type="submit" id="savebutton" class="btn  btn-info btn-block ">Save</button>
                    </div>
                <?php echo form_close(); ?>
                <?php echo form_open(base_url().'updatepassword/close'); ?>
                    <div class="col mt-4 pb-4 ml-5 pl-5">
                        <button type="submit" id="closebutton" class="btn btn-warning btn-block float-right">Close</button>
                    </div>
                <?php echo form_close(); ?>
                </div>
            </div>
        </div> 
</div>