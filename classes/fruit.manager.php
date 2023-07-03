<?php 
    require_once('classes/fruits.class.php');
    require_once('classes/monPDO.class.php');

    class FruitManager {

        // Function qui va remplir la variable "static" (Fruits::$fruits[] )
        // de la class "Fruits" 
        public static function setFruitsFromDB() {

            // Récup de la connexion BD grâce a la "class"
            $pdo = ConnectPDO::getPDO();

            // Recup des fruits + le panier dans laquel il se trouve
            $stmt = $pdo -> prepare("SELECT Nom, Poids, Prix FROM fruit "); 
                
            //Execution requête
            $stmt -> execute();
            //Recup resultat
            $fruits = $stmt -> fetchAll();
    
            // Utilisation de la class "fruits" pour generer un fruit
            foreach( $fruits as $obj ) {
                // on remplit le tableau "fruits" depuis la "class" Fruits
                Fruits::$fruits[] = new Fruits($obj['Nom'], $obj['Poids'], $obj['Prix']);
            }
        }

       // Function permettant de recupérer le NB de fruits dans la BD
        public static function getNbFruitsInDB(){
            // connexion a la BD
            $pdo = ConnectPDO::getPDO();
            // recup des NB des fruits dans la table 'fruit'            
            $stmt = $pdo -> prepare("SELECT count(*) as nbFruits FROM fruit"); 
            // execution de la requête   
            $stmt -> execute();
            // recup resultat (sur une ligne)
            $resultat = $stmt -> fetch();

            return $resultat["nbFruits"];
        }

        // Enregistrement des fruit dans la BD
        public static function insertIntoDB($nom, $poids, $prix, $idPanier){
            // connexion a la BD
            $pdo = ConnectPDO::getPDO();
            // insertion dans la BD "Panier" le "id" et "nomClient"
            $req = "insert into fruit value (:nom, :poids, :prix, :idPanier )";  
            // preparation de la requete          
            $stmt = $pdo -> prepare($req);

            $stmt -> bindValue(":nom", $nom, PDO::PARAM_STR);  
            $stmt -> bindValue(":poids", $poids, PDO::PARAM_INT);  
            $stmt -> bindValue(":prix", $prix, PDO::PARAM_INT);  
            $stmt -> bindValue(":idPanier", $idPanier, PDO::PARAM_INT);  

            // execution de la requête 
            try {
                return $stmt -> execute();

            } catch(PDOException $e) {
                echo "Erreur => ".$e->getMessage();
                return false;
            } 
        }
        
        // Function permettant la mise a jour (suite a modification) dans DB
        public static function updateFruitDB($idFruit, $prixFruit, $poidsFruit ) {
            // connexion a la BD
            $pdo = ConnectPDO::getPDO();
            // modification dans la DB( mise a jour de la table 'fruit' ; 
            // on modifie les champs "Poids" et "Prix" ; en fonction de la line
            // "nom = id" )
            $req = "UPDATE fruit SET Poids= :poids, Prix= :prix WHERE Nom= :id";  
            // preparation de la requete          
            $stmt = $pdo -> prepare($req);

            $stmt -> bindValue(":id", $idFruit, PDO::PARAM_STR);  
            $stmt -> bindValue(":prix", $prixFruit, PDO::PARAM_INT);    
            $stmt -> bindValue(":poids", $poidsFruit, PDO::PARAM_INT);  

            // execution de la requête 
            try {
                return $stmt -> execute();

            } catch(PDOException $e) {
                echo "Erreur => ".$e->getMessage();
                return false;
            } 
        }

        // Suppression d'un fruit de panier, en BD
        public static function deleteFruitFromPanier($idFruitUpdate){
            // connexion a la BD
            $pdo = ConnectPDO::getPDO();
            // L'id du fruit selectionné va prendre la valeur "null" 
            // donc supprime le fruit du panier en question
            $req = "UPDATE fruit SET identifiant = null WHERE Nom= :id";  
            // preparation de la requete          
            $stmt = $pdo -> prepare($req);

            $stmt -> bindValue(":id", $idFruitUpdate, PDO::PARAM_STR);  

            // execution de la requête 
            try {
                return $stmt -> execute();

            } catch(PDOException $e) {
                echo "Erreur => ".$e->getMessage();
                return false;
            } 
        }

        public static function getPanierFromFruit($nom) {
            // Récup de la connexion BD grâce a la "class"
            $pdo = ConnectPDO::getPDO();
            // Recup nomClient pour chaque fruit asocié a un panier 
            $stmt = $pdo -> prepare("SELECT p.identifiant as Client FROM fruit f                                  
                                INNER JOIN panier p 
                                ON f.identifiant = p.identifiant
                                WHERE f.nom = :nom
                            ");
            $stmt -> bindValue(":nom", $nom, PDO::PARAM_STR);  
            //Execution requête
            $stmt -> execute();
            //Recup resultat
            $client = $stmt -> fetch();

            return $client['Client'];
        }

        public static function updatePanierForFruitDB($idFruit, $idPanier){
            // connexion a la BD
            $pdo = ConnectPDO::getPDO();
            // L'id du fruit selectionné va prendre la valeur "null" 
            // donc supprime le fruit du panier en question
            $req = "UPDATE fruit SET identifiant = :idPanier WHERE Nom= :idFruit";  
            // preparation de la requete          
            $stmt = $pdo -> prepare($req);

            $stmt -> bindValue(":idFruit", $idFruit, PDO::PARAM_STR);  
            $stmt -> bindValue(":idPanier", $idPanier, PDO::PARAM_INT);  

            // execution de la requête 
            try {
                return $stmt -> execute();

            } catch(PDOException $e) {
                echo "Erreur => ".$e->getMessage();
                return false;
            } 
        }
    }
?>