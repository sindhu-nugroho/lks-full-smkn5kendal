<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Codedge\Fpdf\Fpdf\Fpdf;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index'); // Tampilan untuk pilih tanggal
    }

    public function generatePDF(Request $request)
    {
        $request->validate([
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
        ]);

        $data = Transaction::with(['user'])
            ->whereBetween('tgl_pinjam', [$request->tgl_awal, $request->tgl_akhir])
            ->get();

        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        
        // Judul
        $pdf->Cell(190, 10, 'LAPORAN PEMINJAMAN BUKU', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(190, 7, 'Periode: '.$request->tgl_awal.' s/d '.$request->tgl_akhir, 0, 1, 'C');
        $pdf->Ln(10);

        // Header Tabel
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, 'No', 1);
        $pdf->Cell(40, 10, 'Tgl Pinjam', 1);
        $pdf->Cell(50, 10, 'Nama Anggota', 1);
        $pdf->Cell(40, 10, 'Status', 1);
        $pdf->Cell(50, 10, 'Denda', 1);
        $pdf->Ln();

        // Isi Tabel
        $pdf->SetFont('Arial', '', 10);
        $no = 1;
        foreach ($data as $row) {
            $pdf->Cell(10, 10, $no++, 1);
            $pdf->Cell(40, 10, $row->tgl_pinjam, 1);
            $pdf->Cell(50, 10, $row->user->name, 1);
            $pdf->Cell(40, 10, ucfirst($row->status), 1);
            $pdf->Cell(50, 10, 'Rp ' . number_format($row->denda), 1);
            $pdf->Ln();
        }

        $pdf->Output('I', 'Laporan-Peminjaman.pdf');
        exit;
    }
}
