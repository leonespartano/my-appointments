<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancelledAppointment extends Model
{
    public function cancelled_by() //Busca automaticamente cancelled_by
    {
        //belongsTo N Cancellation - User 1: hasMany()
        return $this->belongsTo(User::class);
    }
}
