<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Commande</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php include 'components/user_header.php'; ?>
<div class="heading">
   <h3>Commandes</h3>
   <p><a href="home.php">home</a> <span> / orders</span></p>
</div>

<section class="orders">

   <h1 class="title">Vos commandes</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">Connectez-vous pour voir vos commande</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>Date : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>Nom : <span><?= $fetch_orders['name']; ?></span></p>
      <p>email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>numeros : <span><?= $fetch_orders['number']; ?></span></p>
      <p>address : <span><?= $fetch_orders['address']; ?></span></p>
      <p>Moyen de payement : <span><?= $fetch_orders['method']; ?></span></p>
      <p>Vos commandes : <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>Prix total : <span>$<?= $fetch_orders['total_price']; ?>/-</span></p>
      <p>Status du payement : <span style="color:<?php if($fetch_orders['payment_status'] == 'En entente'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">Aucune commande enregistré</p>';
      }
      }
   ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>