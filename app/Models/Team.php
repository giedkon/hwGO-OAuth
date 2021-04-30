<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'tag', 'flag', 'logo'];

    public function players()
    {
        return $this->belongsToMany(Player::class);
    }

    public function instances()
    {
        return $this->belongsToMany(Instance::class);
    }
}
