<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReunionParticipant extends Model
{
	protected $table = "reunion_participant";
	protected $fillable = ['nom', 'status'];

    public function reunion()
    {
    	return $this->belongsTo("App\Reunion");
    }
}
