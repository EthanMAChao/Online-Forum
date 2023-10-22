<div class="container">
<div class="col-4 offset-4">
<?php echo form_open(base_url() . 'login/add_phone_action'); ?>
<br>
<h1 class="h3 mb-3 font-weight-normal">Please enter your phone number</h1>
<label for="inputCode" class="sr-only">phone number:</label>
  <input type="text" id="inputPhone" name="phone" class="form-control" placeholder="please enter your phone number" required>
  <br>
  <button class="btn btn-lg btn-primary btn-block" type="submit">submit</button>
  <?php echo form_close(); ?>
</div>
</div>