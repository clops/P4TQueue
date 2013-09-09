<?php
    /**
     * @author  ak
     * @since   22.08.13 15:55
     */
    require_once('init.inc.php');

    /**
     * @var AbstractQueueType $queue
     */
    $queue  = P4TQueueDispatcher::getQueue('awesome');

    //lets push 1000 random messages to the queue
    echo "Storage Path: ".$queue->getStoragePath()."\n".
         "Queue Size: ".$queue->getTotalQueueSize()."\n".
         "Unprocessed: ".$queue->getTotalOpenQueueSize()."\n";
    echo "Adding messages to the queue endlessly, press CNTRL+C to terminate\n\n";
    $counter   = 1; //this is the counter of thousands
    $increment = 10000;

    while($counter){
        timer::start();
        $total = $increment;

        while($total){
            $m = rand(0,3);
            switch($m){
                //object
                case 1: {
                    $message = new stdClass();
                    $message->foo = 'bar';
                    break;
                }

                //array
                case 2: {
                    $message = array(1,2,3,'foo'=>'bar');
                    break;
                }

                //string
                default: {
                    $message = '<xml><foo></foo></xml>';
                    break;
                }
            }

            $metaData = array(
                'priority'  => rand(0,10),
                'foo'       => 'bar'
            );

            if($queue->push($message, array('priority' => 1, 'foo' => 'bar'))){
                $total--;
            }
        }
        $echo  = $counter*$increment;
        $echo .= " messages written to queue; insetion took ".timer::end()." seconds."; //"  // Total in queue: "; //.$queue->total();

        echo $echo;
        echo "\033[".strlen($echo)."D";

        $counter++;
    }

?>