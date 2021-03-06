<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Chat extends Model
{
    use HasFactory,Uuid;

    protected $guarded = [];

    public function chatType() {

        return $this->belongsTo(ChatType::class);
    }

}
