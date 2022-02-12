<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatType extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function chat() {
        
        $this->hasMany(Chat::class);

    }

    public function getChatType() {

        return $this->getAttribute('chat_type');
    }

    public function getRegex() {

        return $this->getAttribute('regex');
    }
}
