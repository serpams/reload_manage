<?php

namespace App\Filament\Manager\Resources\ComprovantesResource\Pages;

use App\Filament\Manager\Resources\ComprovantesResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use thiagoalessio\TesseractOCR\TesseractOCR;

class CreateComprovantes extends CreateRecord
{
    protected static string $resource = ComprovantesResource::class;

    protected function afterCreate():void
    {

        $tesseract  = (new TesseractOCR( public_path('storage').'/'.$this->record->img_url))->lang('por')->txt()->run();
        $processado = self::processimg($tesseract);
        // get $data from form
        $data['text'] = $tesseract;
        $data['valor'] =  preg_replace('/\bR\$\s*/i', '', $processado['valor_real'][0][0]);
        $data['nome'] = $processado['nome'][0][0];
        $data['data'] = Carbon::createFromFormat('d/m/Y', substr($processado['data'][0][0] , 0 ,10))->format('Y-m-d') ;
        $data['id_transacao'] = $processado['transacao'][0][0];
        $data['banco'] = 'Bradesco';
        $data['description'] = $processado['tipo'][0][0];
        $data['user_id'] = auth()->user()->id;
        $this->record->update($data);



    }

    public static function processimg($text) {
            $patterns = [
                'nome' => '/(Nome|Nome:)\s+(.+?)\s*\n/',
                'valor_real'=> '/R\$[\s]*\d{1,3}(?:\.\d{3})*(?:,\d{2})\b/',
                'data' => '/\b\d{2}\/\d{2}\/\d{4}\b(?:\s*-\s*\d{2}:\d{2}:\d{2})?(?:\s+às\s+\d{2}:\d{2})?\b/'            ,
                'transacao' => '/\bE\w{31}\b/',
                'tipo'=> '/\b(?:pix|ted|doc)\b/i'
            ];

            $matches = [];
            foreach ($patterns as $key => $pattern) {
                preg_match_all($pattern, $text, $matches[$key]);
            }

            return $matches;
    }

}
