<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    protected $dates = ['birthday'];

    public function setBirthdayAttribute($birthday)
    {
    	// mutator to handle the birthday column
    	$this->attributes['birthday'] = Carbon::parse($birthday);
    }
}
