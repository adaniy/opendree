<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetDepense extends Model
{
    protected $table = "budget_depense";
    protected $fillable = [];

    public function budget()
    {
        return $this->belongsTo("App\Budget");
    }

    public function budget_category()
    {
        return $this->belongsTo("App\BudgetCategory");
    }
}
