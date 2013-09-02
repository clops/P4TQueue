<?php

/**
 * Class AbstractQueueStorageEngine
 * @author  ak
 */
abstract class AbstractQueueStorageEngine {

    /**
     * @var
     */
    private $queueName;

    /**
     * @param $queueName
     */
    public function __construct($queueName){
        $this->setQueueName($queueName);
    }

    /**
     * @param $queueName
     */
    public function setQueueName($queueName){
        $this->queueName = $queueName;
    }

    /**
     * @return mixed
     */
    public function getQueueName(){
        return $this->queueName;
    }

    /**
     * @param $message
     * @param array $metaData
     * @param null $schedule
     * @return mixed
     */
    abstract public function pushMessageToQueue($message, Array $metaData, $schedule = null);

    /**
     * @return int
     */
    abstract public function getTotalNumberOfOpenMessagesInQueue();

    /**
     * @return int
     */
    abstract public function getTotalNumberOfMessagesInQueue();

    /**
     * @return mixed
     */
    abstract public function getNextQueueItemToProcess();

    /**
     * @param P4TQueueRecord $record
     * @return mixed
     */
    abstract public function markRecordAsFinished(P4TQueueRecord $record);

    /**
     * @return string
     */
    abstract public function getStoragePath();
}