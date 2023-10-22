<?php

namespace App\Controllers;
use Intervention\Image\ImageManager;
use CodeIgniter\Controller;
use CodeIgniter\Response;
use CodeIgniter\HTTP\RequestInterface;




class Login extends BaseController
{
    // this is from lec and prac week 6
    public function index()
    {
        $data['error'] = "";
        // check whether the cookie is set or not, if set redirect to welcome page, if not set, check the session
        if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
            echo view("template/header");
            echo view("welcome_message");
            echo view("template/footer");
        }
        else {
            $session = session();
            $username = $session->get('username');
            $password = $session->get('password');
            if ($username && $password) {
                echo view("template/header");
                echo view("welcome_message");
                echo view("template/footer");
            } else {
                echo view('template/header');
                echo view('login', $data);
                echo view('template/footer');
            }
        }
    }

    //this is from prac week 6
    public function check_login()
    {
        $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Incorrect username or password!! </div> ";
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $db = \Config\Database::connect();
        $builder = $db->table('app_accounts');
        $user = $builder->getWhere(['username' => $username])->getRow();
        $uid = $user->id;
        $session = session();
        $session->set('uid',$uid);
        $hash_password = hash('md4',$password);
        $model = model('App\Models\User_model');
        $check = $model->login($username, $hash_password);
        $if_remember = $this->request->getPost('remember');
        if ($check) {
            # Create a session 
            $session = session();
            $session->set('username', $username);
            $session->set('password', $password);
            if ($if_remember) {
                # Create a cookie
                $hash_password = hash('md4',$password);
                setcookie('username', $username, time() + (86400 * 30), "/");
                setcookie('password', $hash_password, time() + (86400 * 30), "/");
            }
            echo view("template/header");
            echo view("welcome_message");
            echo view("template/footer");
        } else {
            echo view('template/header');
            echo view('login', $data);
            echo view('template/footer');
        }
    }

    //
    public function profile_index() {
        $data['error'] ='';
        $session = session();
        
        $username = $session->get('username');
        
        
        if(!$username){
        echo view('template/header');
        echo view('login', $data);
        echo view('template/footer');

        }
        else{
        //config user interface
        $db = \Config\Database::connect();
        $builder = $db->table('app_accounts');
        $user = $builder->getWhere(['username' => $username])->getRow();
        $email = $user->email;
        $session = session();
        $session->set('email',$email);
        $email_status = $user->email_check;
        $number_status=$user->number_status;
        $phone = $user->phone_number;
        $pfname = $user->pfname;
        $profile_photo = $user->profile_photo;
        $data1 = array();
        // store username,phone,email_status, then display 
        //at users interface
        $data1[0]=$username;
        $data1[1]=$email;
        $data1[2]=$phone;
        $data1[3]=$email_status;
        $data1[4]=$number_status;
        $data1[5] = $pfname;
        $data1[6] = $profile_photo;
        echo view("template/header");
        //this  position no  data 
        echo view("user",['data1' => $data1]);
        echo view('template/footer');
        }
    }

    //add phone action index
    public function add_phone_index(){
        $data['error'] ='';
        echo view('template/header');
        echo view('add_phone',$data);
        echo view('template/footer');

    }
    // when user input phone, get the input and 
    //add it to database
    public function add_phone_action(){
        $session = session();
        $username = $session->get('username');
        $phone = $this->request->getPost('phone');
        if(!preg_match('/^(?:(?:\+?61|0)4(?:[ -]?\d){8}|13\d{1}[ \-]?\d{3}[ \-]?\d{4})$/',$phone)) {
            $data['error'] ='';
            echo view('template/header');
            echo 'your phone number is invalid, plz input again';
            echo view('add_phone',$data);
            echo view('template/footer');
           
        } else {
        $db = \Config\Database::connect();
        $builder = $db->table('app_accounts');
        $builder->set('phone_number',$phone);
        $builder->set('number_status',0);
        $builder->where('username',$username);
        $builder->update();
        $session = session();
        $session->set('phone_number', $phone);

        echo view('template/header');
        echo 'your phone number has updated successful';
        echo view('template/footer');
        }


    }

    public function ver_phone_index() {
        $data['error'] ='';
        $session = session();
        $phone = $session->get('phone_number');
        if($phone) {
        
        echo view('template/header');
        echo view('ver_phone',$data);
        echo view('template/footer');
        }else {
            echo 'error';
        }

    }



    //change email index
    public function change_email_index() {
        $data['error'] ='';
        echo view('template/header');
        echo view('change_email',$data);
        echo view('template/footer');

    }

    //change email action through session get name
    //set new email to database and send verification code to user
    public function change_email_action() {
        $data['error']='';
        $session = session();
        $username = $session->get('username');
        $email_new= $this->request->getPost('email');
        $session->set('email', $email_new);
        $db = \Config\Database::connect();
        $builder = $db->table('app_accounts');
        $builder->set('email',$email_new);
        $builder->set('email_check',0);
        $builder->where('username',$username);
        $builder->update();
        $model = model('App\Models\Register_model');
        $code = $model->generate_email_code($len = 16);
        $session->set('code',$code);
        $send_email = $model->send_email($email_new,$username,$code); 
       
        
        echo view('template/header');
        echo 'change email successfully';
        echo view('template/footer');

    }

    public function change_email_ver_index() {
        $data['error']='';   
        $session = session();
        $code = $session->get('code');
        $username = $session->get('username');
        $email = $session->get('email');
        if(!$code) {
        $model = model('App\Models\Register_model');
        $code = $model->generate_email_code($len = 16);
        $session->set('code',$code);
        $send_email = $model->send_email($email,$username,$code); 
        }
      
        echo view('template/header');
        echo view('change_email_ver',$data);
        echo view('template/footer');

    }

    public function change_email_ver_action() {
        $data['error']='';
        $code_input = $this->request->getPost('code');
        $session = session();
        $code = $session->get('code');
        if($code_input==$code) {
            $session = session();
            $username = $session->get('username');
            $email_new= $this->request->getPost('email');
            $db = \Config\Database::connect();
            $builder = $db->table('app_accounts');
            $builder->set('email_check',1);
            $builder->where('username',$username);
            $builder->update();
            echo view('template/header');
            echo 'verify email successful';
            echo view('template/footer');
        }else{
          
            echo view('template/header');
            echo 'please enter your code again';
            echo view('change_email_ver',$data);
            echo view('template/footer');

        }

    }

    public function add_photo_index() {
        $data['error']='';
        echo view('template/header');
        echo view('add_photo',$data);
        echo view('template/footer');

    }

    public function add_photo() {

        $image_type = '';
        $width = '';
        $height= '';
        $initial_image = '';
      
        $photo = $this->request->getFile('pfile');
        $size = $photo->getSize();
        $name =$photo->getName();
      
        $image_type = pathinfo($name, PATHINFO_EXTENSION);
        $initial_type =strtolower($image_type);
      
        //get image formats and change different type
       
        if($size<= 1024*1024 && ($initial_type== 'png' || $initial_type =='jpeg' || $initial_image =='jpg')) {
            $photo->move(WRITEPATH.'uploads');
            $path = WRITEPATH.'uploads/'.$name;
           
            if($initial_type == 'png') {
                $type = 'image/png';
            }else {
                $type = 'image/jpeg';
            }
        
    
        //transfer image formats
        // get original image width and height
        if($type == 'image/png'){
            $initial_image = imagecreatefrompng($path);
            $orign_width = imagesx($initial_image);
            $orign_height = imagesy($initial_image);
        } 
        else {
            $initial_image = imagecreatefromjpeg($path);
            $orign_width = imagesx($initial_image);
            $orign_height = imagesy($initial_image);
        }
       
        // resize the height and width of the image
        if ($orign_width>$orign_height) {
            $width = 90;
            $height = round($orign_height*($width/$orign_height));
        } else {
            $height = 90;
            $width = round($orign_width*($height/$orign_width));
        }

        $re_image = imagecreatetruecolor($width, $height);
        // store resized images to directory
        if ($image_type == '.png') {
            imagecopyresampled($re_image, $initial_image, 0, 0, 0, 0,$width, $height, $orign_width, $orign_height );
            imagepng($re_image, WRITEPATH . 'uploads/resized/' . $name);
        } else{
            imagecopyresampled($re_image, $initial_image, 0, 0, 0, 0,$width, $height, $orign_width, $orign_height );
            imagejpeg($re_image, WRITEPATH . 'uploads/resized/' . $name);
        }

        // set imag information 
        if( $name &&  $type) {
            $session = session();
            $username = $session->get('username');
            $db = \Config\Database::connect();
            $builder = $db->table('app_accounts');
            $builder->set('pfname',$name);
            $builder->set('profile_photo', $type);
            $builder->where('username', $username);
            $builder->update();
            echo view('template/header');
            echo 'update photo successfully';
            echo view('template/footer');
        } else {
            echo $pfname;
            echo $profile_photo;
            echo $photo;
            echo 'error';
        }
    } else {
        $data['error']='';
        echo view('template/header');
        echo 'image formats only support png, jpeg and jpg and no more than 1024kb';
        echo view('add_photo',$data);
        echo view('template/footer');

    }
    
        
    }

    public function location_index() {
        $data['error'] ='';
        // get users ip
        $ip = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
        //user ip api from whoisxmlapi
        $url = "https://ip-geolocation.whoisxmlapi.com/api/v1?apiKey=at_uBNSBqerhISEvX2S0TPtlmfqF61It&ipAddress=$ip";
        $ch = curl_init();

        // this is from https://stackoverflow.com/questions/35194124/php-what-does-curlopt-url-really-do
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       
        $lo = curl_exec($ch);
        curl_close($ch);
         
        $re = json_decode($lo);
        
        // get lat and lon from ip
        $lat = $re->location->lat;
        $lon = $re->location->lng;
        // since uq wifi ip is private
        //change the lat and lon to uq
        if(!$lat){
            $lat = -27.499;
            $lon = 153.0137;
        }
       
        // this is the display of map
        //from https://leafletjs.com/
        $layout= "<!DOCTYPE html>
        <html lang='en'>
        <meta charset='utf-8'>
        <title>user's location</title>
        <head>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.min.css' />
        </head>
        <body>
        <style>
        #map { height: 600px; }
        </style>
        <div id='map'></div>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.min.js'></script>
        <script>
             var user_map = L.map('map').setView([$lat, $lon], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors'
            }).addTo(user_map);
            L.marker([$lat, $lon]).addTo(user_map);
        </script>
        </body>
        </html>";
       $session = session();
       $username = $session->get('username');
       if($username) {
       $data_l = array();
       $data_l[0] = $layout;
       echo view('template/header');
       echo view('location',['data_l' => $data_l]);
       echo view('template/footer');   
       } else {
       echo view('template/header');
       echo view('location');
       echo view('template/footer');  
       } 

    }

    public function file_uploads() {
        $session = session();
        $username = $session->get('username');
        if($username) {
        $data['error'] = '';
        echo view('template/header');
        echo view('file_uploads',$data);
        echo view('template/footer'); }
        else {
        echo view('template/header');
        echo view('login');
        echo view('template/footer');

        }
        

    }

    // codes come from : https://makitweb.com/drag-drop-file-upload-with-dropzone-in-codeigniter-4/
    public function file_uploads_action() {
        $data = array();

        // Read new token and assign to $data['token']
        $data['token'] = csrf_hash();
  
        ## Validation
        $validation = \Config\Services::validation();
  
        $input = $validation->setRules([
           'file' => 'uploaded[file]|max_size[file,2048]|ext_in[file,jpeg,jpg,png,pdf],'
        ]);
  
        if ($validation->withRequest($this->request)->run() == FALSE){
  
            $data['success'] = 0;
            $data['error'] = $validation->getError('file');// Error response
  
        }else{
  
            if($file = $this->request->getFile('file')) {
               if ($file->isValid() && ! $file->hasMoved()) {
                  // Get file name and extension
                  $name = $file->getName();
                  $ext = $file->getClientExtension();
  
                  // Get random file name
                  $newName = $file->getRandomName();
  
                  // Store file in public/uploads/ folder
                  $file->move('../writable/upload', $newName);
  
                  // Response
                  $data['success'] = 1;
                  $data['message'] = 'Uploaded Successfully!';
  
               }else{
                  // Response
                  $data['success'] = 2;
                  $data['message'] = 'File not uploaded.'; 
               }
            }else{
               // Response
               $data['success'] = 2;
               $data['message'] = 'File not uploaded.';
            }
        }
        return $this->response->setJSON($data);
  
     }

    public function timetable() {
        // get user id from app_accounts table
        $session = session();
        $username = $session->get('username');
        $db = \Config\Database::connect();
        $builder = $db->table('app_accounts');
        $user = $builder->getWhere(['username' => $username])->getRow();
        $uid = $user->id;
        $calendar = new Calendar();
        //get this user's all of events and set it to $events and pass it to view
        $db = \Config\Database::connect();
        $builder = $db->table('events');
      
        $events = $builder->getWhere(['uid' => $uid])->getResult();
        if ($events) {
        foreach ($events as $e) {
            $calendar->add_event($e->title, '2023-'.$e->month.'-'.$e->day, 1, 'red');     
          }
        }
        $data['error'] ='';  
       
        echo view('template/header');
       
        echo view('timetable',['calendar' => $calendar]);
      

    }

    public function add_event() {
        $session = session();
        $username = $session->get('username');
        if($username) {
        $db = \Config\Database::connect();
        $builder = $db->table('app_accounts');
        $user = $builder->getWhere(['username' => $username])->getRow();
        $uid = $user->id;
        $session->set('uid', $uid); 
        $data['error'] = '';
        echo view('template/header');
        echo view('add_event',$data);
        echo view('template/footer');}
        else {
        echo view('template/header');
        echo view('login');
        echo view('template/footer');
        }
    }

    public function add_event_action () {
        $month = $this->request->getPost('event_date_month');
        $day = $this->request->getPost('event_date_day');
        $title = $this->request->getPost('title');
        $detail = $this->request->getPost('detail');
        $model = model('App\Models\Events_model');
        $session = session();
        $uid = $session->get('uid');
        $add_event = $model->events($month, $day, $title, $detail, $uid);
        if($add_event) {
        echo view('template/header');
        echo 'add event successfully';
        echo view('template/footer');
        } else {
            echo view('template/header');
            echo 'please try again';
            echo view('add_event');
            echo view('template/footer');
        }
    }

    public function delete_event() {
        $session = session();
        $uid = $session->get('uid');
        $db = \Config\Database::connect();
        $builder = $db->table('events');
        $event = array();
        $event = $builder->getWhere(['uid' => $uid])->getResult();
        $data['error'] = '';
        echo view('template/header');
        echo view('delete_event',['event' => $event]);
        echo view('template/footer');
    }

    public function delete_event_action() {
        $db = \Config\Database::connect();
        $builder = $db->table('events');
        $eid = $this->request->getPost('eid');
        $delete_eid = $builder->getWhere(['id'=>$eid]);
        $num=$delete_eid->getNumRows();
        if($num==1) {
        $builder->where('id', $eid);
        $builder->delete();
        echo view('template/header');
        echo 'delete event successful';
        
        echo view('template/footer');
        } else {
            echo view('template/header');
            echo 'not found this event, plz check again';
            echo view ('delete_event');
            echo view('template/footer');
        }

    }

    public function post() {
        $data['error']='';
        echo view('template/header');
        echo view('post',$data);

    }

    public function post_action() {

         $session = session();
         $uid =$session->get('uid');
         $title = $this->request->getPost('qtitle');
         $content = $this->request->getPost('article');
         $model = model('App\Models\Article_model');
         $insert = $model->insertArticle($title, $content, $uid);
         if($insert) {
             echo view('template/header');
             echo "post successfully";
         } else{
            echo view('template/header');
            echo "fail";
            echo view('post');
         }
    }

    public function home() {
        $db = \Config\Database::connect();
        $builder = $db->table('articles');
        $articles = $builder->get()->getResult();
        $builder = $db->table('comments');
        $comments = $builder->get()->getResult();
        $message = '';
        $messages = array();
        $i = 0;
        if($articles) {
        foreach($articles as $a) {
            // this code come from https://mdbootstrap.com/docs/standard/extended/comments/#! 
            $qid = $a->id;
            $message='
            <section style="background-color: #eee;">      
            <div class="container my-5 py-5">
              <div class="row d-flex justify-content-center">
                <div class="col-md-12 col-lg-10 col-xl-11">
                  <div class="card">
                  <h4>Article id:'.$qid.'</h4>
                    <div class="card-body">
                      <div class="d-flex flex-start align-items-center">                    
                        <div>
                          <h6 class="fw-bold text-primary mb-1">'.$a->title.'</h6>
                          <p class="text-muted small mb-0"></p>
                          
                      <p class="mt-3 mb-4 pb-2">' . $a->content . '</p>';
          if($comments) {
              // find all of comments related to this article, identified by article's id.
              foreach($comments as $c) {
                  $id = $c->qid;
                  $uid = $c->uid;
                  if($id == $qid ){
                    $db = \Config\Database::connect();
                    $builder = $db->table('app_accounts');
                     $user = $builder->getWhere(['id' => $uid])->getRow();
                     $username = $user->username;
                  $message.=' <p class="mt-3 mb-4 pb-2">'.$username .'  :  ' . $c->comment . '</p>';
                  }
              }
          }
          $message.='  </div> </div> </div> </div> </div> </div> </div> </section>';
          $messages[$i] = $message;
          $i=$i+1;
        }
    }
         echo view('template/header');
         echo view('home',['messages' => $messages]);

    }

    public function home_action() {
        $session = session();
        $uid =$session->get('uid');
        $c = $this->request->getPost('comments');
        $qid = $this->request->getPost('qid');
        $model = model('App\Models\Article_model');
        $insert = $model->insertComments($c, $uid, $qid);
        $db = \Config\Database::connect();
        $builder = $db->table('articles');
        $article = $builder->getWhere(['id' => $qid])->getRow();
        $mun_comments = $article->likes;
        $mun_comments = $mun_comments +1;
        $builder->set('likes', $mun_comments);
        $builder->where('id', $qid);
        $builder->update();
        if($insert) {
            echo view('template/header');
            echo "post successfully";
        } else{
           echo view('template/header');
           echo "fail";
        }

    }

    public function rank() {
        // get the title and num of comments from table 'articles'
        $db = \Config\Database::connect();
        $builder = $db->table('articles');
        $articles = $builder->get()->getResult();
        $ranks = array();
        $i = 0;
        $message = '';
        if($articles) {
            //store each title and num of comments
            foreach($articles as $a) {
                $key = $a->title;
                $value = $a->likes;
                $ranks[]= array('key'=> $key,'value' => $value);
            }
            // sort num of comments 
           $v = array_column($ranks,'value');
           array_multisort($v,SORT_DESC,$ranks);
            foreach($ranks as $rank) {
                $title = $rank['key'];
                $num = $rank['value'];
                $db = \Config\Database::connect();
                $builder = $db->table('articles');
                $article = $builder->getWhere(['title' => $title])->getRow();
                $content = $article->content;
                $qid = $article->id;

                 // this code come from https://mdbootstrap.com/docs/standard/extended/comments/#! 
                $message.='
                <section style="background-color: #eee;">
                <div class="container my-5 py-5">
                <h4> '.$num.' comments </h4>
                  <div class="row d-flex justify-content-center">
                    <div class="col-md-12 col-lg-10 col-xl-8">
                      <div class="card">
                      <h4>Article id:'.$qid.'</h4>
                        <div class="card-body">
                          <div class="d-flex flex-start align-items-center">
                            
                            <div>
                              <h6 class="fw-bold text-primary mb-1">'.$title.'</h6>
                              <p class="text-muted small mb-0"></p>        
                          <p class="mt-3 mb-4 pb-2">' . $content . '</p>
                          </div> </div> </div> </div> </div> </div> </div> </section>';
            }
            echo view('template/header'); 
            echo view('rank',['message' => $message]);
        } 
    }

    public function search() {
        $data['error'] ='';
        echo view('template/header');
        echo view('search',$data);
    }

    //search_action function's:https://www.studentstutorial.com/codeigniter/autocomplete-search-from-ajax
    public function search_action()
    {
        helper(['form', 'url']);
 
        $data = [];
 
        $db      = \Config\Database::connect();
        $builder = $db->table('articles');   
 
        $query = $builder->like('title', $this->request->getVar('q'))
                    ->select('title, content as text')
                    ->limit(10)->get();
        $data = $query->getResult();
         
        echo json_encode($data);
    }
 


    // this is from lecture and prac week 4
    public function logout()
    {
        helper('cookie');
        $session = session();
        $session->destroy();
        //destroy the cookie
        setcookie('username', '', time() - 3600, "/");
        setcookie('password', '', time() - 3600, "/");
        return redirect()->to(base_url('login'));
    }
}
