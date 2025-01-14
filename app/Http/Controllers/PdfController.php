<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\User;
use App\Models\Demande;
use App\Models\Traitement;
use App\Models\Approbateur;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;



class PdfController extends Controller
{
    public function generatePDF()
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml('');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->stream('document.pdf');
    }
    public function index()
    {

        $pdf = Demande::with('demande_details')->get()->first();
        return view('generatePdf.index', compact('pdf'));
    }

    public function generate(Request $request, Demande $demande)
    {
        $traitements = Traitement::where('demande_id', $demande->id)->get();
        foreach ($traitements as $key => $traitement) {
            $approbateur = User::find($traitement->approbateur_id);
            $traitement['approbateur'] = $approbateur->name;
        }
        // dd($traitements, $demande->demande_details);
        // return view('generatepdf.index', compact('demande', 'traitements'));

        $html = view('generatepdf.index', compact('demande', 'traitements'))->render();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->stream("$demande->numero.pdf");
    }
}
