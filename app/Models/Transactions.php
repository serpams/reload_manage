<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    protected $fillable = [
        'data',
        'type',
        'valor',
        'cotacao',
        'clients_id',
        'sellers_id',
        'users_id',
        'sites_id',
    ];

    public function clients()
    {
        return $this->belongsTo(Clients::class);
    }
    public function sellers()
    {
        return $this->belongsTo(Sellers::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function sites()
    {
        return $this->belongsTo(Sites::class);
    }

}
