<?php

namespace App\Http\Controllers;

use setasign\Fpdi\Fpdi;

class CertificateController extends Controller
{
    public function index()
    {
        return view('certificate');
    }

    public function generateCertificate($download = false)
    {
        $name = "Nama Peserta";
        $class = "Nama Kelas yang Di Selesaikan";
        $date = "Tanggal Bulan Tahun";

        $pdf = new Fpdi();

        $pathToTemplate = public_path('assets/certificate/certificate_template.pdf');
        $pdf->setSourceFile($pathToTemplate);
        $template = $pdf->importPage(1);

        $size = $pdf->getTemplateSize($template);

        $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
        $pdf->useTemplate($template, 0, 0, $size['width'], $size['height']);

        $pdf->SetTextColor(25, 35, 53);
        $pdf->SetFont('Helvetica', 'B', 24);
        $pdf->SetXY(13, 50);
        $pdf->Write(0, $name);

        $pdf->SetTextColor(34, 0, 89);
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->SetXY(13, 61);
        $pdf->Write(0, $class);

        $pdf->SetTextColor(25, 35, 53);
        $pdf->SetFont('Helvetica', '', 7);
        $pdf->SetXY(13, 70);
        $pdf->Write(0, $date);

        $fileName = 'Certificate ' . $name . '.pdf';

        if ($download) {
            return response()->make($pdf->Output('D', $fileName), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; fileName="' . $fileName . '"'
            ]);
        } else {
            return response()->make($pdf->Output('I', $fileName), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; fileName="' . $fileName . '"'
            ]);
        }
    }

    public function viewCertificate()
    {
        return $this->generateCertificate(false);
    }

    public function downloadCertificate()
    {
        return $this->generateCertificate(true);
    }
}