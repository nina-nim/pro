<?php 
session_start();

if(isset($_POST['order_pay_btn'])){
   $order_status = $_POST['order_status'];
   $total_order_price = $_POST['total_order_price'];
}

// Traitement du paiement
if(isset($_POST['process_payment'])){
    $payment_method = $_POST['payment_method'];
    $total_amount = $_POST['total_amount'];
    
    switch($payment_method){
        case 'dmoney':
            $phone = $_POST['dmoney_phone'];
            // Logique D-money
            echo "<script>alert('Paiement D-money initié. Composez *770# pour confirmer.');</script>";
            break;
        case 'waafi':
            $phone = $_POST['waafi_phone'];
            // Logique WAAFI
            echo "<script>alert('Notification WAAFI envoyée sur votre téléphone.');</script>";
            break;
        case 'cacpay':
            $account = $_POST['cacpay_account'];
            $pin = $_POST['cacpay_pin'];
            // Logique CACPay
            echo "<script>alert('Paiement CACPay traité avec succès.');</script>";
            break;
        case 'sabapay':
            $sabapay_id = $_POST['sabapay_id'];
            $password = $_POST['sabapay_password'];
            // Logique SabaPay
            echo "<script>alert('Paiement SabaPay effectué.');</script>";
            break;
        case 'card':
            $card_number = $_POST['card_number'];
            $card_name = $_POST['card_name'];
            // Logique carte bancaire
            echo "<script>alert('Paiement par carte traité.');</script>";
            break;
    }
}

include('layouts/header.php');
?>

<style>
.payment-option { border: 2px solid #e5e7eb; border-radius: 8px; padding: 15px; margin: 10px 0; cursor: pointer; }
.payment-option:hover { border-color: #3b82f6; }
.payment-option.selected { border-color: #3b82f6; background-color: #eff6ff; }
.payment-details { display: none; margin-top: 15px; padding: 15px; background-color: #f9fafb; border-radius: 6px; }
.btn-pay { background-color: #3b82f6; color: white; padding: 12px 30px; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; width: 100%; }
.btn-pay:hover { background-color: #2563eb; }
</style>

<section class="mt-5" style="padding: 50px;">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold"class="mt-5" style="padding: 50px;" >Paiement Sécurisé</h2>
        <hr class="mx-auto">
        <p>🇩🇯 Méthodes de paiement disponibles à Djibouti</p>
    </div>
    
    <div class="mx-auto container" style="max-width: 800px;">
        <?php if(isset($_SESSION['total']) && $_SESSION['total'] != 0){ 
            $total = $_SESSION['total'];
        } else if(isset($_POST['order_status']) && $_POST['order_status'] == "not paid"){
            $total = $_POST['total_order_price'];
        } else {
            echo "<p>Vous n'avez aucune commande</p>";
            exit;
        } ?>

        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
            <h4>Total à payer: <strong><?php echo $total; ?> Fdj</strong></h4>
        </div>

        <form method="POST" action="">
            <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
            
            <!-- D-money -->
            <div class="payment-option" onclick="selectPayment('dmoney')">
                <input type="radio" name="payment_method" value="dmoney" id="dmoney" style="margin-right: 10px;">
                <label for="dmoney"><strong>📱 D-money</strong> <span style="background: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 12px; font-size: 12px;">Populaire</span></label>
                <div class="payment-details" id="dmoney-details">
                    <input type="tel" name="dmoney_phone" placeholder="+253 77 XX XX XX" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;">
                    <p style="margin-top: 10px; color: #1e40af; font-size: 14px;">💡 Composez *770# pour confirmer le paiement</p>
                </div>
            </div>

            <!-- WAAFI -->
            <div class="payment-option" onclick="selectPayment('waafi')">
                <input type="radio" name="payment_method" value="waafi" id="waafi" style="margin-right: 10px;">
                <label for="waafi"><strong>📱 WAAFI</strong> <span style="background: #fed7aa; color: #c2410c; padding: 2px 8px; border-radius: 12px; font-size: 12px;">Rapide</span></label>
                <div class="payment-details" id="waafi-details">
                    <input type="tel" name="waafi_phone" placeholder="+253 77 XX XX XX" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;">
                    <p style="margin-top: 10px; color: #c2410c; font-size: 14px;">💡 Confirmez dans votre application WAAFI</p>
                </div>
            </div>

            <!-- CACPay -->
            <div class="payment-option" onclick="selectPayment('cacpay')">
                <input type="radio" name="payment_method" value="cacpay" id="cacpay" style="margin-right: 10px;">
                <label for="cacpay"><strong>🏦 CACPay</strong> <span style="background: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 12px; font-size: 12px;">Banque</span></label>
                <div class="payment-details" id="cacpay-details">
                    <input type="text" name="cacpay_account" placeholder="Numéro de compte" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px; margin-bottom: 10px;">
                    <input type="password" name="cacpay_pin" placeholder="Code PIN" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;">
                    <p style="margin-top: 10px; color: #166534; font-size: 14px;">🏦 Crédit Agricole du Centre</p>
                </div>
            </div>

            <!-- SabaPay -->
            <div class="payment-option" onclick="selectPayment('sabapay')">
                <input type="radio" name="payment_method" value="sabapay" id="sabapay" style="margin-right: 10px;">
                <label for="sabapay"><strong>💳 SabaPay</strong> <span style="background: #f3e8ff; color: #7c3aed; padding: 2px 8px; border-radius: 12px; font-size: 12px;">Digital</span></label>
                <div class="payment-details" id="sabapay-details">
                    <input type="text" name="sabapay_id" placeholder="Identifiant SabaPay" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px; margin-bottom: 10px;">
                    <input type="password" name="sabapay_password" placeholder="Mot de passe" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;">
                    <p style="margin-top: 10px; color: #7c3aed; font-size: 14px;">💳 Portefeuille électronique</p>
                </div>
            </div>

            <!-- Carte bancaire -->
            <div class="payment-option" onclick="selectPayment('card')">
                <input type="radio" name="payment_method" value="card" id="card" style="margin-right: 10px;">
                <label for="card"><strong>💳 Carte bancaire</strong> <span style="background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 12px; font-size: 12px;">International</span></label>
                <div class="payment-details" id="card-details">
                    <input type="text" name="card_name" placeholder="Nom sur la carte" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px; margin-bottom: 10px;">
                    <input type="text" name="card_number" placeholder="1234 5678 9012 3456" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px; margin-bottom: 10px;">
                    <div style="display: flex; gap: 10px;">
                        <input type="text" name="expiry" placeholder="MM/AA" style="flex: 1; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;">
                        <input type="text" name="cvv" placeholder="CVV" style="flex: 1; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;">
                    </div>
                    <p style="margin-top: 10px; color: #475569; font-size: 14px;">🔒 Paiement sécurisé SSL</p>
                </div>
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" name="process_payment" class="btn-pay">
                    Payer <?php echo $total; ?> Fdj
                </button>
            </div>
        </form>
    </div>
</section>

<script>
function selectPayment(method) {
    // Cacher tous les détails
    document.querySelectorAll('.payment-details').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('selected'));
    
    // Afficher les détails sélectionnés
    document.getElementById(method + '-details').style.display = 'block';
    document.getElementById(method).checked = true;
    document.getElementById(method).closest('.payment-option').classList.add('selected');
}
</script>

<?php include('layouts/footer.php'); ?>