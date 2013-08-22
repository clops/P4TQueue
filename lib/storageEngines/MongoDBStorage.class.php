<?php
/**
 * @author  ak
 * @since   22.08.13 15:53
 */

class MongoDBStorage{

    private $db;
    private $queueName;

    public function __construct($queueName){
        $this->queueName = $queueName;
        $this->db = new P4TMongo('mongodb://localhost');
        $this->db->setDBName('p4t_queues');
    }

    public function push($message, Array $metaData){
        $record = array(
            'message' => $message,
            'meta'    => $metaData
        );
        $this->db->insert($this->getCollectionName(), $record);
        return true;
    }

    protected function getCollectionName(){
        return 'queue_'.$this->queueName;
    }
}