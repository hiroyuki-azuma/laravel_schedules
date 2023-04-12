<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'yyyymmdd',
        'user_id',
    ];

        //リレーション追加
        public function user() {
            return $this->belongsTo(User::class);
        }
}
