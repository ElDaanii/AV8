<?php
require_once("class/importar.php");
require_once("marcas.php");

$importar = new Importar;
$marca = "BMW"; 
$brandId = $importar->getBrandId($marca);

$ges = new Gestion;
$marcas = $ges->getBrands();

?>

<html>
    <body>
        <div>
            <?php
            echo "El ID de la marca " . $marca . " es: " . $brandId;
            echo "<br>";
            echo "<br>";
            echo "$marcas";
            ?>
        </div>
    </body>
</html>

