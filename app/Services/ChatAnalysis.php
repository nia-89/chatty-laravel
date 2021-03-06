<?php
namespace App\Services;

use Illuminate\Support\Arr;

class ChatAnalysisService
{

    /**
     * Reurns the number of messages in the chat grouped by sender
     *
     * @param Collection $chatData
     * @return Array
     */
    public function getNumberOfMessagesBySender($chatData)
    {
        $groupBySender = $chatData->groupBy('sender');

        $countBySender = [];

        foreach($groupBySender as $sender=>$messages){
            $countBySender[] = [$sender => $messages->count('messages')];
        }      

        return Arr::collapse($countBySender);
    }

    public function getBusiestDays($chatData,$numberOfDays=10){

        $groupByDate = $chatData->groupBy('date');

        $countByDate = collect();

        foreach($groupByDate as $date=>$messages){
            $countByDate->put($date,$messages->count('messages'));
        }

        return $countByDate->orderByDesc('messages')->take($numberOfDays);
    
    }
}