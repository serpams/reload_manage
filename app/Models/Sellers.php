<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sellers extends Model
{
    use HasFactory;
    public function Transactions()
    {
        return $this->hasMany(Transactions::class);
    }
}
