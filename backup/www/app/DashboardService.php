<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardService extends Model
{
    protected $table = "dashboard_service";
    protected $fillable = [];

    protected function dashboard()
    {
        return $this->belongsTo("App\Dashboard");
    }

    protected function service()
    {
        return $this->belongsTo("App\Service");
    }
}
