<?php 
    // CLASS pour la connexion a la BD // qu'une seule fois //
    class ConnectPDO {

        // Constante, en private, pour la connexion
        private const HOST_NAME = 'localhost';
        private const DB_NAME = "bd_panierfruit";
        private const USER_NAME = "root";
        private const PWD = "root";

        // Instance en static de PDO
        private static $monPDOinstance = null;

        // Function permettant de récupére l'instance PDO
        // ou de la créer si elle n'éxiste pas
        public static function getPDO() {

            // Pour s'assurer qu'on se connct qu'une seule fois a la BD, on passe par un test
            if(is_null(self::$monPDOinstance)) {

                try {
                    $connexion = 'mysql:host='.self::HOST_NAME.';dbname='.self::DB_NAME;
                    self::$monPDOinstance = new PDO(
                        $connexion,self::USER_NAME,self::PWD, 
                        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
                    );
                   
                } catch(PDOException $e) { 
            
                    die("Erreur de connexion à la BD => ".$e->getMessage());
                }
                
                // requête pour voir si le bon encodage
                self::$monPDOinstance -> exec("SET CHARACTER SET UTF8");
            }
            return self::$monPDOinstance;
        }
    }  

?>


 
