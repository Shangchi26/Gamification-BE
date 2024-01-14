<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestProgess extends Model
{
    use HasFactory;
    protected $table = "quest_progess";
    protected $fillable = ["user_id", "quest_id", "point"];
    public function user(){
        return $this->belongsTo(User::class, "user_id");
    }
    public function quest(){
        return $this->belongsTo(Quest::class, "quest_id");
    }
}
