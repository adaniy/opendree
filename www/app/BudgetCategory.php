<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetCategory extends Model
{
    protected $table = "budget_category";
    protected $fillable = [];

    public function budget()
    {
        return $this->belongsTo("App\Budget");
    }

    public function depenses()
    {
        return $this->hasMany("App\BudgetDepense");
    }
}
