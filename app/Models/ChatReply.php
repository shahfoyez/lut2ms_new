<?php

namespace App\Models;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatReply extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function chat(){
        return $this->belongsTo(Chat::class, 'chat_id');
    }
    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }
}
