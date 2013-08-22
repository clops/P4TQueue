<?php
    /**
     * @author  ak
     * @since   22.08.13 15:55
     */
    require_once('init.inc.php');

    $queue  = new P4TQueue('awesome');

    //lets push 1000 random messages to the queue
    $total = 1000;
    echo "Adding messages to the queue endlessly, press CNTRL+C to terminate\n\n";
    echo '[x] Pushing 1000 messages to the queue. ';
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

    echo 'Done! took '.timer::end().' seconds';
    echo "\n\n";
?>