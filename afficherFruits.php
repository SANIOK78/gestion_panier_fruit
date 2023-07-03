<?php 
    require_once('classes/fruits.class.php');
    require_once('classes/panier.class.php');
    require_once('classes/monPDO.class.php');
    require_once('classes/fruit.manager.php');
    require_once('classes/formatage.utile.php');
    include ('commons/header.php');
    include ('commons/navigation.php');
?>

<div class="container">

   <?php 
        // le Titre
        echo utile::gererTitreH3("Fruits :")
    ?>

    <?php 
        // Test si "idPanier" est renseigné
        if(isset($_POST['idPanier'])) {
            // recup de IdFruit et idPanier
            $idFruit = $_POST['idFruit'];
            $idPanier = (int)$_POST['idPanier'];

            // action de modification des données modifiés dans la BD
            $res = FruitManager::updatePanierForFruitDB($idFruit, $idPanier);

            if ($res) {
                echo '<div class="alert alert-success" role="alert" >
                        La modification en BD réussie !!!
                    </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert" >
                        La modification en BD a échouée !!!
                    </div>';
            }
        }           
        
        FruitManager::setFruitsFromDB();

        echo "<div class='row mx-auto' >";
            foreach( Fruits::$fruits as $fruit ) {
                echo '<div class="col col-md">';
                    echo $fruit->afficherListeFruits() ;
                echo '</div>';          
            }
        echo "</div>";
    ?>
</div>

<?php
    include ('commons/footer.php');
?>
