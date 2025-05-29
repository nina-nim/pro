<?php

session_start();

if(isset($_POST['add_to_cart'])){
        //if user has alrrady added product to cart
    if(isset($_SESSION['cart'])){

        $products_array_ids = array_column($_SESSION['cart'],"product_id") ;
        //if product has already been added to cart or not
        if(!in_array($_POST['product_id'],$products_array_ids)){

            $product_id = $_POST['product_id'] ;    
            
            $product_array = array(
            'product_id'=>$_POST['product_id'],
            'product_name'=>$_POST['product_name'],
            'product_price'=>$_POST['product_price'],
            'product_image'=>$_POST['product_image'],
            'product_quantity'=>$_POST['product_quantity'],
           );

           $_SESSION['cart'][$product_id]= $product_array;



            //product has already been added
        }else{
            echo '<script>alert("Product was already added to cart");</script>';
         

        }


            //if this si the frist product 
        }else{
           $product_id = $_POST['product_id'];
           $product_name = $_POST['product_name'];
           $product_price = $_POST['product_price'];
           $product_image = $_POST['product_image'];
           $product_quantity = $_POST['product_quantity'];


           $product_array = array(
            'product_id'=>$product_id,
            'product_name'=>$product_name,
            'product_price'=>$product_price,
            'product_image'=>$product_image,
            'product_quantity'=>$product_quantity,
           );

           $_SESSION['cart'][$product_id]= $product_array;
           //[2=>[]]
        }




        //calculate total

        calculateTotalCart();




    }elseif(isset($_POST['remove_product'])){  
        $product_id = $_POST['product_id'];
        unset($_SESSION['cart'][$product_id]) ;
    
     //calculate total
    
        calculateTotalCart();
    
    
    }elseif(isset($_POST['edit_quantity'])){

        //we get the id and quantity from the form
        $product_id = $_POST['product_id'];
        $product_quantity = $_POST['product_quantity'];

        //get the product array from the session
       $product_array =  $_SESSION['cart'][$product_id];
        //update product quantity
        $product_array['product_quantity'] = $product_quantity;
        //return  array back to its place
        $_SESSION['cart'][$product_id] = $product_array;

        //calculate total

        calculateTotalCart();
    
    }else{

   // header('location:index.php');
}



function calculateTotalCart(){

    $total = 0;

    foreach($_SESSION['cart'] as $key => $value){
        $product = $_SESSION['cart'][$key];

        $price = $product['product_price'];

        $quantity = $product['product_quantity'];

        $total = $total + ($price * $quantity);
    }


    $_SESSION['total'] =  $total;
}




?>







 
<?php 
include('layouts/header.php');
?>

<!---Cart-->
<section class="cart container my-5  py-5">
    <div class="container mt-5" style="padding: 80px;">
        <h2 class="font-weight bolde">Your Cart</h2>
        <hr>
    </div>

<table class="mt-5 pt-5">
    <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th>Subtotal</th>
    </tr>
    <?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){ ?>
    <?php
    
     foreach($_SESSION['cart']as $key => $value){
    ?>
    <tr>
        <td>
            <div class="product-info">
                <img src="assets/iamges/<?php echo $value['product_image'];?>">
                 <div>
                     <p><?php echo $value['product_name'];?></p>
                        <small><?php echo $value['product_price'];?><span>Fdj</span></small> 
                        <br>
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $value['product_id'];?>">
                        <input type="submit" name="remove_product" class="remove-btn" value="Remove">
                         </form>
                </div>
            </div>
        </td>
<td>
    
       <form method="POST" action="cart.php"> 
        <input type="hidden" name="product_id" value="<?php echo $value['product_id'];?>" >
        <input type="number" name="product_quantity" value="<?php echo $value['product_quantity'];?>" min="5" style="width:100px;">
        <input type="submit" class="edit-btn" value="Edit" name="edit_quantity">
     </form>
</td>
<td><span class="product-price"><?php echo $value['product_quantity'] * $value['product_price'];?></span>
<span>Fdj</span>
</td>
    </tr>
   <?php  } ?>
   <?php  } ?>

           
</table>

    <div class="cart-total">
        <table >
            <!--<tr>
                <td>Subtotal</td>
                <td>5000 Fdj</td>
            </tr>-->
            <tr>
                <td>Total</td>
                <td> FDj <?php echo isset($_SESSION['total']) ? $_SESSION['total'] : 0; ?></td>

            </tr>
        </table>
    </div>

<div class="checkout-container">
    <form method="POST" action="checkout.php">
    <input type="submit" class="btn checkout-btn" value = "Checkout" name="checkout">

     </form>
</div>

</section>
















      
      
      
      
      
      
      
<?php 
include('layouts/footer.php');
?>