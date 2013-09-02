<?php
/**
 * Class QueueType
 *
 *  @author  ak
 */
abstract class AbstractQueueType {

    /**
     * @var QueueStorageEngine $storageEngine
     */
    protected $storageEngine;


    /**
     * @param QueueStorageEngine $engine
     */
    public function __construct(QueueStorageEngine $engine){
        $this->setStorageEngine($engine);
    }

    /**
     * @param QueueStorageEngine $engine
     */
    public function setStorageEngine(QueueStorageEngine $engine){
        $this->storageEngine = $engine;
    }

    /**
     * @return mixed
     */
    public function getStorageEngine(){
        return $this->storageEngine;
    }


}