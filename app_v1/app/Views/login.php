<div name='this code is from prac'></div>
<div class="container">
	<div class="col-4 offset-4">

<?php echo form_open(base_url() . 'login/check_login'); ?>
  <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
  <label for="inputUsername" class="sr-only">Username</label>
  <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required autofocus>
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
  <div class="clearfix">
			<label class="float-left form-check-label"><input type="checkbox" name = "remember"> Remember me</label>
			
	</div>
	<?php echo form_close(); ?>	
  
	</div>

  <div class="col-md-12 text-center">
    <br>
    <a href="forget_password" class="btn btn-primary">Forgot Password?</a>
      <br>
      <br>
  <a class="btn btn-primary" href="<?php echo base_url(); ?> register" >Register Now!</a>
  </div>		
</div>