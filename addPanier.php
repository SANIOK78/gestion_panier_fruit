<?php 
    require_once('classes/fruits.class.php');
    require_once('classes/panier.class.php');
    include ('commons/header.php');
    include ('commons/navigation.php');
    require_once('classes/formatage.utile.php');
?>

<div class="container">

    <?php echo utile::gererTitreH1("Ajout d'un panier : "); ?>

    <?php 
        // Formulaire qui va permettre de composer un panier des fruits     
        echo "<form action='#' method='POST' >";

            echo "<div class='row'>";

                echo '<div class="col-sm">';
                    echo "<label for='client'>Nom du client :</label>";
                    echo "<input type='text' class='form-control' name='client' id='client' required />";
                echo '</div>'; 

                echo '<div class="col-sm">';
                    echo "<label for='nbPommes'>Nombres de pommes :</label>";
                    echo "<input type='number' class='form-control' name='nbPommes' id='nbPommes' required />";
                echo '</div>';

                echo '<div class="col-sm">';                    
                    echo "<label for='nbPeches'>Nombres de peches :</label>";
                    echo "<input type='number' class='form-control' name='nbPeches' id='nbPeches' required />";
                echo '</div>';  

                echo "<input type='submit' class='btn btn-success my-5' value='Créer votre panier' />";
            echo "</div>";
          
        echo"</form> ";
        
                
        // Verif si on a les valeurs du "client" et "nbPeches"
        if(isset($_POST['client']) && !empty($_POST['client'])) {  

            //1. on va générer un "panier" avec 'id' et "client" en paramétre
            $p = new Panier(Panier::generateUniqueID(), $_POST['client']);

            //2. Enregistrement du panier  la BD
            $res = $p -> saveInDB(); 
            
            if($res) {
                // recup de nb de fruit saisi dans le form
                $nbPomme = (int)$_POST['nbPommes'];
                $nbPeche = (int)$_POST['nbPeches'];

                // Rajout des fruits dans la BD
                $compteur = 1;  //pour gerer nbFruit
                // genération d'un ID unic
                $nbFruitInDB = Fruits::genererUnicID();

                for($i = 0; $i < $nbPomme; $i++){
                    $fruit = new Fruits("pomme_".($nbFruitInDB + $compteur), rand(120,150), 20); 
                    $fruit -> saveInDB($p -> getId()); 

                    $p -> addFruit($fruit);
                    $compteur++;
                }

                for($i = 0; $i < $nbPeche; $i++){
                    $fruit = new Fruits("peche_".($nbFruitInDB + $compteur), rand(70,90), 10);
                    $fruit -> saveInDB($p -> getId());

                    $p -> addFruit($fruit);
                    $compteur++;
                }

                echo $p;

            } else {
                echo "L'ajout a echoué";
            }
        }   
    ?>
</div>

<?php
    include ('commons/footer.php');
?>
