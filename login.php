<?php
  $login=false;
  $showerror=false;
  $flag=true;
  $email=$userpassword=NULL;
  $emailerr=$passerr=NULL;
if($_SERVER["REQUEST_METHOD"]=="POST"){ 

  if(empty($_POST['email'])){
    $emailerr="Email cannot be empty";
    $flag=false;
  }
  else{
    $email=$_POST['email'];
  }

  if(empty($_POST['pass'])){
    $passerr="Password cannot be empty";
    $flag=false;
  }
  else{
    $userpassword=$_POST['pass'];
  }
   
  include 'dbconnect1.php';  
    
  if($flag){
    $sql="SELECT * from `signup` where `email`='$email'";
    $result=mysqli_query($connect,$sql);
    $num=mysqli_num_rows($result);
    if($num==1){
      
      while($row=mysqli_fetch_assoc($result)){
        
        if(password_verify($userpassword,$row['password'])){              
          $login=true;  
          session_start();
          $_SESSION['logedin']=true;
          $_SESSION['username']=$row['username'];
          $_SESSION['email']=$row['email'];
          $_SESSION['userid']=$row['srno'];
          header("location: welcome.php");
        }
        else{
          $showerror=true;
        }

      }          
    }

    else{
      $showerror=true;
    }
  }
       
}
    
    
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Login</title>
  
  <style>
    #hide{
      padding: 0px 9px;
      color: green;
      padding-bottom: 4px;
      position: absolute;
      right: 19px;
      cursor:pointer;
    }
    #hide:hover{
      color:red;
    }
  </style>

</head>
<body>
  <script>
    function hide(){
      document.querySelector('#alert').style.display='none';
    }
  </script>
  
  <?php

    require 'nav1.php';
    
    if($login){
        echo '    
          <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success!</strong> you are loged in.
          <span id="hide" onclick="hide()">X</span>
          </div>
        ';
    }

    if($showerror){
        echo' 
          <div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error!</strong> Invalid Credentials.
          <span id="hide" onclick="hide()">X</span>
          </div>
        ';
    }
  ?>


  <div class="container my-4" >
  
    <h1 class="text-center">Login to our Website</h1>
    <form actiom="/project/login.php" method="post">
      <label for="">Email</label>
      <input type="email" name="email" id="" class="input" value="<?=$email;?>">
      <p class="red"><?=$emailerr;?></p>
      <label for="">Password</label>
      <input type="text" name="pass" id="" class="input" value="<?=$userpassword;?>">
      <p class="red"><?=$passerr;?></p>
      <button type="submit" >Login</button>
    </form>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>