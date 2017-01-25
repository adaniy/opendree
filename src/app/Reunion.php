<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reunion extends Model
{
	protected $table = "reunion";
	protected $fillable = ['sujet', 'date', 'date_prochain'];

    public function participant() 
    {
    	return $this->hasMany("App\ReunionParticipant");
    }

    public function sujet() 
    {
    	return $this->hasMany("App\ReunionSujet");
    }
}
