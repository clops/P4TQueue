<?php
    /**
     * @author  ak
     * @since   22.08.13 15:55
     */
    require_once('init.inc.php');

    $queue  = new P4TQueue('awesome');
    $status = $queue->push('Some Cool Message', array('priority' => 1, 'foo' => 'bar'));

    echo $status;