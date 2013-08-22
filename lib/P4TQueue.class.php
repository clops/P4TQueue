<?php
/**
 * This is a queue factory, works as a singleton per queue type
 *
 * @author ak
 * @since 22.08.13 15:41
 **/
class P4TQueue {

    /**
     * Some return status constants
     */
    const STATUS_OK = 200;
    const STATUS_ERROR = 500;

    /**
     * @var
     */
    protected $queueHandler;
    protected $queueName;

    /**
     * Returns a singleton queue of the selected type
     *
     * @param $queueName
     * @thors \Exception
     */
    public function __construct($queueName){
        $this->setQueueName($queueName);

        //create the reference point
        //@2do implement dynamic queue loader, currently only one supported
        //also currently the default storage engine MongoDB is loaded
        $this->queueHandler  = new Basic($this->getStorageEngineForQueue());

        //send it back for those who like chaininig stuff
        return $this->queueHandler;
    }


    /**
     * @param mixed $message
     * @param array $metaData
     *
     * @return int
     */
    public function push($message, Array $metaData){
        if($this->queueHandler->push($message, $metaData)){
            return self::STATUS_OK;
        }
        return self::STATUS_ERROR;
    }


    /**
     * @param $queueName
     *
     * @throws Exception
     */
    private function setQueueName($queueName){
        //first some basic error handling
        if(empty($queueName)){
            throw new \Exception('You must provide a non-empty queue-name!');
        }
        $this->queueName = (string)$queueName;
    }


    /**
     * @return string
     */
    private function getQueueName(){
        return $this->queueName;
    }


    /**
     * Should ideally get a storage engine defined for the current queue type,
     * currently defaults to mongodb
     */
    private function getStorageEngineForQueue(){
        $storage = new MongoDBStorage($this->getQueueName());
        return $storage;
    }
}