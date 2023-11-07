<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtratoTransactions extends Model
{
    use HasFactory;

    #belongs to Extratos
    public function extrato()
    {
        return $this->belongsTo(Extratos::class, 'extrato_id', 'id');
    }

    #has many ExtratosTransactionsConcilied
    public function concilied()
    {
        return $this->hasMany(ExtratoTransactionsConcilied::class, 'extrato_transaction_id', 'id');
    }
}
