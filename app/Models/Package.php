<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = ["point", "price"];
    public function order(){
        return $this->hasMany(Order::class, "package_id");
    }
}
