<?php
    /**
     * @author  ak
     * @since   22.08.13 17:06
     */

    require_once('init.inc.php');
    $queue  = P4TQueueDispatcher::getQueue('awesome');
    echo '[*] Waiting for messages. To exit press CTRL+C', "\n";

    $counter = 1;
    while($record = $queue->consumeItemFromQueue()){
        if($record instanceof P4TQueueRecord){
            $echo  = "[x] ".$counter." is ";
            $queue->process($record); // has its own handlers, transaction wrap and lock status monitoring
            $echo .= "done! Memory: ".round(memory_get_usage()/1024)."Kb";
            echo $echo;
            echo "\033[".strlen($echo)."D";
            $counter++;
        }else{
            echo ".";
            sleep(1); // pause and then check again
        }
    }
