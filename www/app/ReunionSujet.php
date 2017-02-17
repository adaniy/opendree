<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReunionSujet extends Model
{
    use SoftDeletes;

    protected $table = "reunion_sujet";
    protected $fillable = ['sujet', 'observation', 'action'];

    public function reunion()
    {
        return $this->belongsTo("App\Reunion");
    }
}
