<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reunion extends Model
{
    use SoftDeletes;
    
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
