<?php
/**
 * @author  ak
 * @since   22.08.13 15:45
 */

class Basic extends AbstractQueueType{

    /**
     * @param       $message
     * @param array $metaData
     *
     * @return bool
     */
    public function push($message, Array $metaData, $schedule = null){
        return $this->storageEngine->push($message, $metaData, $schedule);
    }


    /**
     * return number of pending items in queue
     *
     * @return int
     */
    public function total(){
        return $this->storageEngine->total();
    }


    /**
     * The consumption of the queue will happen here
     */
    public function consume(){
        $record = $this->storageEngine->getNextQueueItemToProcess();
        if($record){
            return $record;
        }
        return -1; //will cause the worker to sleep
    }


    public function process(P4TQueueRecord $record){
        $record->process(); //he?
        $this->markRecordAsFinished($record);
    }

    /**
     * @param P4TQueueRecord $record
     *
     * @return mixed
     */
    public function markRecordAsFinished(P4TQueueRecord $record){
        return $this->storageEngine->markRecordAsFinished($record);
    }

}