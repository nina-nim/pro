<?php


session_start();

include('php/connection.php');

if(isset($_SESSION['logged_in'])){

  header('location: account.php?');
  exit;

}

if(isset($_POST['register'])){

      $name = $_POST['name'];


      $email = $_POST['email'];

      $password = $_POST['password'];

      $confirmpassword= $_POST['confirmpassword'];
  //password dont match
        if($password !== $confirmpassword){

          header('location:register.php?error=passwords dont match');



  //if password is less than 8 characters
        } else if(strlen($password)<8){
           header('location:register.php?error=password must be at least 8 characters');

        }else{
          //check whether there is a user with this email or not
          $stmt1 = $conn->prepare("SELECT count(*) FROM users where user_email=?");
          $stmt1->bind_param('s',$email);
          $stmt1->execute();
          $stmt1->bind_result($num_rows);
          $stmt1->store_result();
          $stmt1->fetch();
            if($num_rows!=0){
             header('location:register.php?error=user with this email already exists');
             //if no user registred with this email before
           }else{
  //create  a new user
                $stmt = $conn->prepare("INSERT INTO  users (user_name,user_email, user_password)
                VALUES (?,?,?);");



                $stmt->bind_param('sss',$name,$email,md5($password));
               
           }
      //account was created successfully
          if($stmt->execute()){
            $user_id = $stmt->insert_id;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $name;
            $_SESSION['logged_in'] = true;

            header('location:account.php?register_success=you registered successfully');
      //account could not be created for some reason
          }else{
           header('location:register.php?error=could not create an account at the moment');
          
          }





         } 

}




//if user has already registered than take user to account page 





?>





<?php
include('layouts/header.php');
?>





<!-- Register -->
 <section class="mt-5 " style="padding: 100px;">
    <div class="container text-center mt-3 pt-5" >
    <h2 class="form-weight-bold" >Register</h2>
    <hr class="mx-auto">
    
 </div>
 <div class="mx-auto container">
    <form id="register-form" method="POST" action="register.php">
        <p style="color:red;"> <?php  if (isset($_GET['error'])){echo $_GET['error'];}?></p>
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" id="register-name" name="name" placeholder="Name" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" id="register-email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" class="form-control" id="register-confirm-password" name="confirmpassword" placeholder="ConfirmPassword" required>
        </div>
        <div class="form-group">
            
            <input type="submit" class="btn" id="register-btn" value="Register"  name="register">
        </div>
        <div class="form-group">
            
            <a id="login-url" href="login.php" class="btn"> Are you a member? Login</a>
        </div>
    </form>
 </div>
 </section>










 <?php
include('layouts/footer.php');
?>