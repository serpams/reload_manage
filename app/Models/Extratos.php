<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extratos extends Model
{
    use HasFactory;

    protected $table = 'extratos';

    protected $fillable = [
        'data',
        'banco',
        'file_url',
        'text',
        'user_id',
    ];
    #has many ExtratosTransactions
    public function transactions()
    {
        return $this->hasMany(ExtratosTransactions::class, 'extrato_id', 'id');
    }
    #belong to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
