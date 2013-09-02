<?php
    /**
     * This is just a demo setup, so no magic here
     */
    require_once('lib/P4TQueueDispatcher.class.php');
    require_once('lib/P4TQueueRecord.class.php');
    require_once('lib/P4TMongo.class.php');
    require_once('lib/timer.class.php');
    require_once('lib/storageEngines/AbstractQueueStorageEngine.class.php');
    require_once('lib/storageEngines/MongoDBStorage.class.php');
    require_once('lib/queueTypes/AbstractQueueType.class.php');
    require_once('lib/queueTypes/Basic.class.php');

    //start timer here, this will hence include connection times!
    timer::start();

?>