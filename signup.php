<?php
 $showalert=false;
 $showerror=false;
 $flag=true;
$nameerr=$emailerr=$gendererr=$passerr=$cpasserr=NULL;
$username1=$email=$gender=$userpassword=$cpassword=NULL;
if($_SERVER["REQUEST_METHOD"]=="POST"){

  
  if(empty($_POST['uname'])){
    $nameerr="Name cannot be empty";
    $flag=false;
  }
  else if(strlen($_POST['uname'])<=2){
    $nameerr="Name must be at lease 3 character";
    $flag=false;
  }
  else{
    $username1=$_POST['uname'];
  }

  if(empty($_POST['email'])){
    $emailerr="Email cannot be empty";
    $flag=false;
  }
  else{
    $email=$_POST['email'];
  }

  if(empty($_POST['gender'])){
    $gendererr="Gender must be choose";
    $flag=false;
  }
  else{
    $gender=$_POST['gender'];
  }

  if(empty($_POST['pass'])){
    $passerr="Password cannot be empty";
    $flag=false;
  }
  else if(strlen($_POST['pass'])<=4){
    $passerr="Password must be atleast 5 character";
    $flag=false;
  }
  else if((!str_contains($_POST['pass'],'$')) && (!str_contains($_POST['pass'],'@')) && (!str_contains($_POST['pass'],'#'))&& (!str_contains($_POST['pass'],'&')) && (!str_contains($_POST['pass'],'*'))){
    $passerr="Password must contain atleast 1 special character ('@','#','$','&','*')";
    $flag=false;
  }
  else{
    $userpassword=$_POST['pass'];
  }

  if(empty($_POST['cpass'])){
    $cpasserr="Confirm Password cannot be empty";
    $flag=false;
  }
  else{
    $cpassword=$_POST['cpass'];
  }

  include 'dbconnect1.php';
  
  if($flag){
    $existsql="SELECT * FROM `signup` WHERE `email`='$email'";
    $result=mysqli_query($connect,$existsql);
    $numexistrow=mysqli_num_rows($result);
    if($numexistrow>0){
        $showerror="Email Already exist";
    }
    else{
      if(($userpassword==$cpassword) ){
        $hash=password_hash($userpassword, PASSWORD_DEFAULT);
        $sql="INSERT INTO `signup`(`username`,`email`,`gender`,`password`) VALUES ('$username1','$email','$gender','$hash')";
        $result=mysqli_query($connect,$sql);
        echo $password;
        // header("location:login.php");

        if($result){
            $showalert=true;    
        }
        else{
          echo mysqli_error($connect);
        }
        $username1=$email=$gender=$userpassword=$cpassword=NULL;
      }
      else{
        $showerror="Password do not match";
      }
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

    <title>Sign Up</title>
    <style>
      .container{
        width:1250px;
      }

      
      .check{
        margin-right: 4px;
        margin-left: 27px;
        margin-bottom: 15px;
      }

      .check1{
        margin-left:0;
      }

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
      
      if($showalert){
        echo '    
          <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success!</strong> Your account is created, now you can login.
          <span id="hide" onclick="hide()">X</span>
          </div>
        ';
      }
      if($showerror){
        echo' 
          <div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error!</strong> '.$showerror.'
          <span id="hide"  onclick="hide()">X</span>
          </div>
        ';
      }

    ?>


    <div class="container my-4" >
   
      <h1 class="text-center">Sign Up to iNoteBook</h1>
      <form actiom="/project/signup.php" method="post">
        <label for="">Name</label>
        <input type="text" name="uname" id="" class="input" value="<?=$username1;?>">
        <p class="red"><?=$nameerr;?></p>
        <label for="">Email</label>
        <input type="email" name="email" id="" class="input" value="<?=$email;?>">
        <p class="red"><?=$emailerr;?></p>
        <label for="">Gender</label>
        <input type="radio" name="gender" value="Male" class="check check1">Male</input>
        <input type="radio" name="gender" value="Female" class="check">Female</input>
        <input type="radio" name="gender" value="Other" class="check">Other</input>
        <p class="red"><?=$gendererr;?></p>
        <label for="">Password</label>
        <input type="text" name="pass" id="" class="input" value="<?=$userpassword;?>">
        <p class="red"><?=$passerr;?></p>
        <label for="">Confirm Password</label>
        <input type="text" name="cpass" id="" class="input" value="<?=$cpassword;?>">
        <p class="red"><?=$cpasserr;?></p>
        <button type="submit" >Sign Up</button>
      </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>