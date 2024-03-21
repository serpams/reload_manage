<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProcessarComprovantes;
use App\Http\Controllers\ProfileController;
use App\Livewire\Counter;
use Illuminate\Support\Facades\Route;
use thiagoalessio\TesseractOCR\TesseractOCR;
use League\Csv\Writer;
use Spatie\PdfToImage\Pdf;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    return redirect('/transactions');
});


Route::get('/teste', function () {
    $rva = [];
    $tesseract  = (new TesseractOCR(public_path('comp/bradesco_t.jpeg')))->lang('por')->txt()->run();
    $tesseract2  = (new TesseractOCR(public_path('comp/nubank.jpeg')))->lang('por')->txt()->run();
    $tesseract3  = (new TesseractOCR(public_path('comp/neon.jpeg')))->lang('por')->txt()->run();

    // Função para identificar padrões nos textos
    $identificarPadroes = function ($text) {
        $patterns = [
            'nome' => '/(Nome|Nome:)\s+(.+?)\s*\n/',
            'valor_real' => '/R\$[\s]*\d{1,3}(?:\.\d{3})*(?:,\d{2})\b/',
            'data' => '/\b\d{2}\/\d{2}\/\d{4}\b(?:\s*-\s*\d{2}:\d{2}:\d{2})?(?:\s+às\s+\d{2}:\d{2})?\b/',
            'transacao' => '/\bE\w{31}\b/',
            'tipo' => '/\b(?:pix|ted|doc)\b/i'
        ];

        $matches = [];
        foreach ($patterns as $key => $pattern) {
            preg_match_all($pattern, $text, $matches[$key]);
        }

        return $matches;
    };

    $rva['bradesco'] = $identificarPadroes($tesseract);
    $rva['nubank'] = $identificarPadroes($tesseract2);
    $rva['neon'] = $identificarPadroes($tesseract3);

    return $rva;
});

Route::get('/processar',  [ProcessarComprovantes::class, 'getReady']);

Route::get('/teste2', function () {


    $pdf = new Pdf(public_path('comp/0c64ede6-3d0f-4f4e-b8c0-cb9e8fd547da.pdf'));
    $pdfimg = public_path('storage') . '/pdf_0c64ede6-3d0f-4f4e-b8c0-cb9e8fd547da.jpeg';
    $pdf->setOutputFormat('jpeg')->saveImage($pdfimg);
    // return 'pdf_' . $orignal . 'jpeg';
});

Route::get('/execute', function () {
    $pdfimg = public_path('storage') . '/pdf_0c64ede6-3d0f-4f4e-b8c0-cb9e8fd547da.jpeg';
    $tesseract  = (new TesseractOCR($pdfimg))->lang('por')->run();
    return $tesseract;
});
