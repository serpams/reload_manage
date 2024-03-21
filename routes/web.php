<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProcessarComprovantes;
use App\Http\Controllers\ProfileController;
use App\Livewire\Counter;
use Gemini\Data\Blob;
use Gemini\Enums\MimeType;
use Gemini\Laravel\Facades\Gemini;
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

Route::get('/run', function () {
    //http://54.224.46.169/storage/_pdf_BQACAgEAAxkBAAMJZUVshROz7lvVobiNNo2Z78KN8S8AAt8CAAKQeChGkxj3c1n-aywzBA.jpeg
    $result = Gemini::geminiProVision()
        ->generateContent([
            'Retorne pra mim em formato json : {  nome , valor , instituicao , chave  e data e hora , origem , destino }',
            new Blob(
                mimeType: MimeType::IMAGE_JPEG,
                data: base64_encode(
                    file_get_contents('http://54.224.46.169/storage/_pdf_BQACAgEAAxkBAAMJZUVshROz7lvVobiNNo2Z78KN8S8AAt8CAAKQeChGkxj3c1n-aywzBA.jpeg')
                )
            )
        ]);

    $json = str_replace('```json ', '', $result->text());
    $json = str_replace(
        '```',
        '',
        $json
    );
    $data = json_decode($json, true);
    $data = json_encode($data, JSON_PRETTY_PRINT);
    // o retorno e esse ```json { "nome": "Mateus de Almeida Serpa", "valor": "R$ 3.500,00", "instituicao": "Bradesco S/A", "chave": "NU PAGAMENTOS - IP", "data e hora": "02/11/2023 15:26:53", "origem": "Conta-corrente", "destino": "Bradesco Celular" } ```
    // transforme em um json valido


    return $data;
});
