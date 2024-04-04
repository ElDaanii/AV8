<?php 
require_once "marcas.php";

function gustarMarca() {
    
    if(isset($_GET['selectedBrands'])) {
        $selectedBrands = $_GET['selectedBrands'];

        $conn = new Connection;
        $dataBase = $conn->getConn();   
    
        $data = "SELECT customerId, brandId FROM brandCustomer";
    
        $result = mysqli_query($dataBase, $data);
        if (mysqli_num_rows($result) > 0){
            while ($fila = mysqli_fetch_assoc($result)) {
                $brandIds[$fila['brandId']] = $fila['customerId'];
            }

            foreach($selectedBrands as $selectedBrandId) {
                if (isset($brandIds)) {
                    $cusId = $brandIds[$selectedBrandId];
                    $marcasFav[] = [$cusId, $selectedBrandId];
                }
            }
        } 
    }
    return $marcasFav;
}

$marcasFav = gustarMarca(); 
?>

<html>
    <body>
        <div>
            <?php
            echo "<pre>";
            print_r($marcasFav);
            echo "</pre>";
            ?>
        </div>
    </body>
</html>
