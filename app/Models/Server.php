<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Server extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'server_ip', 'server_port', 'password'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
