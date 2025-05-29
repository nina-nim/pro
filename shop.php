<?php
include('layouts/header.php');
?>

<section id="featured" class="my-5 py-5 mt-5">
    <div class="container text-center  py-5" style="margin-top: 80px;">
        <h3>Our Main Products</h3>
        <hr class="mx-auto">
        <p>Here you can check out our PRODUCTS</p>
    </div>
    
<div class="row mx-auto container">
 
<?php include ('PHP/get_product.php')?>
<?php while($row = $main_products->fetch_assoc()){

 ?>

    <div  class="product text-center col-lg-3 col-md-4 col-sm-12" >
<img class="img-fluid mb-3" src="assets/iamges/<?php echo $row['product_image'];?>"/>
<div class="star">
   <i class="fas fa-star"></i> 
   <i class="fas fa-star"></i> 
   <i class="fas fa-star"></i> 
   <i class="fas fa-star"></i> 
   <i class="fas fa-star"></i> 
</div>
<h5 class="p-name"><?php echo $row['product_name'];?></h5>
<h4 class="p-price"><?php echo $row['product_price'];?>Fdj</h4>
<a href="single_product.php?product_id=<?php echo $row['product_id'];?>"><button class="buy-btn">Buy Now</button></a>

    </div>
   

  <?php }  ?>
</div>
</section>









<?php
include('layouts/footer.php');
?>