<?php
include('php/connection.php');

session_start();


if(!isset($_SESSION['logged_in'])){
    header('location: login.php');
    exit;
}     

if(isset($_GET['logout'])){
    if(isset($_SESSION['logged_in'])){
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        header('location: login.php');
        exit;
    }
}



if(isset($_POST['change_password'])){
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $user_email = $_SESSION['user_email'];

    if($password !== $confirmpassword){

        header('location: account.php?error=passwords dont match');



//if password is less than 8 characters
      } else if(strlen($password)<8){
         header('location:account.php?error=password must be at least 8 characters');
        //no errors
      }else{
       $stmt = $conn->prepare("UPDATE users set user_password=? where user_email=?;");
       $stmt->bind_param('ss',md5($password),$user_email);

       if($stmt->execute()){
        header('location: account.php?message=password has been updated successfully');
       }else{
        header('location: account.php?error=could not update password');
       }

      }
}

//get orders 
if(isset($_SESSION['logged_in'])){
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM orders where user_id=?");
    $stmt->bind_param('i',$user_id);
    $stmt->execute();
    $orders = $stmt->get_result();
}






?>
<?php 
include('layouts/header.php');
?>

<!-- Account -->
 <section class="mt-5 " style="padding: 100px;">
  <div class="row container mx-auto">
    <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
    <p class="text-center" style="color:green;"><?php if(isset($_GET['register_success'])){ echo $_GET['register_success'];}?></p>
    <p class="text-center" style="color:green;"><?php if(isset($_GET['login_success'])){ echo $_GET['login_success'];}?></p>
        <h3 class=" font-weight-bold">Account Info</h3>
        <hr class="mx-auto">
        <div class="account-info">
            <p><span><?php if(isset($_SESSION['user_name'])){echo $_SESSION['user_name'];}?></span></p>
            <p>Email: <span><?php if(isset($_SESSION['user_email'])){echo $_SESSION['user_email'];}?></span></p>
            <p><a href="orders#" id="orders-btn">Your Orders</a></p>
            <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
        </div>
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12">
        <form id="account-form" method="POST" action="account.php">
            <p class="text-center" style="color:red;"><?php if(isset($_GET['error'])){ echo $_GET['error'];}?></p>
            <p class="text-center" style="color:green;"><?php if(isset($_GET['message'])){ echo $_GET['message'];}?></p>
            <H3 class="text-center mt-5 " style="padding:50px;">Change Password</H3>
            <hr class="mx-auto">
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" id="account-password" name="password" placeholder="password" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="form-control" id="account-password-confirm" name="confirmpassword" placeholder="ConfirmPassword" required>
            </div>
            <div class="form-group">
                <input type="submit" value=" ChangePassword" id="change-pass-btn" name="change_password" class="btn">
            </div>
        </form>
    </div>
  </div>
 </section>

<!---Orders-->
<section id="orders" class="orders container my-5  py-3">
    <div class="container mt-2" style="padding: 80px;">
        <h2 class="font-weight bolde text-center">Your Orders</h2>
        <hr class="mx-auto">
    </div>

    <table class="mt-5 pt-5">
    <tr>
        <th>Order id</th>
        <th>Order Cost</th>
        <th>Order Status</th>
        <th>Order Date</th>
        <th>Order Details</th>
    </tr>
   
    <?php while ($row = $orders->fetch_assoc()){?>
        <tr>
            <td>
                <div class="product-info">
                <!--<img src="assets/iamges/liba.png">-->
                    <div>
                        <p class="mt-3"><?php echo $row['order_id'];?></p>
                    </div>
                </div>
             </td>
            <td>
                <span><?php echo $row['order_cost'];?></span>
            </td>
            <td >
                 <span ><?php echo $row['order_status'];?></span>
            </td>
            <td>
                <span><?php echo $row['order_date'];?></span>
            </td>
            <td>
                <form method="POST" action="order_details.php">
                    <input type="hidden" name="order_status" value="<?php echo $row['order_status'];?>"/>
                    <input type="hidden" name="order_id" value="<?php echo $row['order_id'];?>">
                    <input class="btn order-details-btn" type="submit" name="order_details_btn" value=" Details" />
    </form>
            </td>
     </tr> 
    <?php } ?>
</table>


</section>








<?php 
include('layouts/footer.php');
?>