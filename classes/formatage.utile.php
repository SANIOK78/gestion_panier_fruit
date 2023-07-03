<!-- CLASS qui va contenir des functions static
  permettant de mettre en fome les pages du site.
  De cette façon on garde le même format partout
-->
<?php

    class utile{

        public static function gererTitreH1($titre){
            return "<h1 class='bg-light border border-primary p-3 my-3 text-center rounded '>".$titre."</h1>";
        }

        public static function gererTitreH2($titre){
            return "<h2 class='text-primary p-3 text-center '><u>".$titre."</u></h2>";
        }

        public static function gererTitreH3($titre){
            return "<h3 class='bg-info border border-primary p-3 my-3 text-center rounded '>".$titre."</h3>";
        }
    }

?>