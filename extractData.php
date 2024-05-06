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

// echo "<pre>";
// echo "CABECERAS:";
// print_r($arr[0]);
// echo "</pre>";

$datos = [];
for ($i = 1; $i < count($arr); $i++) {
    $datos[] = $arr[$i];
}



// echo "<pre>";
// echo "DATOS:";
// print_r($datos);
// echo "</pre>";

// importo la conceccion a la base de datos
require_once 'conexion.php';

// Iterar sobre los datos y ejecutar la consulta para cada conjunto de valores
foreach ($datos as $value) {
    $sql = "INSERT INTO ventas_campo_SAP (
        CantidadUnidadManipulacion,
        UnidadCantidadUnidadManipulacion,
        CantidadEnUMB_Entrega,
        UnidadCantidadEnUMB_Entrega,
        CantidadEnUMB_Factura,
        UnidadCantidadEnUMB_Factura,
        CantidadEnUMB_Pedido,
        UnidadCantidadEnUMB_Pedido,
        PesoBrutoEnKilogramos_Factura,
        UnidadPesoBrutoEnKilogramos_Factura,
        PesoNetoEnKilogramos_Factura,
        UnidadPesoNetoEnKilogramos_Factura,
        PrecioDeFacturacionEnMD_Factura,
        MonedaPrecioDeFacturacionEnMD_Factura,
        PrecioDeFacturacionEnME_Factura,
        MonedaPrecioDeFacturacionEnME_Factura,
        PrecioFacturacion,
        MonedaPrecioFacturacion,
        TipoCambioPContab,
        TipoExactoPContab,
        ValorCostoDocContable,
        MonedaValorCostoDocContable,
        ValorCostoDocContableSOC,
        MonedaValorCostoDocContableSOC,
        ValorIngresoDocContable,
        MonedaValorIngresoDocContable,
        ValorIngresoDocContableSOC,
        MonedaValorIngresoDocContableSOC,
        ValorNetoPosicionFacturaEnMD,
        MonedaValorNetoPosicionFacturaEnMD,
        ValorNetoEnME_Factura,
        MonedaValorNetoEnME_Factura,
        DocumentoVenta,
        PosicionDocVenta,
        Sociedad,
        RUTSociedad,
        Solicitante,
        Centro,
        Especie,
        FechaDocPedido,
        Referencia,
        FacturaVenta,
        FolioSII,
        TipoDocComercial,
        Factura,
        OrganizacionVentas,
        Entrega,
        ClienteDestino,
        Moneda,
        UnidadDeManipulacion,
        MonedaDelDocumento,
        DestinatarioDeMercanciaPedido,
        Material,
        CentroDeBeneficio
    ) VALUES (  
        " . ($value[0] ? "'" . $value[0] . "'" : "NULL") . ", 
        " . ($value[1] ? "'" . $value[1] . "'" : "NULL") . ", 
        " . ($value[2] ? "'" . $value[2] . "'" : "NULL") . ", 
        " . ($value[3] ? "'" . $value[3] . "'" : "NULL") . ", 
        " . ($value[4] ? "'" . $value[4] . "'" : "NULL") . ", 
        " . ($value[5] ? "'" . $value[5] . "'" : "NULL") . ", 
        " . ($value[6] ? "'" . $value[6] . "'" : "NULL") . ", 
        " . ($value[7] ? "'" . $value[7] . "'" : "NULL") . ", 
        " . ($value[8] ? "'" . $value[8] . "'" : "NULL") . ", 
        " . ($value[9] ? "'" . $value[9] . "'" : "NULL") . ", 
        " . ($value[10] ? "'" . $value[10] . "'" : "NULL") . ", 
        " . ($value[11] ? "'" . $value[11] . "'" : "NULL") . ", 
        " . ($value[12] ? "'" . $value[12] . "'" : "NULL") . ", 
        " . ($value[13] ? "'" . $value[13] . "'" : "NULL") . ", 
        " . ($value[14] ? "'" . $value[14] . "'" : "NULL") . ", 
        " . ($value[15] ? "'" . $value[15] . "'" : "NULL") . ", 
        " . ($value[16] ? "'" . $value[16] . "'" : "NULL") . ", 
        " . ($value[17] ? "'" . $value[17] . "'" : "NULL") . ", 
        " . ($value[18] ? "'" . $value[18] . "'" : "NULL") . ", 
        " . ($value[19] ? "'" . $value[19] . "'" : "NULL") . ", 
        " . ($value[20] ? "'" . $value[20] . "'" : "NULL") . ", 
        " . ($value[21] ? "'" . $value[21] . "'" : "NULL") . ", 
        " . ($value[22] ? "'" . $value[22] . "'" : "NULL") . ", 
        " . ($value[23] ? "'" . $value[23] . "'" : "NULL") . ", 
        " . ($value[24] ? "'" . $value[24] . "'" : "NULL") . ", 
        " . ($value[25] ? "'" . $value[25] . "'" : "NULL") . ", 
        " . ($value[26] ? "'" . $value[26] . "'" : "NULL") . ", 
        " . ($value[27] ? "'" . $value[27] . "'" : "NULL") . ", 
        " . ($value[28] ? "'" . $value[28] . "'" : "NULL") . ", 
        " . ($value[29] ? "'" . $value[29] . "'" : "NULL") . ", 
        " . ($value[30] ? "'" . $value[30] . "'" : "NULL") . ", 
        " . ($value[31] ? "'" . $value[31] . "'" : "NULL") . ", 
        " . ($value[32] ? "'" . $value[32] . "'" : "NULL") . ", 
        " . ($value[33] ? "'" . $value[33] . "'" : "NULL") . ", 
        " . ($value[34] ? "'" . $value[34] . "'" : "NULL") . ", 
        " . ($value[35] ? "'" . $value[35] . "'" : "NULL") . ", 
        " . ($value[36] ? "'" . $value[36] . "'" : "NULL") . ", 
        " . ($value[37] ? "'" . $value[37] . "'" : "NULL") . ", 
        " . ($value[38] ? "'" . $value[38] . "'" : "NULL") . ", 
        " . ($value[39] ? "'" . $value[39] . "'" : "NULL") . ", 
        " . ($value[40] ? "'" . $value[40] . "'" : "NULL") . ", 
        " . ($value[41] ? "'" . $value[41] . "'" : "NULL") . ", 
        " . ($value[42] ? "'" . $value[42] . "'" : "NULL") . ", 
        " . ($value[43] ? "'" . $value[43] . "'" : "NULL") . ", 
        " . ($value[44] ? "'" . $value[44] . "'" : "NULL") . ", 
        " . ($value[45] ? "'" . $value[45] . "'" : "NULL") . ", 
        " . ($value[46] ? "'" . $value[46] . "'" : "NULL") . ", 
        " . ($value[47] ? "'" . $value[47] . "'" : "NULL") . ", 
        " . ($value[48] ? "'" . $value[48] . "'" : "NULL") . ", 
        " . ($value[49] ? "'" . $value[49] . "'" : "NULL") . ", 
        " . ($value[50] ? "'" . $value[50] . "'" : "NULL") . ", 
        " . ($value[51] ? "'" . $value[51] . "'" : "NULL") . ", 
        " . ($value[52] ? "'" . $value[52] . "'" : "NULL") . ", 
        " . ($value[53] ? "'" . $value[53] . "'" : "NULL") . " 
    )";

    mysqli_query($conn, $sql);
    // muestro un mensaje de exito o uno de error segun corresponda
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    // break;

}
$conn->close();




