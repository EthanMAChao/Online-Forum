<?php echo form_open_multipart(base_url() . 'login/profile_index'); ?>
<!--this code from url=https://mdbootstrap.com/docs/standard/extended/profiles/--> 
<style {csp-style-nonce}>
    .gradient-custom {

background: linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1))
}
.btn-purple {
  background-color: purple;
  color: white;
}
.btn-seablue{
  background-color: rgb(32, 178, 170);;
  color: black;
}
</style>

<div class="container">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-lg-6 mb-4 mb-lg-0">
        <div class="card mb-3" style="border-radius: .5rem;">
          <div class="row g-0">
            <div class="col-md-4 gradient-custom text-center text-white"
              style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
              <?php if($data1[6]):?>
        
                <img class="img-fluid my-5"  src="writable/uploads/resized/<?= $data1[5] ?>" />
                <a href="add_photo" class="btn btn-purple"><h7>update photo</h7></a>
                <?php else: ?>
                  <a href="add_photo" class="btn btn-purple"><h7>add photo</h7></a>
                  <?php endif; ?>
                  <br>
                  <br>
              <h5><?php echo  (isset($data1[0]) ? $data1[0] : 'error');?></p></h5>
              <i class="far fa-edit mb-5"></i>
            </div>
            <div class="col-md-12">
              <div class="card-body p-12">
                <h4>Personal details</h4>
                <hr class="mt-0 mb-4">
                <div class="row pt-1">
                  <div class="col-9 mb-1">
                    <h5>Email</h5>
                    <p><?php echo  (isset($data1[1]) ? $data1[1] : 'error');?></p></p>
                    <?php if($data1[3]==0):?>
                    <a href="change_email_ver" class="btn btn-warning"><h7>verify email</h7></a>
                    <?php else: ?>
                      <a  class="btn btn-purple"><h8>Your email has been verified</h8></a>
                      <br>
                      <br>
                    <a href="change_email" class="btn btn-warning"><h7> Change email</h7></a>
                    <?php endif; ?>
                  </div>
                  <br>
                  <div class="col-9 mb-1">
                  <br>
                    <h6>Phone number</h6>
                    <p>   
                    <?php echo (isset($data1[2]) ? $data1[2] : 'Your did not add phone number');?></p>
                    <?php if($data1[2]):?>
                      <?php if($data1[4]==0):?>
                      <a href="ver_phone" class="btn btn-warning"><h7>Please verify phone number</h7></a>
                      <?php else: ?>
                      <a  class="btn btn-purple"><h7>Your phone has been verified</h7></a>
                    <a href="reset" class="btn btn-warning"><h7>Change phone number</h7></a>
                    <?php endif; ?>
                    <?php else: ?>
                    <a href="add_phone" class="btn btn-warning"><h7>add phone number</h7></a>
                    <?php endif; ?>
                  </div>

                  <div class="col-9 mb-1">
                  <br>
                    <h6>location</h6>
                    <a href="location" class="btn btn-seablue"><h7>see your location</h7></a>
                    </div>

                    <div class="col-9 mb-1">
                  <br>
                    <h6>upload file</h6>
                    <a href="file_uploads" class="btn btn-seablue"><h7>upload your files</h7></a>
                    </div>
                </div>         
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

