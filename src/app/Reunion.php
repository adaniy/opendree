<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reunion extends Model
{
    use SoftDeletes;

    protected $table = "reunion";
    protected $fillable = ['sujet', 'date', 'date_prochain'];

    public function participants()
    {
        return $this->hasMany("App\ReunionParticipant");
    }

    public function subjects()
    {
        return $this->hasMany("App\ReunionSujet");
    }


}
