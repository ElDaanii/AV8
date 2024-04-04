<?php
require_once "connection.php";
class Importar extends Connection {

    public function customers() {
        $conn = new Connection;
        $dataBase = $conn->getConn();
        
        $sql = "UPDATE customers SET customerName = ? WHERE customerId = ?";
        $stmt = $dataBase->prepare($sql);
        
        $file = fopen("customers.csv", "r");
        if ($file !== FALSE) {
            while (($data = fgetcsv($file, 1000, "#")) !== FALSE) {
                // Verificar si el índice 1 existe antes de acceder a él
                if (isset($data[1])) {
                    $customerId = $data[0]; 
                    $customerName = $data[1];
                    $stmt->bind_param("ss", $customerName, $customerId);
                    $stmt->execute();
                } 
            }
            fclose($file);
        } else {
            echo "Error: No se pudo abrir el archivo CSV.";
        }
        $stmt->close();
    }
    
    
    
    public function getBrandId($marca) {
        $conn = new Connection;
        $dataBase = $conn->getConn();
    
        $data = "SELECT brandId FROM brands WHERE brandName = ?";
    
        $stmt = $dataBase->prepare($data);
    
        if ($stmt) {
            $stmt->bind_param("s", $marca);
            $stmt->execute();
            $stmt->bind_result($brandId);
            
            $stmt->fetch();
    
            $stmt->close();
    
            return $brandId;
        } else {
            echo "Error: No se pudo preparar la consulta.";
            return null;
        }
    }


    public function brandCustomer() {
        $conn = new Connection;
        $dataBase = $conn->getConn();   
    
        $dataBrandsId = "SELECT brandId, brandName FROM brands";
        $resultBrands = mysqli_query($dataBase, $dataBrandsId);
    
        $brandIds = array();
        while ($fila = mysqli_fetch_assoc($resultBrands)) {
            $brandIds[$fila['brandName']] = $fila['brandId'];
        }
    
        $associations = array();
        $file = fopen("customers.csv", "r");
        if ($file !== FALSE) {
            while (($data = fgetcsv($file, 1000, "#")) !== FALSE) {
                if (isset($data[2]) && isset($data[0])) {
                    $cliente = $data[0];
                    $marcas = explode(", ", $data[2]); // Separa las marcas, sirve para cuando hay mas de una 
                    foreach ($marcas as $marca) {
                        if (isset($brandIds[$marca])) {
                            $associations[] = array($cliente, $brandIds[$marca]);
                        }
                    }
                }
            }
            fclose($file);
        } 

        foreach ($associations as $association) {
            $customerId = $association[0];
            $brandId = $association[1];
            
            $query = "INSERT INTO brandCustomer (customerId, brandId) VALUES ('$customerId', '$brandId')";
            mysqli_query($dataBase, $query);
        }
    }
    
    
}