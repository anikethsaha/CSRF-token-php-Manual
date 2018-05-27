<?php 
	require 'dbconfig.php';
  require './protection_tokens/session_encryption.php';
	session_start();
  if(!isset($_SESSION['user'])){
    
    header('location: http://localhost/intern-flairtales/index.php ');
  }
  $session_user_decrypted_value = new session_Ecnryption();
  $loggedInUser = $session_user_decrypted_value->Decrypt($_SESSION['user']); 
	$stmt = $dbh->prepare("SELECT * FROM $db.registration WHERE name = ? ");
	$stmt->execute([$loggedInUser]);
	$user = $stmt->fetchAll();
	
 ?>


 <!DOCTYPE html>
 <html>
 <head>
 	<title>HOME PAGE </title>
 	<link rel="stylesheet" type="text/css" href="css/skeleton.css">
 	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 </head>
 <style type="text/css">
 	.card {
    margin: 1em auto;
   
    max-width: 300px;
    /*margin: auto;*/
    text-align: center;
    background: white;
}

.title {
    color: grey;
    font-size: 18px;
}
body{
      background: #e8eaf5;
}
img{
	width: 80%;
}
.social{
  text-align: center;
padding: 1em;
}
.social a{
  margin:0 1em;
}
button {
    border: none;
    outline: 0;
    display: inline-block;
    padding: 8px;
    color: white;
    background-color: #000;
    text-align: center;
    cursor: pointer;
    width: 100%;
    font-size: 18px;
}

a {
    text-decoration: none;
    font-size: 22px;
    color: black;
}

button:hover, a:hover {
    opacity: 0.7;
}
 </style>
 <body>


<div class="card">
  <img src="profilePic.jpg" alt="John">
 
  
  <?php 
  	foreach ($user as $u) {
  ?>
   <h1><?php echo $u['Name']; ?></h1>
  <p> <?php  echo $u['University']; ?>   University</p>
    <p> <?php  echo $u['Phone_Number']; ?>   </p>
  <p class="title"><?php  echo $u['Email'];  ?></p>
 <?php } ?>
 <a href="logout.php">
     <p><button class="button button-primary" style="margin-left: 0;
border-radius: 0;
background: #1ab188;
color: #ffffff;
display: block;
text-decoration: none;


font-size: 20px;


text-align: center;
cursor: pointer;
-webkit-transition: .5s ease;
transition: .5s ease;">LOgout</button></p>
 </a>
</div>

 </body>
<?php 

include('footer.php');
 ?>
 </html>