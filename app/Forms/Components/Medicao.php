<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class Medicao extends Field
{
    // data
    protected $data = [
        'alocado' => 0,
        'data' => 0,
    ];
    // set data
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
    // get data
    public function getData()
    {
        return $this->data;
    }
    // set data
    public function setAlocado($alocado)
    {
        $this->data['alocado'] = $alocado;
        return $this;
    }
    // get data
    public function getAlocado()
    {
        return $this->data['alocado'];
    }

    // set data
    public function setDataMedicao($data)
    {
        $this->data['data'] = $data;
        return $this;
    }
    // get data
    public function getDataMedicao()
    {
        return $this->data['data'];
    }

    protected string $view = 'forms.components.medicao';
}