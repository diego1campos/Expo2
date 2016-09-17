<?php
//Get
/*if ( isset( $_GET['id'] ) ) $id_producto = base64_decode( $_GET['id'] );
else{
    header( "location: starter.php" );
    exit();
}*/
//Get
#Creamos el objeto pdf (con medidas en milímetros): 

require('../fpdf/fpdf.php');
require('../lib/page.php');
require('../lib/validator.php');
require('../lib/database.php');
class PDF extends FPDF
{



    function Header()
   {
    $this->Image('../img/logo.png',10,8,33);
    $this->Cell(80);
    $this->SetFont('Arial','B',12);
    $this->Cell(30,10,'ISADELI',1,0,'C');
    $this->Ln(20);
   }

   function Footer()
   {
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Pagina ' .$this->PageNo().'/{nb}',0,0,'C');
   }

    // Colored table

    function FancyTable($header, $datos)
    {
        //if ( isset( $_GET['id'] ) ) $id_producto = base64_decode( $_GET['id'] );
        // Colors, line width and bold font
        //$this->Cell(65);
        $this->SetFillColor(188,0,0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('Arial', 'B', 11);
        // Header
        $w = array( 40, 35, 35, 20, 25);
        for( $i=0; $i < count($header); $i++ ) $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Color and font restoration

        $this->SetFillColor(240,245,255);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 10);
        // Data
        $fill = false;
        $i = 1;
        $b = 0;//Numero de arreglo de registro :D
        for( $b = 0; $b < count( $datos ); $b++ )
        {
            //$this->Cell(65);
            $this->Cell( $w[0], 6, $datos[$b]['nombre_producto'], 'LR', 0, 'L', $fill);
            $this->Cell( $w[1], 6, $datos[$b]['presentacion'], 'LR', 0, 'L', $fill);
            $this->Cell( $w[2], 6, '$'.$datos[$b]['precio_producto'], 'LR', 0, 'L', $fill);
            $this->Cell( $w[3], 6, $datos[$b]['cantidad_producto'], 'LR', 0, 'L', $fill);
            $this->Cell( $w[4], 6, '$'.( $datos[$b]['cantidad_producto'] * $datos[$b]['precio_producto'] ), 'LR', 0, 'L', $fill);
            $this->Ln();
            //$this->Cell(65);
            $fill = !$fill;   
        }
        $this->Cell(array_sum($w),0,'','T');
    }


    function FancyTable2($header, $datos)
    {
        //if ( isset( $_GET['id'] ) ) $id_producto = base64_decode( $_GET['id'] );
        // Colors, line width and bold font
        //$this->Cell(65);
        $this->SetFillColor(188,0,0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('Arial', 'B', 11);
        // Header
        $w = array( 20, 35, 25);
        for( $i=0; $i < count($header); $i++ ) $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Color and font restoration

        $this->SetFillColor(240,245,255);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 10);
        // Data
        $fill = false;
        $i = 1;
        $b = 0;//Numero de arreglo de registro :D
        /*for( $b = 0; $b < count( $datos ); $b++ )
        {*/
            //$this->Cell(65);
            $this->Cell( $w[0], 6, $datos['id_pedido'], 'LR', 0, 'L', $fill);
            $this->Cell( $w[1], 6, $datos['fecha_pedido'], 'LR', 0, 'L', $fill);
            $this->Cell( $w[2], 6, '$'.$datos['total'], 'LR', 0, 'L', $fill);
            $this->Ln();
            //$this->Cell(65);
            $fill = !$fill;   
        //}
        $this->Cell(array_sum($w),0,'','T');
    }
}

/*Primero validamos el parametro p :)*/
if ( isset( $_GET['p'] ) && Validator::numero( base64_decode( $_GET['p'] ) ) ) $_GET['p'] = base64_decode( $_GET['p'] );
else if ( isset( $_GET['p_l'] ) && Validator::numero( base64_decode( $_GET['p_l'] ) ) ) $_GET['p_l'] = base64_decode( $_GET['p_l'] );
else{
    header ( "location: compras_realizadas" );
    exit();
}
/*Primero validamos el parametro p :)*/
/*Validamos la sesion :D*/
Page::header( "Recibo" );
/*Validamos la sesion :D*/
$pdf = new PDF( 'p', 'mm', 'letter' );
$pdf->AddPage();
$pdf->SetFont('Arial', '', 20);
//$pdf->Image('../recursos/tienda.gif' , 10 ,8, 10 , 13,'GIF');
$pdf->Cell(18, 10, '', 0);
//$empresa = Database::getRow( 'select titulo_registro from empresa;', null );
//$pdf->Cell(115, 10, $empresa['titulo_registro'].'-Inventario actual', 0);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(115);
$pdf->Cell(20, -30, 'Fecha/hora:', 0);
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(130);
$pdf->Cell(20, -30, ' '.date( "Y-m-d / H:i:s" ), 0);
$pdf->Ln(28);
$pdf->SetFont('Arial', '', 8);

//Datos pedido
if ( isset( $_GET['p'] ) ) $datos_pedido = Database::getRow( "SELECT id_pedido, fecha_pedido, total FROM pedidos WHERe id_pedido = ?;" , array( $_GET['p'] ) );
else if ( isset( $_GET['p_l'] ) ) $datos_pedido = Database::getRow( "SELECT (id_pedido_local) id_pedido, fecha_pedido, total FROM pedidos_local WHERe id_pedido_local = ?;" , array( $_GET['p_l'] ) );
$cabecera = array( '# Pedido', 'Fecha', 'Total' );
$pdf->FancyTable2( $cabecera , $datos_pedido );
$pdf->Ln(10);
//Datos pedido

//Enlisar productos
if ( isset( $_GET['p'] ) ) $productos = Database::getRows( "SELECT nombre_producto, detalles_pedidos.precio_producto, imagen_producto, cantidad_producto, presentacion FROM ( ( ( (detalles_pedidos inner join img_productos on img_productos.id_img_producto = detalles_pedidos.id_img_producto) inner join pedidos on pedidos.id_pedido = detalles_pedidos.id_pedido) inner join productos on productos.id_producto = img_productos.id_producto ) inner join presentaciones on presentaciones.id_presentacion = img_productos.id_presentacion) inner join direcciones on direcciones.id_direccion = pedidos.id_direccion WHERe id_cliente=? and pedidos.id_pedido = ? order by nombre_producto ASC;" , array( $_SESSION['id_cliente'], $_GET['p'] ) );
else if ( isset( $_GET['p_l'] ) ) $productos = Database::getRows( "SELECT nombre_producto, detalles_pedidos_local.precio_producto, imagen_producto, cantidad_producto, presentacion FROM ( ( ( (detalles_pedidos_local inner join img_productos on img_productos.id_img_producto = detalles_pedidos_local.id_img_producto) inner join pedidos_local on pedidos_local.id_pedido_local = detalles_pedidos_local.id_pedido_local) inner join productos on productos.id_producto = img_productos.id_producto ) inner join presentaciones on presentaciones.id_presentacion = img_productos.id_presentacion) WHERe id_cliente=? and detalles_pedidos_local.id_pedido_local = ? order by nombre_producto ASC;" , array( $_SESSION['id_cliente'], $_GET['p_l'] ) );

/*Por ahorita puede ver solo la informacion del pedido, pero no el detalle, por lo tanto, **si el detalle es nulo lo saco :)*/
if ( $productos == null ){
    header( "location: compras_realizadas" );
    exit();
}
/*Por ahorita puede ver solo la informacion del pedido, pero no el detalle, por lo tanto, **si el detalle es nulo lo saco :)*/

$cabecera = array( 'Producto', 'Presentación', 'Precio', 'Cantidad', 'Subtotal' );
$pdf->FancyTable( $cabecera , $productos );
$pdf->Ln(10);
//Enlisar productos

$pdf->AliasNbPages();
$pdf->Output();

?>