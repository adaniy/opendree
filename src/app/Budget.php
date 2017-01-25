<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $table = "budget";
    protected $fillable = [];

    public function depenses()
    {
        return $this->hasMany('App\BudgetDepense');
    }

    public function category()
    {
        return $this->hasMany('App\BudgetCategory');
    }
}
