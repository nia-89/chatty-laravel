<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use App\Services\ChatFile;

class UploadFileController extends Controller
{
    public function uploadForm() {
        return view('upload');
    }

    public function upload(UploadFileRequest $request){ 
        
        $chatFile = (new ChatFile())->save($request);

        $chatContent = (new ChatFile())->parse($chatFile);
        
        return redirect('/chat/' . $chatFile->id);

    }

}
