<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReunionSujet extends Model
{
    protected $table = "reunion_sujet";
    protected $fillable = ['sujet', 'observation', 'action'];

    public function reunion()
    {
        return $this->belongsTo("App\Reunion");
    }
}
