<div class="container">
	<div class="col-4 offset-4">
		<?php echo form_open(base_url() . 'register/check_register'); ?>
      <br>
		<label for="inputUsername" class="sr-only">Username</label>
  <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required autofocus>
  <br>
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
  <br>
  <label for="inputEmail" class="sr-only">Email</label>
  <input type="email" id="inputemail" name="email" class="form-control" placeholder="Email" required>
  <br>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
  <?php echo form_close(); ?>
   </div>
</div>
