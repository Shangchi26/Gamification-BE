<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = "inventories";
    protected $fillable = ["user_id", "chest_id", "status"];
    public function user(){
        return $this->belongsTo(User::class, "user_id");
    }
    public function chest(){
        return $this->belongsTo(Chest::class, "chest_id");
    }
}
