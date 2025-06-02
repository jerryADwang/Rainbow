
<div class="container">
      <div class="col-4 offset-4 mt-5">
			<?php echo form_open(base_url().'secretquestion/verify'); ?>  
				<div class="form-group">
					<label for="Questions1">Secret Questions1</label>
					<select name="question1" class="form-control form-control-lg">
						<option><?php echo $question1 ?></option>                  
					</select>
				</div>
				<div class="form-group ">
                    <label for="exampleInputusername" class="form-label">Answer&#32:</label>
					<input type="text" class="form-control form-control-lg" placeholder="Please type answer here" required="required" name="answer1">
				</div>

				<div class="form-group">
					<label for="Questions2">Secret Questions2</label>
					<select name="question2" class="form-control form-control-lg">
						<option><?php echo $question2 ?></option>                   
					</select>
				</div>

				<div class="form-group">
                    <label for="exampleInputusername" class="form-label">Answer&#32:</label>
					<input type="text" class="form-control form-control-lg" placeholder="Please type answer here" required="required" name="answer2">
				</div>

				<div class="form-group" style="color:red;">
				    <?php echo $error; ?>
				</div>
				
				<div class="form-group mt-4">
					<button type="submit" id="login-button" class="btn btn-lg btn-primary btn-block">Verify</button>
				</div>
			<?php echo form_close(); ?>
	</div>
</div>