<?php 

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UploadFileRequest;
use App\Models\ChatType;
use App\Models\Chat;
use App\Services\Parser;

class ChatFile {

    public function save(UploadFileRequest $request) {

        //Set filename - add timestamp
        $filename = now()->format('Y-m-d_His').'_'.$request->file('file')->getClientOriginalName();

        //Get contents of file as String
        $chatContent = $request->file('file')->get();

        $newFile = null;

        /*
        * Loop through all available chat types in the database
        *
        * Each chat type has a corresponding regex stored in the database
        * 
        * If the file matches the chat types regex pattern, store the filename 
        * and chat type in the database, and encrypt and save the file to storage
        */
        foreach(ChatType::all() as $type){

            if(preg_match($type->regex, $chatContent)){
                $newFile = Chat::create([
                    'filename'      => $filename,
                    'chat_type_id'  => $type->id
                ]);

                Storage::disk('local')->put('uploads/'.$filename, encrypt($chatContent));

                break;
            }
        };

        //If no new file has been created, return with an error
        if(!$newFile){
            return redirect()->back()->withError('Unable to detect type of chat');
        };

        return $newFile;
    }

    //Retrieve file and decrypt
    public function getContent(Chat $chat) {

        return decrypt(Storage::disk('local')->get('uploads/'.$chat->filename));

    }

    //Parse file based on type
    public function parse(Chat $chat) {

        $chatContent = $this->getContent($chat);

        switch ($chat->chatType->chat_type) {
            case 'WhatsApp iOS':
                $data = (new Parser\WhatsApp\IOS())->parseFile($chatContent);
                break;
            case 'WhatsApp Android':
                $data = (new Parser\WhatsApp\Android())->parseFile($chatContent);
            };
        
        return $data;

    }
}