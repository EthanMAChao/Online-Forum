<div class="container">
<div class="col-4 offset-4">
<?php echo form_open(base_url() . 'reset/reset_password'); ?>
<br>
<h1 class="h3 mb-3 font-weight-normal">Please enter your email and verify</h1>
<label for="inputEmail" class="sr-only">Email</label>
  <input type="email" id="inputemail" name="email" class="form-control" placeholder="please enter ur Email" required>
  <br>
  <button class="btn btn-lg btn-primary btn-block" type="submit">submit</button>
  <?php echo form_close(); ?>
</div>
</div>
