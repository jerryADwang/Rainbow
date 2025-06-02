<div class="container">
        <div class="col-8 offset-2 pt-2 pb-5">
            <div class="change-email pl-5 pr-5">
                <h2>Reset your password</h2>
                <?php echo form_open(base_url().'secretquestion/reset'); ?>        
                <div class="input-group mt-5 pb-5">
					<input type="password" id="showbutton1" class="form-control form-control-lg" placeholder="New Password" aria-label="123456" aria-describedby="showpassword" required="required" name="password1">
					<a class="btn showhidden" type="button" id="showhidden1"  onclick="toggleshow1()">Show</a>
				</div>
                <div class="input-group">
					<input type="password" id="showbutton2" class="form-control form-control-lg" placeholder="Verify New Password" aria-label="123456" aria-describedby="showpassword" required="required" name="password2">
					<a class="btn showhidden" type="button" id="showhidden2"  onclick="toggleshow2()">Show</a>
				</div>
                <br>
                <div class="error" style="color:red;"><?php echo form_error('password1'); ?></div>

                <div class="button pb-2">
                    <div class="col pb-4">
                        <button type="submit" id="resetbutton" class="btn btn-info btn-block">Reset</button>
                    </div>
                <?php echo form_close(); ?>
                </div>
            </div>
        </div> 
</div>

<style>
#resetbutton{
    font-weight:600;
    font-size:1.1rem;
    width:15rem;
    display:block;
    margin:0 auto;
    letter-spacing:0.1rem ;
}
</style>