<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use App\Parsers;
use Illuminate\Support\Facades\Storage;
use App\Models\Chat;

class UploadFileController extends Controller
{
    public function uploadForm() {
        return view('upload');
    }

    public function upload(UploadFileRequest $request){   

        $filename = now()->format('Y-m-d_His').'_'.$request->file('file')->getClientOriginalName();

        //Get contents of file to String
        $chatContent = $request->file('file')->get();

        Storage::disk('local')->put('uploads/'.$filename, encrypt($chatContent));

        //Determine the type of chat file that has been uploaded
        if(preg_match("^\[([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}^",$chatContent)){
            $chatType = 'iOS';
        }
        elseif(preg_match("^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4},^",$chatContent)){
            $chatType = 'Android';
        }
        else{
            $chatType = 'Unknown';
        }

        //Save to DB
        $chat = Chat::create([
            'filename' => $filename,
            'type'     => $chatType
        ]);

        //Run Parser for chat type
        switch ($chat->type) {
            case 'iOS':
                $data = (new Parsers\WhatsApp\IOS())->parseFile($chatContent);
                break;
            case 'Android':
                $data = (new Parsers\WhatsApp\Android())->parseFile($chatContent);
            }
        
        return redirect('/chats');

    }

}
