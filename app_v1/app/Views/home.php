
<?php if($messages) {
  
    foreach($messages as $m) {
        echo $m;  ?>
        <?php echo form_open(base_url() . 'login/home_action'); ?>
        <!--layout comes from https://mdbootstrap.com/docs/standard/extended/comments/#!  -->
     
        
        <div class="comments" id="commentsArea">
        <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
       
        <h4> add comments </h4>
            <div class="d-flex flex-start w-100">   
              <div class="form-outline w-100">
                <textarea class="form-control" id="textAreaExample" name="comments" rows="4"
                  style="background: #fff;"></textarea>
 
                <h5> add article id </h5>
               <input type="int" id="inputEventdateMonth" name="qid" class="form-control" placeholder="add article id" required autofocus>
              </div>
            </div>
            <div class="float-end mt-2 pt-1">
              <button type="submit" class="btn btn-primary btn-sm">Post comment</button>
            </div>
          </div>
    </div>
    <?php echo form_close(); ?>
   <?php }
} ?>
