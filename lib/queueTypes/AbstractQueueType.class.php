<?php
/**
 * Class QueueType
 *
 *  @author  ak
 */
abstract class AbstractQueueType {

    /**
     * @var AbstractQueueStorageEngine $storageEngine
     */
    protected $storageEngine;


    /**
     * @param AbstractQueueStorageEngine $engine
     */
    public function __construct(AbstractQueueStorageEngine $engine){
        $this->setStorageEngine($engine);
    }


    /**
     * @param AbstractQueueStorageEngine $engine
     */
    public function setStorageEngine(AbstractQueueStorageEngine $engine){
        $this->storageEngine = $engine;
    }


    /**
     * @return AbstractQueueStorageEngine
     */
    public function getStorageEngine(){
        return $this->storageEngine;
    }


    /**
     * @param mixed $message
     * @param array $metaData
     * @param datetime $schedule
     * @return boolean
     */
    public function push($message, Array $metaData, $schedule = null){
        return $this->storageEngine->pushMessageToQueue($message, $metaData, $schedule);
    }


    /**
     * return number of pending items in queue
     *
     * @return int
     */
    public function totalOpenMessagesInQueue(){
        return $this->storageEngine->totalOpenMessagesInQueue();
    }


    /**
     * The consumption of the queue will happen here
     */
    public function consumeItemFromQueue(){
        $record = $this->storageEngine->getNextQueueItemToProcess();
        if($record){
            return $record;
        }
        return -1; //will cause the worker to sleep
    }


    /**
     * @param P4TQueueRecord $record
     */
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