
<?php
  require './protection_tokens/csrf_token.php';  // please read the csrf_token.php file for the reason I am creating the token manually


?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Sign-Up/Login Form</title>
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/normalize.css">

     <link rel="stylesheet" href="css/toastr.css">
   
      <link rel="stylesheet" href="css/style.css">

</head>

<body>
  <div class="form">
      
      <ul class="tab-group">
        <li class="tab active"><a href="#signup">Sign Up</a></li>
        <li class="tab" onclick=""><a href="#login">Log In</a></li>
      </ul>
      
      <div class="tab-content">
        <div id="signup">   
          <h1>Sign Up for Free</h1>
          <p style="color: #777777;">You need to register first for login</p>
          
          <form  method="post" class="registration-form">
          
          <div class="top-row">
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              </label>
              <input required  type="text" name="name"   autocomplete="off" />
            </div>
          <input required  type="hidden" name="_token" class="_token" value="<?php echo $token ?>" >
            <div class="field-wrap">
              <label>
                phone Number<span class="req">*</span>
              </label>
              <input required  type="Number" name="phone_no"   autocomplete="off"/>
            </div>
          </div>

          <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input required  type="text" name="email"  autocomplete="off"/>
          </div>
            <div class="field-wrap">
            <label>
              UNIVERSITY<span class="req">*</span>
            </label>
            <input required  type="text" name="university"  autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Set A Password<span class="req">*</span>
            </label>
            <input required  type="password" name="password"  autocomplete="off"/>
          </div>  
          <span id="reg-error"></span>
          
          <button type="submit" class="button button-block"/>Get Started</button>
          
          </form>

        </div>
        
        <div id="login">   
          <h1>Welcome Back!</h1>
          
          <form  method="post" class="login-form">
          
            <div class="field-wrap">
             <input required  type="hidden" name="_token" class="_token" value="<?php echo $token ?>" >

            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email" name="email" autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input type="password" name="password" autocomplete="off"/>
          </div>
          
          <p class="forgot"><a href="#">Forgot Password?</a></p>
          
          <button class="button button-block"/>Log In</button>
          
          </form>

        </div>
        
      </div><!-- tab-content -->
      
</div> <!-- /form -->
 

  <script src='js/jquery.js'></script>
 <script type="text/javascript" src="js/toastr.js"></script> 
 <script type="text/javascript" src="js/validator.min.js"></script>








<!-- UI script for the ;ogin form from here -->
<script type="text/javascript">
  $('.form').find('input, textarea').on('keyup blur focus', function (e) {
  
  var $this = $(this),
      label = $this.prev('label');

    if (e.type === 'keyup') {
      if ($this.val() === '') {
          label.removeClass('active highlight');
        } else {
          label.addClass('active highlight');
        }
    } else if (e.type === 'blur') {
      if( $this.val() === '' ) {
        label.removeClass('active highlight'); 
      } else {
        label.removeClass('highlight');   
      }   
    } else if (e.type === 'focus') {
      
      if( $this.val() === '' ) {
        label.removeClass('highlight'); 
      } 
      else if( $this.val() !== '' ) {
        label.addClass('highlight');
      }
    }

});


$('.tab a').on('click', function (e) {
  
  e.preventDefault();
  
  $(this).parent().addClass('active');
  $(this).parent().siblings().removeClass('active');
  
  target = $(this).attr('href');

   $('.tab-content > div').not(target).hide();
     // $('.tab-content > div ' + target).show();
  
  $(target).fadeIn(600);
  
});




</script>



    <!--  Api call for registration and login script from here  -->
<script type="text/javascript">
$(document).ready(() => {
     localStorage.setItem('reg',"not_loggedIn");
     console.log(localStorage.getItem('reg'));
});

//   ..Login action


   $('.login-form').on('submit',(e) => {
      e.preventDefault();
     
      
          // commented for deveoplment


          // if(localStorage.getItem('reg') == "not_loggedIn"){          
          //   toastr.error("Please Register first");
          //   return false;
          // }         

    
      var email = $(".login-form input[name='email']").val(); 
      var password = $(".login-form input[name='password']").val(); 

      if(!validator.isEmail(email) || validator.isEmpty(email))
        {
          toastr.warning("please insert correct email");
          return false
        }
      if(!validator.isAlphanumeric(password) || validator.isEmpty(password))
        {
          toastr.warning("password must contains numbers and alphabets");
          return false
        }

       email = XSSPreventSanitizer(email);
       password = XSSPreventSanitizer(password);   

             $.ajax({
        url:"logAction.php",
        type:"post",
        dataType:"text",
        data : { email : email , password : password , actionType : "log"},
        headers: {
         'X-CSRF-TOKEN': $("._token").val()
        },

        success:function(res){
         // console.log(JSON.parse(res));
         res = JSON.parse(res);
         console.log(res);
          
          // // console.log("json" , res.status);
          
          if(String(res.status) == "Success"){
              window.location.href ="home.php" 
            
              // Now You are login with a ecnrypted session having the name
          }

          if(String(res.status) == "Forbidden"){
             console.log(res.error)
              window.location.href ="error.php"
          }
          if(String(res.status) == "Failed"){
            console.log(res.error)
            toastr.error(res.error);
          }
        }
    });
      
  })



//    .. Registration action

  $('.registration-form').on('submit',(e) => {
  e.preventDefault();
  var name = $(".registration-form input[name='name']").val(); 
  var phone_no = $(".registration-form input[name='phone_no']").val(); 
  var email = $(".registration-form input[name='email']").val(); 
  var password = $(".registration-form input[name='password']").val(); 
   var university = $(".registration-form input[name='university']").val(); 

  // filtering the inputs
  if(!validator.isEmail(email) || validator.isEmpty(email)){
    toastr.warning("please insert correct email");
    return false
  }
  if(!validator.isNumeric(phone_no) || validator.isEmpty(phone_no)){
    toastr.warning("please insert correct phone Number");
    return false
  }
  // if(!validator.isAlpha(name) || validator.isEmpty(name)){
  //   toastr.warning("please insert correct Name");
  //   return false
  // }
   if(!validator.isAlpha(university) || validator.isEmpty(university)){
    toastr.warning("please insert correct Name");
    return false
  }
    if(!validator.isAlphanumeric(password) || validator.isEmpty(password)){
    toastr.warning("pPassword must contains numbers and alphabets");
    return false
  }
  
  // sanitizing the inputs against Xss attacks if any
    name = XSSPreventSanitizer(name);
    phone_no = XSSPreventSanitizer(phone_no);
    email = XSSPreventSanitizer(email);
    password = XSSPreventSanitizer(password);
    university = XSSPreventSanitizer(university);

  // Ajax request to the server for registration

     
      $.ajax({
        url:"logAction.php",
        type:"post",
        dataType:"text",
        data : {name : name , phone_no : phone_no , email : email , password : password , university : university, actionType : "reg"},
        headers: {
         'X-CSRF-TOKEN': $("._token").val()
        },

        success:function(res){
          // console.log(JSON.parse(res));
          // console.log(res);
         res = JSON.parse(res);
          
          // console.log("json" , res.status);
          
          if(String(res.status) == "Success"){
              
              localStorage.setItem('reg',"loggedIn");     // for first time user
              toastr.success("Great ! Done Now LOgin");
             // console.log("inside success")
              // window.location.href ="home.php" // used just for testing
              // Now You can Go for login
          }
           if(String(res.status) == "Forbidden"){


             console.log(String(res.error))
              window.location.href ="error.php"
          }
           if(String(res.status) == "Failed"){


            console.log(String(res.error))
            toastr.warning(String(res.error));
          }
        }
    });
  
});
 
 const XSSPreventSanitizer = (stringtoSanitize) =>{
    stringtoSanitize = validator.blacklist(stringtoSanitize, '\\[\\ ]');
    stringtoSanitize = validator.escape(stringtoSanitize);
    stringtoSanitize = validator.trim(stringtoSanitize);
    stringtoSanitize = validator.stripLow(stringtoSanitize);
    return stringtoSanitize;
  }
</script>
</body>
<?php include('footer.php'); ?>
</html>
