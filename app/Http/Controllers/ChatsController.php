<?php

namespace App\Http\Controllers;

use App\Models\Chat;

class ChatsController extends Controller
{
    public function index(){
        $chats = Chat::all();
        return view('chats.index', compact('chats'));
    }

}
