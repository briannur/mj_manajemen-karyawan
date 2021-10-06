<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admincall extends Model
{
    protected $fillable = ["office_name","capacity"];

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])
            ->translatedFormat('d-M-Y');
    }
    
    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])
            ->translatedFormat('d-M-Y');
    }
}
