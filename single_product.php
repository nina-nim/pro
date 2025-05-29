<?php
include('PHP/connection.php');
   if(isset($_GET['product_id'])){
 
     $product_id = $_GET['product_id'];
     $stmt = $conn->prepare("SELECT * FROM products where product_id=? ");
     $stmt->bind_param("i",$product_id);


        $stmt->execute();

        $product = $stmt->get_result();//[]

} else {
   header('location:index.php');
}





?>



<?php
include('layouts/header.php');
?>

<section class="container single-product my-5" style="padding: 80px;">
    <div class="row mt-5">
      <?php while($row = $product->fetch_assoc()){?>

        

       <div class="col-lg-5 col-md-6 col-sm-12">
        <img class="img-fluid py-5 pb-1" src="assets/iamges/<?php echo $row['product_image'];?>" id="mainproduct" width="80%"/><br>
        
        <div class="volume-options" style="display: flex; gap: 30px; margin-top: 10px;">
     
          <div class="volume-box" data-volume="3L" data-price="<?php echo $row['product_price']; ?>" data-details="<?php echo $row['product_description'];?>">
              <img src="assets/iamges/<?php echo $row['product_image'];?>" width="50%" class="small-img"><br>3L
          </div>
          <div class="volume-box" data-volume="5L" data-price="<?php echo $row['product_price'];?>" data-details="<?php echo $row['product_description'];?>">
              <img src="assets/iamges/<?php echo $row['product_image'];?>" width="50%" class="small-img"><br>5L
          </div>
          <div class="volume-box" data-volume="20L" data-price="<?php echo $row['product_price'];?>" data-details="<?php echo $row['product_description'];?>">
              <img src="assets/iamges/<?php echo $row['product_image'];?>" width="50%" class="small-img"><br>20L
          </div>
          <div class="volume-box" data-volume="25L" data-price="<?php echo $row['product_price'];?>" data-details="<?php echo $row['product_description'];?>">
              <img src="assets/iamges/<?php echo $row['product_image'];?>" width="50%" class="small-img"><br>25L
          </div>
          
      </div>
  
    </div> 
   

    <div class="col-lg-6 col-md-12 col-12">
        <h3 class="py-5"><?php echo $row['product_name'];?> </h3>
        <h2><?php echo $row['product_price'];?>Djf</h2>
        
        
        <form method="POST" action="cart.php">

          <input type="hidden" name="product_id" value="<?php echo $row['product_id'];?>">
          <input type="hidden" name="product_image" value="<?php echo $row['product_image'];?>">
          <input type="hidden" name="product_name" value="<?php echo $row['product_name'];?>">
          <input type="hidden" name="product_price" value="<?php echo $row['product_price'];?>">
         
            <input type="number" name="product_quantity"value="5" min="5" style="width: 50px; height: 40px;  padding-left: 10px;font-size: 16px; margin-right: 10px;"/>
            <button class="buy-btn" type="submit" name="add_to_cart">Add To Cart</button>
      </form>

        <H3 class="mt-5 mb-5">Products Details</H3>
        <span><h5><?php echo $row['product_description'];?></h5>
            </span>


    </div> 
      
    <?php }?>
    
  
  </div>


</section>





  <script>
      document.addEventListener("DOMContentLoaded", function () {
    var mainproduct = document.getElementById("mainproduct");
    var volumeText = document.querySelector("h3.py-5");
    var priceText = document.querySelector("h2");
    var detailsText = document.querySelector("span h5"); 
    var volumeBoxes = document.querySelectorAll(".volume-box");
    var productId = new URLSearchParams(window.location.search).get("product_id"); // Récupérer l'ID du produit depuis l'URL

    if (!mainproduct || !volumeText || !priceText || !detailsText) {
        console.error("Élément(s) manquant(s) !");
        return;
    }

    volumeBoxes.forEach(box => {
        box.addEventListener("click", function () {
            var selectedVolume = this.getAttribute("data-volume");

            if (productId && selectedVolume) {
                fetch(`get_product_details.php?product_id=${productId}&volume=${selectedVolume}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            console.error("Erreur : ", data.error);
                        } else {
                            mainproduct.src = `assets/iamges/${data.product_image}`;
                            volumeText.textContent = data.product_name + " " + selectedVolume;
                            priceText.textContent = data.product_price + " DJF";
                            detailsText.textContent = data.product_description;
                        }
                    })
                    .catch(error => console.error("Erreur de requête AJAX : ", error));
            }
        });
    });
});


</script>
    
   
<?php
include('layouts/footer.php');
?>