<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Action extends Model
{
    use SoftDeletes;

    protected $table = 'action';
    protected $fillable = ['nom', 'realise', 'date_creation', 'date_butoire', 'date_realisation'];
}
