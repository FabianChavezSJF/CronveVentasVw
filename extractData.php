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

// importo la conceccion a la base de datos
require_once 'conexion.php';

$sqlCampos = "SELECT * FROM campo_ventas_SAP where isActivo = 1";
$result = $conn->query($sqlCampos);

$campos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $campos[] = $row;
    }
}


// echo "<pre>";
// echo "CAMPOS:";
// print_r($campos);
// echo "</pre>";

$centrosSAP = [];

$tiposDocValidator = ["S101"];
$canalDistribucionValidator = ["01"];

foreach ($campos as $campo) {
    $centrosSAP[] = $campo['centroSAP'];
}

$sqlTiposMaterial = "SELECT * FROM tipo_material_especie_SAP";
$resultTiposMaterial = $conn->query($sqlTiposMaterial);

$tiposMaterial = [];

if ($resultTiposMaterial->num_rows > 0) {
    while ($row = $resultTiposMaterial->fetch_assoc()) {
        $tiposMaterial[] = $row;
    }
}

$tiposMaterialValidator = [];

foreach ($tiposMaterial as $tipoMaterial) {
    $tiposMaterialValidator[] = $tipoMaterial['materialCodSAP'];
}

// echo "<pre>";
// echo "CENTROS SAP:";
// print_r($centrosSAP);
// echo "</pre>";


// Iterar sobre los datos y ejecutar la consulta para cada conjunto de valores
// foreach ($datos as $value) {
//     // Crear la consulta SQL de inserción
//     $sql = "INSERT INTO ventas_campo_SAP (
//          `key`,
//         sociedad,
//         tipoDocumento,
//         centro,
//         organizacionDeVenta,
//         solicitante,
//         rutSolicitante,
//         destinatarioDeMercancia,
//         rutDestinatarioDeMercancia,
//         documentoVenta,
//         posicionDocVenta,
//         fechaDocumentoPedido,
//         material,
//         descripcionMaterial,
//         especieMaterial,
//         entrega,
//         factura,
//         centroDeBeneficio,
//         pedidoCliente,
//         clienteFactura,
//         cantidadPedido,
//         cantidadEntrega,
//         cantidadFactura,
//         valorPedidoMD,
//         valorPedidoME,
//         valorNetoFacturaME,
//         valorNetoFacturaMD,
//         pesoBrutoPedido,
//         pesoNetoPedido,
//         pesoBrutoEntrega,
//         pesoNetoEntrega,
//         precioMD,
//         precioME,
//         tipoDeCambio
//     ) VALUES (
//         " . ($value[0] ? "'" . $value[0] . "'" : "NULL") . ",
//         " . ($value[1] ? "'" . $value[1] . "'" : "NULL") . ",
//         " . ($value[2] ? "'" . $value[2] . "'" : "NULL") . ",
//         " . ($value[3] ? "'" . $value[3] . "'" : "NULL") . ",
//         " . ($value[4] ? "'" . $value[4] . "'" : "NULL") . ",
//         " . ($value[6] ? "'" . $value[6] . "'" : "NULL") . ",
//         " . ($value[7] ? "'" . $value[7] . "'" : "NULL") . ",
//         " . ($value[8] ? "'" . $value[8] . "'" : "NULL") . ",
//         " . ($value[9] ? "'" . $value[9] . "'" : "NULL") . ",
//         " . ($value[10] ? "'" . $value[10] . "'" : "NULL") . ",
//         " . ($value[11] ? "'" . $value[11] . "'" : "NULL") . ",
//         " . ($value[12] ? "'" . $value[12] . "'" : "NULL") . ",
//         " . ($value[13] ? "'" . $value[13] . "'" : "NULL") . ",
//         " . ($value[14] ? "'" . $value[14] . "'" : "NULL") . ",
//         " . ($value[15] ? "'" . $value[15] . "'" : "NULL") . ",
//         " . ($value[16] ? "'" . $value[16] . "'" : "NULL") . ",
//         " . ($value[17] ? "'" . $value[17] . "'" : "NULL") . ",
//         " . ($value[18] ? "'" . $value[18] . "'" : "NULL") . ",
//         " . ($value[19] ? "'" . $value[19] . "'" : "NULL") . ",
//         " . ($value[20] ? "'" . $value[20] . "'" : "NULL") . ",
//         " . ($value[21] ? "'" . $value[21] . "'" : "NULL") . ",
//         " . ($value[22] ? "'" . $value[22] . "'" : "NULL") . ",
//         " . ($value[23] ? "'" . $value[23] . "'" : "NULL") . ",
//         " . ($value[24] ? "'" . $value[24] . "'" : "NULL") . ",
//         " . ($value[25] ? "'" . $value[25] . "'" : "NULL") . ",
//         " . ($value[26] ? "'" . $value[26] . "'" : "NULL") . ",
//         " . ($value[27] ? "'" . $value[27] . "'" : "NULL") . ",
//         " . ($value[28] ? "'" . $value[28] . "'" : "NULL") . ",
//         " . ($value[29] ? "'" . $value[29] . "'" : "NULL") . ",
//         " . ($value[30] ? "'" . $value[30] . "'" : "NULL") . ",
//         " . ($value[31] ? "'" . $value[31] . "'" : "NULL") . ",
//         " . ($value[32] ? "'" . $value[32] . "'" : "NULL") . ",
//         " . ($value[33] ? "'" . $value[33] . "'" : "NULL") . ",
//         " . ($value[34] ? "'" . $value[34] . "'" : "NULL") . "
//     )";

//     // Validar si el centro está en la lista de centros SAP
//     if (in_array($value[2], $tiposDocValidator)) {
//         if (in_array($value[3], $centrosSAP) && $value[3] != '' && $value[3] != null && in_array($value[13], $tiposMaterialValidator) && in_array($value[36], $canalDistribucionValidator)     {
//             // valido que key no sea null y que no exista en la base de datos
//             if ($value[0] != null && $value[0] != '') {
//                 $sqlKey = "SELECT * FROM ventas_campo_SAP where `key` = '" . $value[0] . "'";
//                 $resultKey = $conn->query($sqlKey);
//                 if ($resultKey->num_rows > 0) {
//                     // si ya existe el registro selecciono el id para actualizarlo
//                     $row = $resultKey->fetch_assoc();
//                     $id = $row['idVentaCampoSAP'];
//                     $sql = "UPDATE ventas_campo_SAP SET
//                     sociedad = " . ($value[1] ? "'" . $value[1] . "'" : "NULL") . ",
//                     tipoDocumento = " . ($value[2] ? "'" . $value[2] . "'" : "NULL") . ",
//                     centro = " . ($value[3] ? "'" . $value[3] . "'" : "NULL") . ",
//                     organizacionDeVenta = " . ($value[4] ? "'" . $value[4] . "'" : "NULL") . ",
//                     solicitante = " . ($value[6] ? "'" . $value[6] . "'" : "NULL") . ",
//                     rutSolicitante = " . ($value[7] ? "'" . $value[7] . "'" : "NULL") . ",
//                     destinatarioDeMercancia = " . ($value[8] ? "'" . $value[8] . "'" : "NULL") . ",
//                     rutDestinatarioDeMercancia = " . ($value[9] ? "'" . $value[9] . "'" : "NULL") . ",
//                     documentoVenta = " . ($value[10] ? "'" . $value[10] . "'" : "NULL") . ",
//                     posicionDocVenta = " . ($value[11] ? "'" . $value[11] . "'" : "NULL") . ",
//                     fechaDocumentoPedido = " . ($value[12] ? "'" . $value[12] . "'" : "NULL") . ",
//                     material = " . ($value[13] ? "'" . $value[13] . "'" : "NULL") . ",
//                     descripcionMaterial = " . ($value[14] ? "'" . $value[14] . "'" : "NULL") . ",
//                     especieMaterial = " . ($value[15] ? "'" . $value[15] . "'" : "NULL") . ",
//                     entrega = " . ($value[16] ? "'" . $value[16] . "'" : "NULL") . ",
//                     factura = " . ($value[17] ? "'" . $value[17] . "'" : "NULL") . ",
//                     centroDeBeneficio = " . ($value[18] ? "'" . $value[18] . "'" : "NULL") . ",
//                     pedidoCliente = " . ($value[19] ? "'" . $value[19] . "'" : "NULL") . ",
//                     clienteFactura = " . ($value[20] ? "'" . $value[20] . "'" : "NULL") . ",
//                     cantidadPedido = " . ($value[21] ? "'" . $value[21] . "'" : "NULL") . ",
//                     cantidadEntrega = " . ($value[22] ? "'" . $value[22] . "'" : "NULL") . ",
//                     cantidadFactura = " . ($value[23] ? "'" . $value[23] . "'" : "NULL") . ",
//                     valorPedidoMD = " . ($value[24] ? "'" . $value[24] . "'" : "NULL") . ",
//                     valorPedidoME = " . ($value[25] ? "'" . $value[25] . "'" : "NULL") . ",
//                     valorNetoFacturaME = " . ($value[26] ? "'" . $value[26] . "'" : "NULL") . ",
//                     valorNetoFacturaMD = " . ($value[27] ? "'" . $value[27] . "'" : "NULL") . ",
//                     pesoBrutoPedido = " . ($value[28] ? "'" . $value[28] . "'" : "NULL") . ",
//                     pesoNetoPedido = " . ($value[29] ? "'" . $value[29] . "'" : "NULL") . ",
//                     pesoBrutoEntrega = " . ($value[30] ? "'" . $value[30] . "'" : "NULL") . ",
//                     pesoNetoEntrega = " . ($value[31] ? "'" . $value[31] . "'" : "NULL") . ",
//                     precioMD = " . ($value[32] ? "'" . $value[32] . "'" : "NULL") . ",
//                     precioME = " . ($value[33] ? "'" . $value[33] . "'" : "NULL") . ",
//                     tipoDeCambio = " . ($value[34] ? "'" . $value[34] . "'" : "NULL") . "
//                     WHERE idVentaCampoSAP = " . $id;

//                     if ($conn->query($sql) === TRUE) {
//                         echo "<pre>";
//                         echo "Registro actualizado correctamente";
//                         echo "</pre>";
//                     } else {
//                         echo "<pre>";
//                         echo "Error: " . $sql . "<br>" . $conn->error;
//                         echo "</pre>";
//                     }

//                 } else {
//                     // Ejecutar la consulta
//                     if ($conn->query($sql) === TRUE) {
//                         echo "<pre>";
//                         echo "Registro insertado correctamente";
//                         echo "</pre>";
//                     } else {
//                         echo "<pre>";
//                         echo "Error: " . $sql . "<br>" . $conn->error;
//                         echo "</pre>";
//                     }
//                 }
//             } else {
//                 // Ejecutar la consulta
//                 if ($conn->query($sql) === TRUE) {
//                     echo "<pre>";
//                     echo "Registro insertado correctamente";
//                     echo "</pre>";
//                 } else {
//                     echo "<pre>";
//                     echo "Error: " . $sql . "<br>" . $conn->error;
//                     echo "</pre>";
//                 }
//             }
//         } else {
//             echo "<pre>";
//             if (!in_array($value[3], $centrosSAP)) {
//                 echo "El centro SAP no es válido(" . $value[3] . ")";
//             } else if (!in_array($value[13], $tiposMaterialValidator)) {
//                 echo "El tipo de material no es válido (" . $value[13] . ")";
//             }
//             echo "</pre>";
//         }
//     } else {
//         echo "<pre>";
//         echo "El tipo de documento no es válido";
//         echo "</pre>";
//     }
// }

// // Cerrar la conexión a la base de datos
// $conn->close();




