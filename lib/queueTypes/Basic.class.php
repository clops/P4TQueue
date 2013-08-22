<?php
/**
 * @author  ak
 * @since   22.08.13 15:45
 */

class Basic {

    protected $storageEngine;

    public function __construct(MongoDBStorage $engine){
        $this->storageEngine = $engine;
    }

    public function push($message, Array $metaData){
        $this->storageEngine->push($message, $metaData);
    }

}