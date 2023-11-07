<?php

namespace App\Imports;

use App\Models\ExtratoTransactions;
use Maatwebsite\Excel\Concerns\ToModel;

class ExtratosItauImport implements ToModel
{
    public $extrato_id;
    public $user_id;
    const BANCO_ORIGEM = 'bb';
    public function __construct($extrato_id = null)
    {
        $this->extrato_id = $extrato_id;
        $this->user_id = auth()->user()->id;
    }
    public function startRow(): int
    {
        return 3;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        //TODO::tratar nome do usuario que vem no itau antes de salvar

        return new ExtratoTransactions([
            'extrato_id' => $this->extrato_id,
            'data' => $row[0],
            'tipo' => $row[1],
            'id_transacao' => $row[3],
            'nome' => $row[4],
            'valor' => $row[5],
            'origem_banco' =>  self::BANCO_ORIGEM,
        ]);
    }
}
