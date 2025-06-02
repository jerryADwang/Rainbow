
<div class="container">
      <div class="col-4 offset-4 mt-5">
	  		<?php echo form_open(base_url().'register/send'); ?> 
	  			<div class="form-group">
                    <label for="exampleInputemail" class="form-label">Email address</label>
					<div class="input-group">
						<input type="email" class="form-control form-control-lg" placeholder="Jerry@example.com" aria-label="Jerry@example.com" aria-describedby="verify" required="required" name="email" value="<?php echo $email ?>">
						<button class="btn btn-outline-secondary btn-lg" type="submit" id="verify" >Verify</button>
					</div>
					<div class="error" style="color:red;"><?php echo form_error('email'); ?></div>  
				</div>
			<?php echo form_close(); ?>
			<?php echo form_open(base_url().'register/check_register'); ?>
				<div class="form-group">
                    <label for="exampleInputVCode" class="form-label">Verification Code</label>
					<input type="text" class="form-control form-control-lg" placeholder="Verification Code 4-6 digit number" required="required" name="vcode">
				</div>
				<div class="form-group">
                    <label for="exampleInputusername" class="form-label">Username</label>
					<input type="text" class="form-control form-control-lg" placeholder="Jerry" required="required" name="username">
				</div>
				<div class="error" style="color:red;"><?php echo form_error('username'); ?></div>
				<div class="form-group">
					<label for="exampleInputpassword" class="form-label">Password</label>
					<div class="input-group">
						<input type="password" id="showbutton" class="form-control form-control-lg" placeholder="123456" aria-label="123456" aria-describedby="showpassword" required="required" name="password">
						<a class="btn showhidden" type="button" id="showhidden"  onclick="toggleshow()">Show</a>
					</div>
				</div>
				<div class="error" style="color:red;"><?php echo form_error('password'); ?></div>

				<div class="form-group">
                    <label for="exampleInputphone" class="form-label">Phone number</label>
					<input type="number" class="form-control form-control-lg" placeholder="0410-xxx-xxx" required="required" name="phonenumber">
				</div>

				<div class="form-group">
					<?php echo $invalid; ?>
				</div>
				<label class="float-left form-check-label pb-3"><input type="checkbox" name="nodification"> Get the latest Notification</label>
				<div class="form-group  mt-4">
					<button type="submit" id="register-button"class="btn btn-lg btn-primary btn-block">Next Step</button>
				</div>
			<?php echo form_close(); ?>
	</div>
</div>