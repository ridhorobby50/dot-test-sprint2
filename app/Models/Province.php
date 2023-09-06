<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $primaryKey = "province_id";
    protected $keyType = "int";
    protected $table = "provinces";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'province_id',
        'province_name'
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function cities(){
        return $this->hasMany(City::class, 'province_id','province_id');
    }
}
