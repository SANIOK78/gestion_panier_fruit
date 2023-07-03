<?php 
    require_once('classes/fruits.class.php');
    require_once('classes/panier.class.php');

    include ('commons/header.php');
    include ('commons/navigation.php');
?>

<div class="container">
    <h1>Fruits :</h1>
    
    <?php
        // Formulaire qui va permettre de composer un panier des fruits 
        echo "<div>";
        echo "<form action='#' method='POST' >";
            echo "<fieldset>";
                echo "<legend>Composez votre panier :</legend>";
                echo "<label for='nbPommes'>Nombres de pommes :</label>";
                echo "<input type='number' name='nbPommes' id='nbPommes' required /><br />";

                echo "<label for='nbPeches'>Nombres de peches :</label>";
                echo "<input type='number' name='nbPeches' id='nbPeches' required /><br />";

                echo "<button type='submit' class='btn'>Validez</button>";
            echo "</fieldset>";
        echo"</form> <br/>";
        echo "</div>";

        $pomme1 = new Fruits( Fruits::POMME, 150);
        $pomme2 = new Fruits( Fruits::POMME, 140);
        $peche1 = new Fruits( Fruits::PECHE, 120);
        $peche2 = new Fruits( Fruits::PECHE, 110);

        $panier1 = new Panier();
        // Rajout des fruit dans le "Panier"
        $panier1 -> addFruit($pomme1);
        $panier1 -> addFruit($pomme2);
        $panier1 -> addFruit($peche1);

        $panier2 = new Panier();
        $panier2 -> addFruit($peche2);
        $panier2 -> addFruit($peche1);
        $panier2 -> addFruit($pomme1);

        // on regroup les paniers dans un tab des paniers
        $paniers = [$panier1, $panier2]; 

        // Verif si on a les valeurs du "nbPommes" et "nbPeches"
        if(isset($_POST['nbPommes'])) {  //si c'est le cas
            // on va générer un "panier"
            $p = new Panier();
            // recup de NB pommes et peches (type=NB) depuis form
            $nbPommes = (int)$_POST['nbPommes'];
            $nbPeches = (int)$_POST['nbPeches'];

            // On va boucler sur le NB des pommes pour ajouter dans panier
            // "rand(120, 160)" poids aleatoir
            for($i = 0; $i < $nbPommes; $i++) {
                $p -> addFruit(new Fruits( Fruits::POMME, rand(120, 160)));
            }

            for($i = 0; $i < $nbPeches; $i++) {
                $p -> addFruit(new Fruits( Fruits::PECHE, rand(80, 100)));
            }

            // Une fois créé on le rajout a la liste des paniers
            $paniers[] = $p;
        }

        // création d'un form/options
        echo "<div>";
            echo "<form action='#' method='POST' />";
                echo "<label for='panier' >Panier </label>";

                echo "<select name='panier' id='panier' onChange='submit()'>";
                    echo "<option value='' ></option>";

                    foreach($paniers as $obj) {
                        echo "<option value='".$obj-> getIdentifiant()."' >
                                Panier ".$obj-> getIdentifiant()."
                            </option>";
                    }
                echo "</select>";
            
            echo "</form>";
        echo "</div>";

        // Affichage en fonction de option choisi
        if(isset($_POST['panier'])) {

            // Récup du panier dans la liste. On attent un type = NUMBER
            $panierAAfficher = getPanierById((int)$_POST['panier']);

            echo '<div>';
            
                echo "<h2> Affichage du panier ".$_POST['panier']."</h2>";
            
                echo $panierAAfficher;
            echo '</div>';
        }

        // Récup d'un panier en fonction d'un ID passé en param
        function getPanierById($id){
            // "global" pour indiquer que "$paniers" correspond a la 
            // "$panier" déclaré plus haut
            global $paniers;

            foreach($paniers as $obj) {
                // vérif que l'ID recupré correspond avec l'id passé 
                // en paramètre de la func (de la liste déroulante)
                if($obj -> getIdentifiant() === $id ) {

                    return $obj;
                }
            }
        }
    ?> 
</div>

<?php
    include ('commons/footer.php');
?>