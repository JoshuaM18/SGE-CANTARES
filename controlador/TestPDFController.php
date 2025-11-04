<?php
require_once __DIR__ . '/../librerias/tcpdf/tcpdf.php';

class TestPDFController {
    public function generar() {
        // Limpia cualquier salida previa (clave)
        if (ob_get_length()) ob_end_clean();
        header_remove(); // Limpia headers anteriores también

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Sistema de Gestión Educativa');
        $pdf->SetTitle('PDF de Prueba');
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 14);

        $html = "<h1 style='text-align:center;'>PDF de Prueba ✅</h1>";
        $html .= "<p>Si ves este texto, TCPDF está funcionando correctamente.</p>";

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('prueba_tcpdf.pdf', 'I');
        exit; // Detiene cualquier salida adicional
    }
}
?>
