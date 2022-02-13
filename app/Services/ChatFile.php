<?php 

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UploadFileRequest;
use App\Models\ChatType;
use App\Models\Chat;
use App\Services\Parser;

class ChatFile {

    public function save(UploadFileRequest $request) {

        $filename = now()->format('Y-m-d_His').'_'.$request->file('file')->getClientOriginalName();

        $chatContent = $request->file('file')->get();

        $newFile = null;

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

        if(!$newFile){
            return redirect()->back()->withError('Unable to detect type of chat');
        };

        return $newFile;
    }

    public function getContent(Chat $chat) {

        return decrypt(Storage::disk('local')->get('uploads/'.$chat->filename));

    }

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