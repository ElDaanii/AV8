<?php 
require_once "autoloader.php";
class Gestion extends Connection{

    public function getBrands(){
        $conn = new Connection;
        $dataBase = $conn->getConn();   
    
        $data = "SELECT brandId, brandName FROM brands ORDER BY brandName ASC";
    
        $result = mysqli_query($dataBase, $data);
        if (mysqli_num_rows($result) > 0 ){
            $html = '<form action="favoritas.php" method="GET">';
            while ($fila = mysqli_fetch_assoc($result)) {
                $html .= '<input type="checkbox" value="' . $fila['brandId'] . '" name="selectedBrands[]"> ' . $fila['brandName'] . '<br>';
            }
            $html .= '<input type="submit" value="Seleccionar">';
            $html .= '</form>';
        }
    
        return $html;
    }
    
}









