<?php 
    require_once('classes/fruits.class.php');
    require_once('classes/panier.class.php');
    require_once('classes/formatage.utile.php');

    include ('commons/header.php');
    include ('commons/navigation.php');
?>

<div class="container">

    <?php 
        // le Titre
        echo utile::gererTitreH1("Bienvenue sur le site dédié à la POO et PHP :");
    ?>

    <div class="row">
        <div class="col">

            <?php echo utile::gererTitreH2("Gestion des paniers") ?>
       
            <div class="mx-auto" style="width:200px">
                <a class="btn btn-outline-success" href="listePanier.php" role="button">
                    Afficher les Paniers
                </a>
            </div>
        </div>

        <div class="col">

            <?php echo utile::gererTitreH2("Gestion des fruits") ?>
          
            <div class="mx-auto" style="width:200px">
                <a class="btn btn-outline-success" href="afficherFruits.php" role="button">
                    Afficher les fruit
                </a>
            </div>
        </div>
        
  </div>
</div>

<?php
    include ('commons/footer.php');
?>