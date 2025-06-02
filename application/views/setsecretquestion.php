
<div class="container">
      <div class="col-4 offset-4 mt-5">
			<?php echo form_open(base_url().'register/setquestion'); ?>  

				<div class="form-group">
					<label for="Questions1">Secret Questions1</label>
					<select name="question1" class="form-control form-control-lg">
						<option>What was your first pet?</option>
						<option>What is your father's name?</option>
						<option>What is your mother's name?</option>
						<option>In what city were you born?</option>
						<option>What is your favourite phone brand?</option>   
						<option>What was the model of your first car?</option>
					</select>
				</div>

				
				<div class="form-group ">
                    <label for="exampleInputusername" class="form-label">Answer&#32:</label>
					<input type="text" class="form-control form-control-lg" placeholder="Please type answer here" required="required" name="answer1">
				</div>

				<div class="form-group">
					<label for="Questions2">Secret Questions2</label>
					<select name="question2" class="form-control form-control-lg">
						<option>What is your date of birth?</option>
						<option>What is your father's name?</option>
						<option>What is your mother's name?</option>
						<option>What is your favourite sport?</option> 
						<option>What was your favorite school teacher's name?</option>
						<option>In what city or town did your parents meet?</option>
					</select>
				</div>

				
				<div class="form-group">
                    <label for="exampleInputusername" class="form-label">Answer&#32:</label>
					<input type="text" class="form-control form-control-lg" placeholder="Please type answer here" required="required" name="answer2">
				</div>

				<!-- <div class="clearfix">
					<label class="float-left form-check-label"><input type="checkbox" name="remember"> Remember me</label>
				</div>     -->

				<div class="form-group mt-5">
					<button type="submit" id="login-button" class="btn btn-lg btn-primary btn-block">Set and Create</button>
				</div>
			<?php echo form_close(); ?>
	</div>
</div>