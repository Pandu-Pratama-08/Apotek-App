<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'medicines', 'name_customer', 'total_prince'];

    // casts : memastikan tipe data migration
    protected $casts = [
        'medicines' => 'array'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
