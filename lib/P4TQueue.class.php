<?php
/**
 * This is a queue factory, works as a singleton per queue type
 *
 * @author ak
 * @since 22.08.13 15:41
 **/
use P4TQueue\storageEngines;
use P4TQueue\queueTypes;
class P4TQueue {

    /**
     * Some return status constants
     */
    const STATUS_OK = 200;

    /**
     * Returns a singleton queue of the selected type
     *
     * @param $queueName
     * @thors \Exception
     */
    public function __construct($queueName){

        //first some basic error handling
        if(empty($queueName)){
            throw new \Exception('You must provide a non-empty queue-name!');
        }

        //get the storage engine to work with
        $storageEngine = $this->getStorageEngineForQueue();

        //then create the reference point
        //@2do implement dynamic queue loader, currently only one supported
        $queueType = new queueTypes\Basic($storageEngine);

        //send it back
        return $queueType;
    }


    /**
     * @param mixed $message
     * @param array $metaData
     *
     * @return int
     */
    public function push($message, Array $metaData){
        return self::STATUS_OK;
    }


    /**
     * Should ideally get a storage engine defined for the current queue type,
     * currently defaults to mongodb
     */
    private function getStorageEngineForQueue(){
        $storage = new storageEngines\MongoDB();
        return $storage;
    }
}