<?php
/**
 * @author  ak
 * @since   22.08.13 15:53
 */

class MongoDBStorage{

    private $db;
    private $queueName;

    /**
     * @param $queueName
     */
    public function __construct($queueName){
        $this->queueName = $queueName;
        $this->db = new P4TMongo('mongodb://localhost');
        $this->db->setDBName('p4t_queues');
        $this->ensureIndexes();
    }

    /**
     * @param       $message
     * @param array $metaData
     *
     * @return bool
     */
    public function push($message, Array $metaData, $schedule = null){
        $record = array(
            'message' => $message,
            'meta'    => $metaData,
            'locked'  => 0,
            'done'    => 0,
            'execute' => new MongoDate(($schedule?strtotime($schedule):null))
        );
        $this->db->insert($this->getCollectionName(), $record);
        return true;
    }

    /**
     * @return int
     */
    public function total(){
        return $this->db->count($this->getCollectionName(), array('done'=>0));
    }

    /**
     * @return bool|P4TQueueRecord
     */
    public function getNextQueueItemToProcess(){
        $filter = array(
            'locked'        => 0,
            'done'          => 0,
            'execute'       => array('$lt' => new MongoDate())
        );

        $feed = $this->db->Execute(array(
            'findAndModify' => $this->getCollectionName(), //in what collection to search
            'query'         => $filter,
            'update'        => array('$set' => array('locked' => 1)) //what to update
        ));

        if(isset($feed[1]) and is_array($feed[1])){
            $obj = $feed[1];
            return new P4TQueueRecord((string)$obj['_id'], $obj['message'], $obj['meta']);
        }

        return false;
    }

    /**
     * @param P4TQueueRecord $record
     *
     * @return boolean
     */
    public function markRecordAsFinished(P4TQueueRecord $record){
        return $this->db->updateOneByID($this->getCollectionName(), $record->getId(), array('locked' => 0, 'done' => 1));
    }


    /**
     * @return string
     */
    private function getCollectionName(){
        return 'queue_'.$this->queueName;
    }


    /**
     *
     */
    private function ensureIndexes(){
        $collection = $this->getCollectionName();
        $this->db->ensureIndex($collection, array('done' => 1));
        $this->db->ensureIndex($collection, array('locked' => 1, 'done' => 1));
    }
}