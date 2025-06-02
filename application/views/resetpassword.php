
<div class="container">
    <h2 class="mt-5" style="text-align:center;">Are you having trouble log in?</h2>
      <div class="col-4 offset-4 mt-5">
			<?php echo form_open(base_url().'secretquestion/check_user'); ?>  
				<div class="form-group mt-4">
					<label for="exampleInputusername" class="form-label">Please enter your Username&#32:</label>
					<input type="text" class="form-control form-control-lg" placeholder="Username" required="required" name="username">
				</div>
				<div class="form-group">
				<div class="error" style="color:red;"><?php echo $error; ?></div>
				</div>

				<div class="form-group mt-5">
					<button type="submit" id="login-button" class="btn btn-lg btn-primary btn-block">Next</button>
				</div>
			<?php echo form_close(); ?>
	</div>
</div>