<?php
    /**
     * @author  ak
     * @since   22.08.13 17:06
     */

    require_once('init.inc.php');
    $queue  = P4TQueue::getQueue('awesome');
    echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

    $counter = 1;
    while($record = $queue->consume()){
        if($record instanceof P4TQueueRecord){
            echo " [x] ".$counter." Received a record ";
            $queue->process($record); // has its own handlers, transaction wrap and lock status monitoring
            echo " and processed \n";
            $counter++;
        }else{
            echo " ... \n";
            sleep(1); // pause and then check again
        }
    }
