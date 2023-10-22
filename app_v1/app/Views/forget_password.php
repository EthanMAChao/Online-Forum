<div class="container">
<div class="col-4 offset-4">
<?php echo form_open(base_url() . 'forget/email_action'); ?>
<br>
<h1 class="h3 mb-3 font-weight-normal">Please enter your email </h1>
<label for="inputCode" class="sr-only">email</label>
  <input type="text" id="inputemail" name="email" class="form-control" placeholder="please enter your email" required>
  <br>
  <button class="btn btn-lg btn-primary btn-block" type="submit">submit</button>
  <?php echo form_close(); ?>
</div>
</div>