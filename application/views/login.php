<div class="container mt-4">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'login/check_login'); ?>
				<h2 class="text-center">Login</h2>       
				<div class="form-group mt-4">
					<input type="text" class="form-control form-control-lg" placeholder="Username" required="required" name="username" value=<?php echo $username; ?>>
				</div>
				<div class="form-group">
					<input type="password" class="form-control form-control-lg" placeholder="Password" required="required" name="password">
				</div>
				<div class="form-group">
				<?php echo $error; ?>
				</div>
				<div class="clearfix">
					<label class="float-left form-check-label"><input type="checkbox" name="remember">Remember me</label>
					<a href="<?php echo base_url().'secretquestion';?>" class="float-right">Forgot Password?</a>
				</div>  
				<div class="form-group mt-4">
					<button type="submit" id="login-button" class="btn btn-lg btn-primary btn-block">Log in</button>
				</div>
				<div class="logincreatspearte mt-4">
					<span class="textspearte">or</span>
				</div>
			<?php echo form_close(); ?>
			<?php echo form_open(base_url().'register'); ?>
				<div class="form-group mt-2">
					<button type="submit" id="login-button" class="btn btn-lg btn-primary btn-block">Create account</button>
				</div>
			<?php echo form_close(); ?>
	</div>
</div>

