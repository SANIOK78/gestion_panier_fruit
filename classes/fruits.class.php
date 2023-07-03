<?php
    require_once('classes/fruit.manager.php');
    
    class Fruits{
        private $nom;
        private $poids;
        private $prix;

        public static $fruits = [];

        public function __construct($nom, $poids, $prix){
            $this -> nom = $nom;
            $this -> poids = $poids;
            $this -> prix = $prix;
        }

        // "Getter"
        public function getNom(){
            return $this -> nom;
        }
        public function getPoids(){
            return $this -> poids;
        }
        public function getPrix(){
            return $this -> prix;
        }

      // Function "magique qui va faire l'affichage
        public function __toString() {

            $affichage = $this -> getAffichageIMG();                  
            $affichage .=  "<b>Nom </b>: ".$this-> nom."<br />";
            $affichage .= "<b>Poids </b>: ".$this-> poids."<br />";
            $affichage .= "<b>Prix </b>: ".$this-> prix."<br />";
            
            return $affichage;
        }

        // Affichage de la liste des fruits
        public function afficherListeFruits() {
            $affichage = '<div class="card m-2" style="width: 190px" >';
                $affichage .= $this -> getAffichageIMG();

                $affichage .= '<div class="card-body">';   
                    $affichage .=  "<h5 class='card-title'>Nom : ".$this-> nom."</h5>";
                    $affichage .= "<p class='card-text py-1 my-0'>Poids : ".$this-> poids."</p>";
                    $affichage .= "<p class='card-text py-1 my-0'>Prix : ".$this-> prix."</p>";

                    $affichage .= "<p class='card-text py-1 my-0'>Panier de ";

                        // Récupérer tous les panier pour les integrer a la liste
                        $paniers = PanierManager::getPaniers();

                        // Recup du panier dans lequel se trouve le fruit
                        $panierDuClient = FruitManager::getPanierFromFruit($this -> nom);

                        // affichage dans une liste deroulante 
                        $affichage .= "<form action='#' method='POST'>";
                            $affichage .= '<input type="hidden" name="idFruit" id="idFruit" value="'.$this->nom.'"  />';

                            $affichage .= '<select class="form-select" name="idPanier" id="idPanier" onChange="submit()" >';
                                $affichage .= "<option value=''></option>";
                                
                                foreach( $paniers as $obj ) {
                                    // test si la valeur correspond a "panierDuClient"
                                    if($panierDuClient === $obj['identifiant']) {
                                        $affichage .= '<option value="'.$obj['identifiant'].'" selected >'.$obj['NomClient'].'</option>';                                       
                                    } else {
                                        $affichage .= '<option value="'.$obj['identifiant'].'">'.$obj['NomClient'].'</option>';
                                    }
                                }
                                
                            $affichage .= '</select>';
                        $affichage .= "</form >";    
                        
                    $affichage .= "</p>";

                $affichage .= "</div>";

            $affichage .= "</div>";

            return $affichage;
        }

      // Affichage IMG
        private function getAffichageIMG() {          
            if(preg_match("/pomme/i", $this->nom)){
                return "<img class='card-img-top mx-auto' style='width:100px;' src='public/images/pomme.jpg' alt='pomme'/><br />";                
            }
            if(preg_match("/peche/i", $this->nom)){
                return "<img class='card-img-top mx-auto' style='width:100px;' src='public/images/peche.jpg' alt='peche'/><br />";              
            }           
        } 

        public function getImageSmall() {          
            if(preg_match("/pomme/i", $this->nom)){
                return "<img class='card-img-top mx-auto' style='width:40px;' src='public/images/pomme.jpg' alt='pomme'/><br />";                
            }
            if(preg_match("/peche/i", $this->nom)){
                return "<img class='card-img-top mx-auto' style='width:40px;' src='public/images/peche.jpg' alt='peche'/><br />";              
            }           
        } 

        // Function pour enregistrer le nouvea fruit dans BD
        public function saveInDB($idPanier) {
            // l'ajout depuis fruit.manager
            return FruitManager::insertIntoDB(
                $this->nom,
                $this->poids,
                $this->prix, $idPanier,                
            );
        }

        // Function qui va generer un ID unique
        public static function genererUnicID() {

            // recup de NbPanier returné depuis "panier.manager"
            // "+ 1" pour avoir un ID differant / unic
            return FruitManager::getNbFruitsInDB() + 1;
        }
    }
?>


