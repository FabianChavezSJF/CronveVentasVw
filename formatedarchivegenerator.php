<?php

array_multisort(array_map('filemtime', ($file = glob("*EXPORT_CAMPOS.{CSV}", GLOB_BRACE))), SORT_ASC, $file);


$numItems = count($file);
$i = 0;
foreach ($file as $filename) {
    if (++$i === $numItems) {
        $archivo = ($filename);
    }
}


$filas = file($archivo);
$arr = []; // Inicializa el array
foreach ($filas as $value) {
    $arr[] = explode(";", $value); // Agrega cada línea al array
}

echo "<pre>";
echo "CABECERAS:";
print_r($arr[0]);
echo "</pre>";

$datos = [];
for ($i = 1; $i < count($arr); $i++) {
    $datos[] = $arr[$i];
}



echo "<pre>";
echo "DATOS:";
print_r($datos);
echo "</pre>";


// creo otro archivo csv con los datos y las cabeceras
$fp = fopen('datos.csv', 'w');
fputcsv($fp, $arr[0]);
foreach ($datos as $campos) {
    fputcsv($fp, $campos);
}
fclose($fp);

// al ejecutar descargo el archivo datos.csv
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename=datos.csv');
readfile('datos.csv');