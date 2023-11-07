<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtratoTransactionsConcilied extends Model
{
    use HasFactory;

    protected $table = 'extrato_transaction_concilied';

    protected $fillable = [
        'extrato_transaction_id',
        'comprovante_id',
        'comprovante_url',
        'comprovante_text',
        'data',
        'valor',
        'documento',
        'origem_banco',
    ];

    #belongs to ExtratosTransactions
    public function transaction()
    {
        return $this->belongsTo(ExtratoTransactions::class, 'extrato_transaction_id', 'id');
    }
}
