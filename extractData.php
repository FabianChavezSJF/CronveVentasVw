<!-- obtengo los datos de un csv dentro del mismo directorio que este archivo -->
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
print_r($arr);
echo "</pre>";


// echo "<table border='1'>";

// // Imprime los títulos de las columnas
// echo "<tr>";
// foreach ($arr[0] as $titulo) {
//     echo "<th>" . htmlspecialchars($titulo) . "</th>";
// }
// echo "</tr>";

// // Imprime las filas
// for ($i = 1; $i < count($arr); $i++) {
//     echo "<tr>";
//     foreach ($arr[$i] as $valor) {
//         echo "<td>" . htmlspecialchars($valor) . "</td>";
//     }
//     echo "</tr>";
// }

// echo "</table>";
