<?php
/**
 * @author  ak
 * @since   22.08.13 17:27
 */

class P4TQueueRecord {

    //(string)$obj['_id'], $obj['message'], $obj['meta']
    protected $id;
    protected $message;
    protected $meta;

    public function __construct($queueID, $message, Array $metaData){
        $this->id      = $queueID;
        $this->message = $message;
        $this->meta    = $metaData;
    }

    public function process(){
        return true;
    }

    public function getId(){
        return $this->id;
    }
}