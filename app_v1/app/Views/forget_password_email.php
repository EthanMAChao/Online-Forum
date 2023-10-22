<div class="container">
<div class="col-4 offset-4">
<?php echo form_open(base_url() . 'forget/email_check'); ?>
<br>
<h1 class="h3 mb-3 font-weight-normal">Please enter verification code</h1>
<label for="inputCode" class="sr-only">verification code</label>
  <input type="text" id="inputCode" name="code" class="form-control" placeholder="please enter email verification code" required>
  <br>
  <button class="btn btn-lg btn-primary btn-block" type="submit">submit</button>
  <?php echo form_close(); ?>
</div>
</div>