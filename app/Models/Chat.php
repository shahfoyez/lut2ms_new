<?php

namespace App\Models;

use App\Models\ChatReply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function chatReply(){
        return $this->hasOne(ChatReply::class, 'chat_id');
    }
    // public function admin(){
    //     return $this->hasOneThrough(User::class, ChatReply::class);
    // }
}
