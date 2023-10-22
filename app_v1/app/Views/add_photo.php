<div class="container">
<div class="col-4 offset-4">

<?php echo form_open_multipart(base_url() . 'login/add_photo'); ?>
<br>
<h1 class="h3 mb-3 font-weight-normal">Please add your profile photo</h1>
<label for="inputCode" class="sr-only">photo name:</label>
  <input type="text" id="inputPname" name="pname" class="form-control" placeholder="please enter your photo name" required>
  <br>
  <br>
  <input type='file' name='pfile'>
  <br>
  <br>
  <button class="btn btn-lg btn-primary btn-block" type="submit">submit</button>
  <?php echo form_close(); ?>
</div>
</div>