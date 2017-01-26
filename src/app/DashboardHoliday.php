<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardHoliday extends Model
{
    protected $table = "dashboard_holiday";
    protected $fillable = [];

    protected function agent()
    {
        return $this->belongsTo("App\DashboardAgent");
    }
}
