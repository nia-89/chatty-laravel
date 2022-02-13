<?php

namespace App\Services\Parser\WhatsApp;

use App\Models\ChatType;

class Android extends FileParser {

    protected function parse(iterable $lines){

        foreach($lines as $line){

            if(preg_match(ChatType::where('chat_type', 'WhatsApp Android')->first()->getRegex(), $line)){
                $removedDateAndTime = substr($line,22);
                $currentDate        = substr($line,0,10);
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