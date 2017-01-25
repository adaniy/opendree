<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
	use Notifiable;
	
	protected $table = 'action';
    protected $fillable = ['nom', 'realise', 'date_creation', 'date_butoire', 'date_realisation'];
}
