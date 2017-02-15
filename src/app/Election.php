<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Election extends Model
{
    protected $table = "elections";
	protected $fillable = ['date', 'type', 'nb'];
}
