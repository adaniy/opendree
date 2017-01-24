<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardAmount extends Model
{
    protected $table = "dashboard_amount";
    protected $fillable = [];

    protected function dashboard()
    {
        return $this->belongsTo("App\Dashboard");
    }

    protected function category()
    {
        return $this->belongsTo("App\DashboardCategories");
    }
}
