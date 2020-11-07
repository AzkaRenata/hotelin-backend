<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hotel extends Model
{
    use HasFactory;

    protected $table = 'hotel';
    public $timestamps = false;
    
    protected $fillable = [
        'hotel_name', 'hotel_location', 'hotel_desc', 'hotel_picture', 'user_id'
    ];
}
