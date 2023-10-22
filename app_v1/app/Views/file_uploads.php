<br>
<br>
<!-- code comes from:https://makitweb.com/drag-drop-file-upload-with-dropzone-in-codeigniter-4/-->
<!doctype html>
<html>
<head>
   <h2>drag or drop mutiple files</h2>
   <br>
   <h3>only support png, jpg, jpeg and pdf, no more than 2 m</h3>

   <!-- CSS -->
   <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

   <!-- Script -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

</head>
<body>

   <!-- CSRF token --> 
   <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

   <div class='content'>
      <!-- Dropzone -->
      <form action="<?=base_url('login/file_uploads_action')?>" class='dropzone' ></form> 
   </div>
   <br>
   <a href="user" class="btn btn-primary btn-block"><h7>back to profile</h7></a>
   <br>

   <!-- Script -->
   <script>

   Dropzone.autoDiscover = false;
   var myDropzone = new Dropzone(".dropzone",{ 
      maxFilesize: 2, // 2 mb
      acceptedFiles: ".jpeg,.jpg,.png,.pdf",
   });
   myDropzone.on("sending", function(file, xhr, formData) {
      // CSRF Hash
      var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
      var csrfHash = $('.txt_csrfname').val(); // CSRF hash

      formData.append(csrfName, csrfHash);
   }); 
   myDropzone.on("success", function(file, response) {
      $('.txt_csrfname').val(response.token);
      if(response.success == 0){ // Error
         alert(response.error);
      }
      if(response.success == 2){
         alert(response.message);
      }

   });
   </script>

</body>
</html>
