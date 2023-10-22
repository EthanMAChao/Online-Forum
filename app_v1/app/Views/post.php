<div class="container">
	<div class="col-4 offset-4">
		<?php echo form_open(base_url() . 'login/post_action'); ?>
      <br>
  <h2>your article's title</h2>
  <input type="text" id="inputQtitle" name="qtitle" class="form-control" placeholder="title" required autofocus>
  <br>
  <label for="exampleFormControlTextarea1">your article</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" name='article' rows="10"></textarea>
  <br>

 
  <br>
  <br>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Post</button>
  <?php echo form_close(); ?>
   </div>
</div>