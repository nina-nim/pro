<?php




/* not paid 
shipped 
delivered
*/
include('PHP/connection.php');

if(isset($_POST['order_details_btn'])&& isset($_POST['order_id'])){
        $order_id = $_POST['order_id'];
        $order_status = $_POST['order_status'];

      $stmt=  $conn->prepare("SELECT * FROM order_items WHERE order_id=?;");
      $stmt->bind_param('i',$order_id);
      $stmt->execute();

      $order_details = $stmt->get_result();

      $total_order = calculateTotalOrderPrice($order_details);
      
      if($order_details->num_rows > 0){
          $order_details = $order_details;
      }else{
          header('location: account.php?error=order not found');
          exit;
      }

} else if(isset($_GET['order_id']) && isset($_GET['order_status'])){
    $order_id = $_GET['order_id'];
    $order_status = $_GET['order_status'];

    $stmt=  $conn->prepare("SELECT * FROM order_items WHERE order_id=?;");
    $stmt->bind_param('i',$order_id);
    $stmt->execute();

    $order_details = $stmt->get_result();



    if($order_details->num_rows > 0){
        $order_details = $order_details;
    }else{
        header('location: account.php?error=order not found');
        exit;
    }

} else{
    header('location: account.php?error=order not found');
    exit;
}





function calculateTotalOrderPrice($order_details){

    $total = 0;

    
  foreach( $order_details as $row){ 


  $produt_price = $row['product_price'];
  $product_quantity = $row['product_quantity'];


  $total = $total + ($produt_price * $product_quantity);

}

    return $total;
}
















?>



<?php 
include('layouts/header.php');
?>






<!---Orders-details-->
<section id="orders" class="orders container my-5  py-3">
    <div class="container mt-5" style="padding: 80px;">
        <h2 class="font-weight bolde text-center">Order Details</h2>
        <hr class="mx-auto">
    </div>

    <table class="mt-5 pt-5 mx-auto">
    <tr>
        <th>Product </th>
        <th>Price</th>
        <th>Quantity </th>
        <!--<th>Order Details</th>--->
    </tr>
   <?php foreach($order_details as $row){ ?>

        <tr>
            <td>
                <div class="product-info">
                  <img src="assets/iamges/<?php echo $row['product_image']; ?>" alt="product-image" />
                    <div>
                      <p class="mt-3"><?php echo $row['product_name'];?></p>
                  </div>
                </div>
             </td>
            <td>
                <span><?php echo $row['product_price'];?>fdj</span>
            </td>
            <td >
                 <span ><?php echo $row['product_quantity'];?></span>
            </td>
            
            
     </tr> 
    <?php } ?>
  </table>
      <?php if($order_status == "not paid"){?>
          <form style="float: right;" method="POST" action="payment.php">
            <input type="hidden" name="order_status" value="<?php echo $order_status; ?>">
            <input type="hidden" name="total_order_price" value="<?php echo $total_order; ?>">
            <input type="submit" value="Pay Now" class="btn btn-primary" name="pay_now_btn">
          </form>
      <?php }?>
</section>




















<?php 
include('layouts/footer.php');
?>