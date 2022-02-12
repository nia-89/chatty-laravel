<?php

namespace App\Parsers\WhatsApp;

class Android extends FileParser {

    protected function parse(iterable $lines){

        foreach($lines as $line){
            //Date, time and sender is only logged when a value has changed. 
            //If the line starts with date and time, the details are included and we can set them. 
            //Else it's just message content and will need to use the same values as the previous message.
            if(preg_match("^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4},^", $line)){
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