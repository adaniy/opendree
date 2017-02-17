<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardAgent extends Model
{
    protected $table = "dashboard_agent";
    protected $fillable = [];

    protected function service()
    {
        return $this->belongsTo("App\Service");
    }
}
