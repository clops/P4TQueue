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
        $echo = "Queue Size:  ".sprintf('%08d', $queue->getTotalQueueSize())." | ".
                "Unprocessed: ".sprintf('%08d', $queue->getTotalOpenQueueSize());
        echo $echo;
        sleep(1);

        //delete all the previous stuff
        echo "\033[".strlen($echo)."D";
    }

