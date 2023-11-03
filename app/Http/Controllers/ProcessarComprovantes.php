<?php

namespace App\Http\Controllers;

use App\Models\Comprovantes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Intervention\Image\ImageManagerStatic;
use Spatie\PdfToImage\Pdf;

class ProcessarComprovantes extends Controller
{
    public static function processarDocumentos($file)
    {

        $imagePath = public_path('storage') . '/' . $file;

        // Carregue a imagem com o Intervention Image
        $image = ImageManagerStatic::make($imagePath);

        // Aplique filtros ou ajustes na imagem (exemplo: conversão para tons de cinza e nitidez)
        $image->greyscale(); // Converte para tons de cinza
        $image->sharpen(30); // Ajusta a nitidez (o valor pode variar)

        // Salve a imagem modificada (opcional - depende do seu fluxo de trabalho)
        $image->save(public_path('storage') . '/_' . $file);


        $tesseract  = (new TesseractOCR(public_path('storage') . '/_' . $file))->lang('por')->run();
        $processado = self::processimg($tesseract);
        // return $processado;
        // get $data from form
        $data['text'] = $tesseract;
        $data['img_url'] = $file;
        $data['valor'] =  isset($processado['valor_real'][0][0]) ? preg_replace('/\bR\$\s*/i', '', $processado['valor_real'][0][0]) : '';
        $data['nome'] = isset($processado['nome'][0][0]) ? $processado['nome'][0][0] : '';

        try {
            $date = $processado['data'][0][0];
            $date = str_replace('às', '', $date);
            $date = str_replace('-', '/', $date);
            $date = str_replace(' ', '', $date);
        } catch (\Throwable $th) {
            $date = null;
        }


        $data['data'] = $date != null ?  Carbon::createFromFormat('d/m/Y', substr($date, 0, 10))->format('Y-m-d') : '';
        $data['id_transacao'] = isset($processado['transacao'][0][0]) ? $processado['transacao'][0][0] : '';
        $data['banco'] = '';
        $data['description'] = isset($processado['tipo'][0][0]) ? $processado['tipo'][0][0] : '';
        $data['user_id'] = isset(auth()->user()->id) ? auth()->user()->id : '';

        // create comprovantes
        $comprovante =  Comprovantes::create($data);
        return $comprovante;
    }

    private static function getTelegramMessages()
    {
        $data = Http::get('https://api.telegram.org/bot6570180309:AAFY1TEectmFixiWLKsxj0SKk96CEdWY9Fk/getUpdates');
        return $data;
    }
    private static function getFileUrl($fileId)
    {
        if ($fileId == null) return false;
        $botToken = '6570180309:AAFY1TEectmFixiWLKsxj0SKk96CEdWY9Fk';
        $fileId = $fileId;

        $url = "https://api.telegram.org/bot{$botToken}/getFile?file_id={$fileId}";
        $data = Http::get($url);


        $filePath = $data['result']['file_path'];


        $filename  = $data['result']['file_id'] . "." . pathinfo($filePath, PATHINFO_EXTENSION);

        // check if $data['result']['file_path'] is extension is empty

        $filepath_url = "https://api.telegram.org/file/bot{$botToken}/{$filePath}";
        // $getfile =  Http::get($filepath_url);

        // $getfile =   file_get_contents(Http::get(`https://api.telegram.org/file/bot6570180309:AAFY1TEectmFixiWLKsxj0SKk96CEdWY9Fk/$filePath`));
        // $file = file_get_contents($getfile);

        // Obtendo o conteúdo da imagem da URL

        $imageContents = file_get_contents($filepath_url);
        if( pathinfo($filePath, PATHINFO_EXTENSION) == '' || pathinfo($filePath, PATHINFO_EXTENSION) == 'pdf' ){
            $filename = $filename . 'pdf';
        }else {
            $filename = $filename ;
        }
        // Salvando a imagem no disco local usando o Laravel Storage
        Storage::disk('public')->put($filename, $imageContents);

        if (pathinfo($filePath, PATHINFO_EXTENSION) == '') {
            $pdf = new Pdf(public_path('storage') . '/' . $filename);
            $pdfimg = public_path('storage') . '/pdf_' . $filename. 'jpeg';
            $pdf->setOutputFormat('jpeg')->saveImage('pdf_' . $filename. 'jpeg');
            return 'pdf_' . $filename. 'jpeg';
        }

        return $filename;
    }
    private static function processimg($text)
    {
        $patterns = [
            'nome' => '/(Nome|Nome:)\s+(.+?)\s*\n/',
            'valor_real' => '/R\$[\s]*\d{1,3}(?:\.\d{3})*(?:,\d{2})\b/',
            'data' => '/\b\d{2}\/\d{2}\/\d{4}\b(?:\s*-\s*\d{2}:\d{2}:\d{2})?(?:\s+às\s+\d{2}:\d{2})?\b/',
            'transacao' => '/Comprovante de transação\n\n([A-Z\d]+)\n\nTipo\nPix|\bE\w{31}\b/',
            'tipo' => '/\b(?:pix|ted|doc)\b/i'
        ];

        $matches = [];
        foreach ($patterns as $key => $pattern) {
            preg_match_all($pattern, $text, $matches[$key]);
        }

        return $matches;
    }
    public static function getReady()
    {
        $messages = self::getTelegramMessages();
        foreach ($messages['result'] as $message) {
            if (isset($message['message']['photo'])) {
                $fileId = isset($message['message']['photo'][3]['file_id']) ? $message['message']['photo'][3]['file_id'] : $message['message']['photo'][2]['file_id'];
                $fileUrl = self::getFileUrl($fileId);
                //  return $fileUrl;
                self::processarDocumentos($fileUrl);
            }
            if (isset($message['message']['document'])) {
                $fileId = isset($message['message']['document']['file_id']) ? $message['message']['document']['file_id'] : $message['message']['document']['file_id'];
                $fileUrl = self::getFileUrl($fileId);
                //  return $fileUrl;
                self::processarDocumentos($fileUrl);
            }
        }

        return 'all_processed';
    }
}
