<div class="container">
<div class="col-4 offset-4">
<?php echo form_open(base_url() . 'forget/new_password'); ?>
<br>
<h1 class="h3 mb-3 font-weight-normal">Please enter your new password</h1>
<label for="inputCode" class="sr-only">password</label>
  <input type="text" id="inputpassword" name="password" class="form-control" placeholder="please enter your new password" required>
  <br>
  <button class="btn btn-lg btn-primary btn-block" type="submit">submit</button>
  <?php echo form_close(); ?>
</div>
</div>