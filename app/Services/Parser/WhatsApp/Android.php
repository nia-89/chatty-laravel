<?php

namespace App\Services\Parser\WhatsApp;

use App\Models\ChatType;

class Android extends FileParser {

    protected function parse(iterable $lines){

        foreach($lines as $line){

            /*
             * Date, time and sender is only logged when a value has changed. 
             * If the line starts with Android format date and time, we can set them now. 
             * Else it's just message content and will use the same values as the previous message.
            */ 
            if(preg_match(ChatType::where('chat_type', 'WhatsApp Android')->first()->getRegex(), $line)){
                $removedDateAndTime = substr($line,22);
                $currentDate        = substr($line,0,10);
                //Convert time format from 12HR to 24HR
                $currentTime        = date("H:i", strtotime(substr($line,11,8)));
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