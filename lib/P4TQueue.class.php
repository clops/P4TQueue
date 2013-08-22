<?php
/**
 * This should be a factory returning singletons per queue type
 *
 * @author ak
 * @since 22.08.13 15:41
 **/
class P4TQueue {

    /**
     * @var
     */
    static $queueName;

    /**
     * Returns a singleton queue of the selected type
     *
     * @param $queueName
     * @thors \Exception
     */
    public static function getQueue($queueName){
        self::setQueueName($queueName);

        //create the reference point
        //@2do implement dynamic queue loader, currently only one supported
        //also currently the default storage engine MongoDB is loaded
        return new Basic(self::getStorageEngineForQueue());
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
        self::$queueName = (string)$queueName;
    }


    /**
     * @return string
     */
    private function getQueueName(){
        return self::$queueName;
    }


    /**
     * Should ideally get a storage engine defined for the current queue type,
     * currently defaults to mongodb
     */
    private function getStorageEngineForQueue(){
        $storage = new MongoDBStorage(self::getQueueName());
        return $storage;
    }
}