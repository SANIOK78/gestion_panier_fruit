<?php
    require_once('classes/panier.manager.php');
    require_once('classes/formatage.utile.php');

    class Panier{
        // Variable static de class (un tab)
        public static $paniers = [];

        private $identifiant;
        private $NomClient;
        private $pommes = [];
        private $peches = [];

        // Constructor pour générer nos paniers a l'instanciation
        public function __construct($identifiant, $NomClient) {
            $this -> identifiant = $identifiant;
            $this -> NomClient = $NomClient;
        }

        // Ajout de fruits, depuis BD, dans le panier
        public function setFruitToPanierFromDB() {
            // Recup ansemble de fruits pour un panier donnée
            // On met le result de la function dans une variable
            $fruits = PanierManager::getFruitPanier($this->identifiant);

            // On va remlir les $pomme[] et $peches[] avec les fruits 
            // recupéré depuis BD
            foreach($fruits as $obj ) {

                // si ça match avec ce qu'on recup depuis "panier.manager'"
                if(preg_match("/peche/i", $obj['nom'])) {
                    // on remplit le tab avec le nouveau fruit
                    $this -> peches[] = new Fruits($obj['nom'], $obj['poids'], $obj['prix']);

                } else if(preg_match("/pomme/i", $obj['nom'])) {
                    // on remplit le tab avec le nouveau fruit
                    $this -> pommes[] = new Fruits($obj['nom'], $obj['poids'], $obj['prix']);
                }               
            }           
        }
        
        // Function pour un affichage correct
        public function __toString() {

            $affichage = utile::gererTitreH3("Contenu panier de ".$this -> NomClient." :" );                
           
            $affichage .= '<table class="table">';

                $affichage .= '<thead>';
                    $affichage .= ' <tr>';
                        $affichage .= '<th scope="col">Image</th>';
                        $affichage .= '<th scope="col">Nom</th>';
                        $affichage .= '<th scope="col">Poids</th>';
                        $affichage .= '<th scope="col">Prix</th>';
                        $affichage .= '<th scope="col">Modifier</th>';
                        $affichage .= '<th scope="col">Supprimer</th>';                        
                    $affichage .= '</tr>';
                $affichage .='</thead>';

                $affichage .= '<tbody>';                   
                    foreach($this -> pommes as $pomme ) {

                        $affichage .= $this -> affichagePersonnaliseFruit($pomme);
                    }            
                    foreach($this -> peches as $peche ) {

                        $affichage .= $this -> affichagePersonnaliseFruit($peche);
                    }

                $affichage .= '</tbody>';
            $affichage .= '</table>';        
            
            return $affichage;
        }

        // function qui va faire l'affichage personnalisé
        private function affichagePersonnaliseFruit($obj) {
            $affichage = '<tr>';
                $affichage .='<td>'.$obj-> getImageSmall().'</td>';
                $affichage .='<td>'.$obj-> getNom().'</td>';
               
                $affichage .='<td>';
                    // Vérification du presence de "ID" et que ce "id" correspond au nom du fruit cliqué
                    if(isset($_GET['idFruit']) && $_GET['idFruit'] === $obj-> getNom()) {

                        $affichage .= "<form method='POST' action='#' >";
                            $affichage .='<input type="hidden" name="type" id="type" value="modification" />';

                            $affichage .='<input type="hidden" name="idFruit" id="idFruit" value="'.$obj-> getNom().'" />';
                            
                            $affichage .= "<input style='width:70px'
                                    type='number' name='poidsFruit' id='poidsFruit' value='".$obj-> getPoids()."' 
                                />";                                                                                     
                    } else {
                        $affichage .= $obj-> getPoids();
                    }         
                $affichage .='</td>';

                $affichage .='<td>';
                    // Vérification du presence de "ID" et que ce "id" correspond au nom du fruit cliqué
                    if(isset($_GET['idFruit']) && $_GET['idFruit'] === $obj-> getNom()) {                     
                            $affichage .= "<input style='width:70px'
                                        type='number' name='prixFruit' id='prixFruit' value='".$obj -> getPrix()."' 
                                    />";                                                                                                                                           
                    } else {
                        $affichage .= $obj -> getPrix();
                    }                    
                $affichage .='</td>';

                $affichage .='<td>';
                    if(isset($_GET['idFruit']) && $_GET['idFruit'] === $obj-> getNom()) { 
                        $affichage .='<input type="submit" class="btn btn-success" value="Valider" />';

                        $affichage .= "</form >";

                    } else {

                        $affichage .='<form action="#" method="GET" > ';
                            $affichage .='<input type="hidden" name="idFruit" id="idFruit" value="'.$obj-> getNom().'" />';
                            $affichage .='<input type="submit" class="btn btn-warning" value="Modifier" />';
                        $affichage .='</form>';
                    }
                $affichage .='</td>';

                $affichage .='<td>';
                    $affichage .='<form action="#" method="POST" > ';
                        $affichage .='<input type="hidden" name="type" id="type" value="suppression" />';

                        $affichage .='<input type="hidden" name="idFruit" id="idFruit" value="'.$obj-> getNom().'" />';
                        
                        $affichage .='<input type="submit" class="btn btn-danger" value="Supprimer" />';
                    $affichage .='</form>';
                $affichage .='</td>';
            $affichage .='</tr>';
            return $affichage;
        }
        
        // "Getter" pour recuperer l'identifiant
        public function getId () {
            return $this -> identifiant;
        }
        
        // Function permettant d'ajouter des fruits a un panier
        public function addFruit($obj){
            // si ça match avec ce qu'on recup depuis 
            if(preg_match("/peche/", $obj -> getNom())) {
                // on remplit le tab "peches" avec le nouveau fruit
                $this -> peches[] = $obj;

            } else if(preg_match("/pomme/", $obj -> getNom())) {
                // on remplit le tab avec le nouveau fruit
                $this -> pommes[] = $obj;
            } 
        }
        
        // Fnction permettant d'enregistrer un panier dans BD
        public function saveInDB() {
            return PanierManager::insertIntoDB($this->identifiant, $this->NomClient); 
        }

        // Function qui va generer un ID unique
        public static function generateUniqueID() {

            // recup de NbPanier returné depuis "panier.manager"
            // "+ 1" pour avoir un ID differant / unic
            return PanierManager::getNbPanierInDB() + 1;
        }
    }
?>

