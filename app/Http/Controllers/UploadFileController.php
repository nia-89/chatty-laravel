<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Chat;

class UploadFileController extends Controller
{
    public function uploadForm() {
        return view('upload');
    }

    public function upload(Request $request){

        $request->validate(['file'=>'required|mimes:txt']);

        if($request->file()){
            $chatContent = $request->file('file')->get();

            $encryptedChat = encrypt($chatContent);

            $filename = now()->format('Y-m-d_His').'_'.$request->file('file')->getClientOriginalName();

            Storage::disk('local')->put('uploads/'.$filename, $encryptedChat);
        
            Chat::create([
                'filename' => $filename
            ]);
        }
        
        return redirect('/chats');

    }
}
