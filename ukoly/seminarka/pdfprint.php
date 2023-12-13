<?php 

if (!isset($_GET["id_fak"]) || !isset($_GET["id_zak"])) {
    header("Location: index.php?error=32");
    exit();
}

if (isset($_GET["id_fak"])) {
    $id_fak = $_GET["id_fak"];
}

if (isset($_GET["id_zak"])) {
    $id_zbozi = $_GET["id_zak"];
}

require_once("fpdf/fpdf.php");
require_once("inc/functions.php");
require_once("inc/dbh.inc.php");

$faktura = faktura($id_fak, $conn);
$zakaznik = zakaznik_podle_id($id_zbozi, $conn);
$conn = null;
// echo "<pre>" . print_r($zakaznik, true) . "</pre>";


$pdf = new FPDF();

$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Hlavicka
$pdf->Cell(130, 10, "Cislo dokladu " . $faktura[0]["id_fak"], 0, 1, "L");
$pdf->Cell(95, 10, "Odberatel: " . $zakaznik["jmeno"], 0, 0);
$pdf->Cell(95, 10, "Dodavatel: Zdenek Frydryn", 0, 1);
$pdf->Cell(95, 10, "Email: " . $zakaznik["email"], 0, 0);
$pdf->Cell(95, 10, "Email: zdenek.frydryn@gmail.com", 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln();

// Tabulka Header
$pdf->Cell(38, 7, "ID zbozi", 1, 0);
$pdf->Cell(38, 7, "Nazev zbozi", 1, 0);
$pdf->Cell(38, 7, "cena za ks", 1, 0);
$pdf->Cell(38, 7, "pocet ks", 1, 0);
$pdf->Cell(38, 7, "cena celkem", 1, 1);

// Tabulka Body
$pdf->SetFont('Arial', '', 10);
foreach ($faktura as $row) {
    // echo "<pre>" . print_r($row, true) . "</pre>";
    $pdf->Cell(38, 7, $row["zbozi_id"], 1, 0);
    $pdf->Cell(38, 7, $row["nazev"], 1, 0);
    $pdf->Cell(38, 7, $row["cena"], 1, 0);
    $pdf->Cell(38, 7, $row["pocet"], 1, 0);
    $pdf->Cell(38, 7, intval($row["cena"]) * intval($row["pocet"]), 1, 1);
}

$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln();
$pdf->Cell(130, 10, "");
$pdf->Cell(60, 10, "Celkem zaplatit: " . $faktura[0]["cena_fak"] . " Kc", 1, 1, 'C');;

$pdf->Output();
