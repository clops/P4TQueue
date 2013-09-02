<?php
/**
 * MongoDBStorage
 * @author  ak
 *
 * This whole package is experimental, beware
 */
class MongoDBStorage extends AbstractQueueStorageEngine{

    /**
     * @var P4TMongo $db
     */
    private $db;

    /******* CONSTRUCTORS AND STUFF  ***************************************************
     *
     *
     */

    /**
     * @param string $queueName
     */
    public function __construct($queueName){
        parent::__construct($queueName);
        $this->initStoreEngineWithHardcodedSettings();
    }

    /**
     * Wrapper, will be deprecated once the lib is built into the P4T application
     */
    private function initStoreEngineWithHardcodedSettings(){
        //this is setup that should be done on the outside also,
        //but enough for this small testcase
        $this->db = new P4TMongo('mongodb://localhost');
        $this->db->setDBName('p4t_queues');
        $this->ensureIndexes();
    }



    /******* IMPLEMENTING ABSTRACT METHODS *********************************************
     *
     *
     */
    public function pushMessageToQueue($message, Array $metaData, $schedule = null){
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
    public function totalOpenMessagesInQueue(){
        return $this->totalMessageInQueue( array('done'=>0) );
    }


    /**
     * @return P4TQueueRecord
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

        return null;
    }


    /**
     * @param P4TQueueRecord $record
     *
     * @return boolean
     */
    public function markRecordAsFinished(P4TQueueRecord $record){
        return $this->updateRecord($record, array('locked' => 0, 'done' => 1));
    }



    /******** INTERNAL MAINTENANCE METHODS **********************************************
     *
     *
     */

    /**
     * @param array $filter
     * @return int
     */
    private function totalMessageInQueue(Array $filter=array()){
        return $this->db->count($this->getCollectionName(), $filter);
    }


    /**
     * @param P4TQueueRecord $record
     * @param Array $set
     * @return mixed
     */
    private function updateRecord(P4TQueueRecord $record, Array $set){
        return $this->db->updateOneByID($this->getCollectionName(), $record->getId(), $set);
    }


    /**
     * @return string
     */
    private function getCollectionName(){
        return 'queue_'.$this->getQueueName();
    }


    /**
     * MongoDB Maintenance Operation
     */
    private function ensureIndexes(){
        $collection = $this->getCollectionName();
        $this->db->ensureIndex($collection, array('done' => 1));
        $this->db->ensureIndex($collection, array('locked' => 1, 'done' => 1));
    }
}