<?php

namespace App\DateMatching;

use App\Entity\Event;

class Datematch 
{
    function isPast(Event $event)
    {
        $d= $event->getDateStart();

        if($d < new \DateTime()) 
        {
            return true;
        }

        return false;
     }
     
}