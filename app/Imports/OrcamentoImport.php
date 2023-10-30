<?php

namespace App\Imports;

use App\Models\Orcamento;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class OrcamentoImport implements ToModel, WithStartRow
{
    public $obra_id;

    public function __construct($obra_id = null)
    {
        $this->obra_id = $obra_id;
    }
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }



    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        return new Orcamento([
            'obras_id'        => $this->obra_id,
            'medivel'        => $row[0],
            'item'           => $row[1],
            'servico'        => $row[2],
            'indice_base'    => $row[3],
            'indice_valor'   => $row[4],
            'unidade'       => $row[5],
            'quantidade'     => $row[6],
            'preco'          => $row[7],
            'total'          => $row[8],
            'total_indexado' => $row[9]
        ]);
    }
}
