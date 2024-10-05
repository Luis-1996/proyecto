<?php
$id = $_GET['id_usuario'];

include_once('./core/conexion_bd.php');
include_once("./services/services.php");
include_once("./services/PDF.php");

$user = Servicios::ObtenerDatos($id, $conexion);
$roles = Servicios::ObtenerUsuarios($id, $conexion);

$usuario = mysqli_fetch_array($user);
$rol = mysqli_fetch_array($roles);


function certificado($rol, $estado, $usuario)
{

    $pdf = new PDF('P', 'mm', 'letter');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    $margenIzquierdo = 20;
    $margenDerecho = 20;

    $txt = "El(la) " . strtoupper($rol) . " " . strtoupper(utf8_decode($usuario['nombres_apellidos'])) . ", identificado(a) con " . strtoupper($usuario['tipo_id']) . " No. " . $usuario['numero_id'] . ", se encuentra actualmente " . strtoupper(utf8_decode($usuario['estado'])) . "(A) en la carrera de " . strtoupper(utf8_decode($usuario['id_carrera'])) . " en la Universidad De Cartagena Centro Tutorial Cerete, en el municipio de cerete, cordoba.";    $pdf->SetLeftMargin($margenIzquierdo);
    $pdf->SetRightMargin($margenDerecho);
    $pdf->MultiCell(0, 5, $txt, 0, 'J');

    $pdf->Ln(20);
    $pdf->Cell(0, 10, 'Este certificado se expide a solicitud del interesado para los fines que estime convenientes.');
    $pdf->Ln(60);

    $pdf->Ln(20);
    $pdf->Cell(0, 10, 'Dado en la ciudad de cerete, el dia '. date('d/m/Y'), 0, 10, 'J');
    $pdf->Ln(20);
    

    $signatureX = ($pdf->GetPageWidth() - 40) / 2;
    $pdf->Image('static/img/firma.png', $signatureX, $pdf->GetY(), 40);
    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'William Malkun Castillejo', 0, 1, 'C');
    $pdf->Ln(-5);
    $pdf->Cell(0, 10, 'Rector UDC', 0, 1, 'C');

    $pdf->Output('I', 'certificado-' . $usuario['numero_id'] . '.pdf');
}

if ($rol['id_rol'] == '3') {

    certificado('EGRESADO', 'GRADUADO', $usuario);
} else {
    if ($usuario['estado'] == '0') {

        certificado('INSCRITO', 'no inscrito', $usuario);
    } else {

        certificado('ESTUDIANTE', 'matriculado', $usuario);
    }
}
