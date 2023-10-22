<div class="container">
	<div class="col-4 offset-4">
		<?php echo form_open(base_url() . 'login/delete_event_action'); ?>
      <br>
      <h3>Your events' details: </h3>
      <br>
      <?php if(!empty($event)) { 
         foreach ($event as $e) {
    echo "id: " . $e->id .", month: " . $e->month .", day: " . $e->day . ", title: " . $e->title . ", detail: ".$e->detail."<br>";
  }} ?>
  <br>
  <br>
  <h2> add delete event id </h2>
  <input type="int" id="inputEventdateMonth" name="eid" class="form-control" placeholder="eg 2 if id :2" required autofocus>
  <br>
  
  <br>
  <button class="btn btn-lg btn-primary btn-block" type="submit">delete</button>
  <?php echo form_close(); ?>
  <br>
  <a href='timetable' class='btn btn-primary' >return to time table</a>
   </div>
</div>