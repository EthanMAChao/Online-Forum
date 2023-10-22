<div class="container">
	<div class="col-4 offset-4">
		<?php echo form_open(base_url() . 'login/add_event_action'); ?>
      <br>
  <label for="inputEventdateMonth" class="sr-only">add event date month</label>
  <input type="text" id="inputEventdateMonth" name="event_date_month" class="form-control" placeholder="month, eg:5 if your want to add event to May" required autofocus>
  <br>
  <label for="inputEventdateDay" class="sr-only">add event date day</label>
  <input type="text" id="inputEventdateDay" name="event_date_day" class="form-control" placeholder="day, your event date no 0 at the beginerring" required autofocus>
  <br>
  <label for="inputTitle" class="sr-only">title</label>
  <input type="text" id="inputTitle" name="title" class="form-control" placeholder="title" required>
  <br>
  <label for="inputDetail" class="sr-only">detail</label>
  <input type="text" id="inputDetail" name="detail" class="form-control" placeholder="detail" required>
  <br>
  <button class="btn btn-lg btn-primary btn-block" type="submit">add</button>
  
  <?php echo form_close(); ?>
   </div>
</div>