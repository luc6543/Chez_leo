<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public function table(){
        return $this->belongsTo(Table::class);
    }
    
}