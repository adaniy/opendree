<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    protected $table = "dashboard";
    protected $fillable = [];

    public function categories()
    {
        return $this->hasMany("App\DashboardCategories");
    }

    public function service()
    {
        return $this->hasMany("App\DashboardService");
    }

    public function amount()
    {
        return $this->hasMany("App\DashboardAmount");
    }
}
