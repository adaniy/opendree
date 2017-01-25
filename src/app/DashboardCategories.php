<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardCategories extends Model
{
    protected $table = "dashboard_categories";
    protected $fillable = [];

    protected function amount()
    {
        return $this->hasMany("App\DashboardAmount");
    }
}
