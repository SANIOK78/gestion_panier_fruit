<?php 
    require_once('classes/panier.class.php');
    require_once('classes/monPDO.class.php');

    class PanierManager {

        // Function qui va remplir la variable "static" (Panier:: $paniers)
        // de la class "Panier" 
        public static function setPanierFromDB() {

            // Récup de la connexion BD grâce a la "class"
            $pdo = ConnectPDO::getPDO();

            // Recup toutes infos de panier 
            $stmt = $pdo -> prepare("SELECT identifiant, NomClient FROM panier"); 
                                        
            //Execution requête
            $stmt -> execute();
            //Recup resultat
            $paniers = $stmt -> fetchAll();
    
            // Utilisation de la class "fruits" pour generer un fruit
            foreach( $paniers as $obj ) {
                // on remplit le tableau "panier" depuis la "class" Panier
                Panier::$paniers[] = new Panier($obj['identifiant'], $obj['NomClient']);
            }
        }

        // Recup des infos des fruit pour un panier
        public static function getFruitPanier($identifiant) {
            $pdo = ConnectPDO::getPDO();
            $req = "SELECT nom, poids, prix FROM panier 
                    INNER JOIN fruit 
                    ON fruit.identifiant = panier.identifiant 
                    WHERE panier.identifiant = :id
                ";
                
            $stmt = $pdo -> prepare($req); 
                                   
            $stmt -> bindValue(":id", $identifiant, PDO::PARAM_INT);                
            $stmt -> execute();
           return $stmt -> fetchAll();
        }

        // Function permettant de recupérer le NB de Panier dans la BD
        public static function getNbPanierInDB(){
            // connexion a la BD
            $pdo = ConnectPDO::getPDO();
            // on va compter dans la BD Panier le nb de lignes             
            $stmt = $pdo -> prepare("SELECT count(*) as nbPanier FROM panier"); 
            // execution de la requête   
            $stmt -> execute();
            // recup resultat (sur une ligne)
            $resultat = $stmt -> fetch();

            return $resultat["nbPanier"];
        }

        // Fnction permettant d'enregistrer un panier dans BD
        public static function insertIntoDB($identifiant, $nom) {
            // connexion a la BD
            $pdo = ConnectPDO::getPDO();
            // insertion dans la BD "Panier" le "id" et "nomClient"
            $req = "insert into panier (identifiant, NomClient) value (:id, :nom)";  
            // preparation de la requete          
            $stmt = $pdo -> prepare($req);

            $stmt -> bindValue(":id", $identifiant, PDO::PARAM_INT);  
            $stmt -> bindValue(":nom", $nom, PDO::PARAM_STR);  

            // execution de la requête 
            try {
                return $stmt -> execute();

            } catch(PDOException $e) {
                echo "Erreur => ".$e->getMessage();
                return false;
            }
        }

        // Requête pour récupérer tous les panier
        public static function getPaniers() {
            // Récup de la connexion BD grâce a la "class"
            $pdo = ConnectPDO::getPDO();
            // Recup identifiant, NomClient de panier 
            $stmt = $pdo -> prepare("SELECT identifiant, NomClient FROM panier");                                         
            //Execution requête
            $stmt -> execute();
            //Recup resultat
            return $stmt -> fetchAll();
        }
    }

?>