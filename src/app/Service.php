<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = "service";
    protected $fillable = [];

    public function budgets()
    {
        return $this->hasMany('App\Budget');
    }
}
