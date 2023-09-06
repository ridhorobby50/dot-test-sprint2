<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $primaryKey = "city_id";
    protected $keyType = "int";
    protected $table = "cities";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'city_id',
        'province_id',
        'type',
        'city_name',
        'postal_code',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function province(){
        return $this->belongsTo(Province::class, 'province_id');
    }
}
