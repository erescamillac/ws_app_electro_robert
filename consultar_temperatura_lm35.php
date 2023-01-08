<?php
// consultar_temperatura_lm35.php

include("database_connect.php"); 	//We include the database_connect.php which has the data for the connection to the database


// Check  the connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Get all the values form the table on the database [SENT_NUMBER_1], [timestamp_temperatura]
// SELECT SENT_NUMBER_1 as temperatura_corp, timestamp_temperatura FROM ESPtable2 WHERE id=99999 AND PASSWORD=12345
$result = mysqli_query($con,"SELECT SENT_NUMBER_2 as temp FROM ESPtable2 WHERE id=99999 AND PASSWORD=12345");	//table select is ESPtable2, must be the same on yor database

//Loop through the table and filter out data for this unit id equal to the one taht we've received. 

$contador = 0;

while($row = mysqli_fetch_array($result)) {
    $contador++;
    
    // $b1 = $row['temperatura_corp'];
    // $b2 = $row['timestamp_temperatura'];	
    $registro[] = array_map('utf8_encode', $row);

}// End of the while loop -- result [ResultSet]

header("Content-Type: application/json; charset=UTF-8");

if($contador >= 1){
    // almenos 1 REGISTRO Válido (OK: Dejar pasar)
    // echo json_encode($registro);
    $respuesta = ['code' => 100, 
                    'msg' => 'Temperatura ['.$registro[0]['temp'].'] recuperada EXITOSAMENTE de la BD.',
                    'temp' => $registro[0]['temp']
                ];

    $responseArray = [];
    $responseArray[0] = $respuesta;
    
    echo json_encode($responseArray);
}else{
    // [Block_Access]
    $respuesta = ['code' => -100, 
                    'msg' => 'ERROR al intentar recuperar la Temp. de la BD.',
                    'temp' => '0.0'
                ];
    // echo json_encode($registro);

    $responseArray = [];
    $responseArray[0] = $respuesta;

    echo json_encode($responseArray);
}


$result->close();

?>
