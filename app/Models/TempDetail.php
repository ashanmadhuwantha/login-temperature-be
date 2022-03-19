<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempDetail extends Model
{
    use HasFactory;
    protected $table = 'tblTempDetails';
    public $primaryKey = 'id';
    protected $fillable      = [
        'city_1_temp_fahrenheit',
        'city_2_temp_fahrenheit',
        'city_2_temp_celsius',
        'city_1_temp_celsius',
        'userId'

    ];
}
