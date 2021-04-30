<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    use HasFactory;

    protected $fillable = ['name','image'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }
}
