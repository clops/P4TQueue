<?php
    /**
     * @author  ak
     */
    require_once('init.inc.php');

    /**
     * @var AbstractQueueType $queue
     */
    $queue    = P4TQueueDispatcher::getQueue('awesome');
    $sentinel = 1;

    echo "Watching queue with Storage Path: ".$queue->getStoragePath().", press CNTRL+C to terminate\n\n";

    while($sentinel){
        timer::start();
        echo "Queue Size: ".$queue->getTotalQueueSize()."\n".
             "Unprocessed: ".$queue->getTotalOpenQueueSize()."\n";
        echo timer::end()." seconds \n\n";
        sleep(1);
    }

