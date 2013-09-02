<?php
/**
 * This is a factory returning singletons per queue type
 *
 * @author ak
 * @since 22.08.13 15:41
 **/
class P4TQueueDispatcher {

    /**
     * @var
     */
    static $queueTypeReferences;

    
    /**
     * @param string $queueName
     * @return AbstractQueueType
     * @throws Exception
     */
    public static function getQueue($queueName='Basic'){

        //basic bogus checks
        if(!is_string($queueName)){
            throw new \Exception('The queue name MUST be a string!');
        }

        if(empty($queueName)){
            throw new \Exception('You must provide a non-empty queue-name!');
        }

        //automagic naming convention adaption
        $queueName = ucfirst($queueName);

        if(!self::getQueueTypeReference($queueName)){
            self::initQueueTypeReference($queueName);
        }

        return self::getQueueTypeReference($queueName);
    }


    /**
     * @param string $queueName
     */
    private static function initQueueTypeReference($queueName){
        //create a storage engine
        $storageEngine = self::getStorageEngineForQueue($queueName);

        //and a queue
        self::$queueTypeReferences[$queueName] = new $queueName($storageEngine);
    }


    /**
     * @param $queueName
     * @return AbstractQueueType
     */
    private static function getQueueTypeReference($queueName){
        if(isset(self::$queueTypeReferences[$queueName])){
            return self::$queueTypeReferences[$queueName];
        }
        return null;
    }


    /**
     * Currently just the MongoDB Storage engine, eventually
     * this will be setting based + a fallback
     */
    private function getStorageEngineForQueue($queueName){
        return new MongoDBStorage($queueName);
    }
}