<?php 
    require_once('classes/fruits.class.php');
    require_once('classes/panier.class.php');
    require_once('classes/monPDO.class.php');
    require_once('classes/panier.manager.php');
    require_once('classes/fruit.manager.php');
    require_once('classes/formatage.utile.php');

    include ('commons/header.php');
    include ('commons/navigation.php');
?>

<div class="container">
    <?php echo utile::gererTitreH1("La liste des Paniers") ?>
   
    <?php 

        if(isset($_POST['idFruit']) && $_POST['type'] === 'modification' ) {
            // Recup des variables envoyés
            $idFruitUpdate = $_POST['idFruit']; 
            $prixFruitUpdate = (int) $_POST['prixFruit']; 
            $poidsFruitUpdate = (int) $_POST['poidsFruit']; 

            // action de modification des données modifiés dans la BD
            $res = FruitManager::updateFruitDB($idFruitUpdate, $prixFruitUpdate, $poidsFruitUpdate);

            if ($res) {
                echo '<div class="alert alert-success" role="alert" >
                        La modification en BD réussie !!!
                    </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert" >
                        La modification en BD a échouée !!!
                    </div>';
            }

        } else if(isset($_POST['idFruit']) && $_POST['type'] === 'suppression' ) {
            
            // Recup id Fruit
            $idFruitUpdate = $_POST['idFruit'];

            // action de suppression fruit d'un panier, en BD
            $res = FruitManager::deleteFruitFromPanier($idFruitUpdate);

            if ($res) {
                echo '<div class="alert alert-success" role="alert" >
                        Suppression réussie !!!
                    </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert" >
                        Suppression échouée !!!
                    </div>';
            }            
        }

        // Appel de la function "setPanierFromDB()"
        // depuis la class "PanierManager"
        PanierManager::setPanierFromDB();

       
        foreach( Panier::$paniers as $panier ) {
            // Pour chaqu'un des panier on va remplir
            // avec des fruits
            $panier -> setFruitToPanierFromDB();

            echo $panier."<br />" ;          
        }      
    ?>
</div>

<?php
    include ('commons/footer.php');
?>