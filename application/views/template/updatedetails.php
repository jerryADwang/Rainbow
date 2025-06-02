<div class="container">
        <div class="col-8 offset-2 pt-2 pb-5">
            <div class="change-email pl-5 pr-5">
                <h2>Update details</h2>
                <?php echo form_open(base_url().'updatedetails/send'); ?> 
                <label for="exampleInputeEmail" class="form-label email_changing">Email address</label>
                <div class="input-group">
                    <input type="email" class="form-control form-control-lg" aria-label="Jerry@example.com" aria-describedby="verify" name="email" value=<?php echo $email ?>>
                    <button class="btn btn-outline-secondary btn-lg" type="submit" id="verify" onclick="verify()">Verify</button>
                </div>
                <div class="error" style="color:red;"><?php echo form_error('email'); ?></div>
                <?php echo form_close(); ?>
                <?php echo form_open(base_url().'updatedetails/update'); ?> 
                <div class="form-group">
                    <label for="exampleInputVCode" class="form-label">Verification Code</label>
                    <input type="text" class="form-control form-control-lg" placeholder="Verification Code 4-6 digit number" required="required" name="vcode">
                </div>       
                <div class="form-group">
                    <label for="exampleInputUserName" class="form-label">Username</label>
                    <input type="text" class="form-control form-control-lg" value=<?php echo $username ?> required="required" name="username">
                </div>
                <div class="error" style="color:red;"><?php echo form_error('username'); ?></div>
                <div class="form-group">
                    <label for="exampleInputPhone" class="form-label">Phone number</label>
                    <input type="number" class="form-control form-control-lg" value=<?php echo $phonenumber ?> required="required" name="phonenumber">
                </div>
                <div class="form-group">
				    <?php echo $error; ?>
				</div>
                <div class="button">
                    <div class="col mt-4 pb-4">
                        <button type="submit" id="savebutton" class="btn  btn-info btn-block ">Save</button>
                    </div>
                <?php echo form_close(); ?>
                <?php echo form_open(base_url().'updatedetails/close'); ?>
                    <div class="col mt-4 pb-4 ml-5 pl-5">
                        <button type="submit" id="closebutton" class="btn btn-warning btn-block float-right">Close</button>
                    </div>
                <?php echo form_close(); ?>
                </div>
            </div>
        </div> 
</div>


<!-- <script>
$(document).ready(function(){
load_data();
    function load_data(query){
        $.ajax({
        url:"<?php echo base_url(); ?>ajax/fatch",
        method:"GET",
        data:{query:query},
        success:function(response){
        }
    });
    }
    $('#comment-search-bar').keyup(function(){
        var search = $(this).val();
        if(search != ''){
            load_data(search);
        }else{
            load_data();
        }
    });
});
</script> -->



