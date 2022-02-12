<?php

namespace App\Services\Parser\WhatsApp;

use App\Models\ChatType;

class IOS extends FileParser {

    protected function parse(iterable $lines){

        foreach($lines as $line){
            
            /*
             * Date, time and sender is only logged when a value has changed. 
             * If the line starts with Android format date and time, we can set them now. 
             * Else it's just message content and will need to use the same values as the previous message.
            */ 
            if(preg_match(ChatType::where('chat_type', 'WhatsApp iOS')->first()->getRegex(), $line)){
                $removedDateAndTime = substr($line,23);
                $currentDate        = substr($line,1,10);
                $currentTime        = substr($line,13,8);
                $currentSender      = strstr($removedDateAndTime,":", true);
                $message            = substr(strstr($removedDateAndTime,":"),2);

            }
            else{
                $message = $line;
            }

            $data[] = [
                "date"    => $currentDate,
                "time"    => $currentTime,
                "sender"  => $currentSender,
                "message" => $message
            ];
        }

        return collect($data);

    }
    
}