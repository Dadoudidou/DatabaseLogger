<?php

namespace DatabaseLogger\Log\Engine;

use Cake\Log\Engine\BaseLog;
use Cake\ORM\TableRegistry;


/**
 * Description of DatabaseLog
 *
 * @author dviolet
 */
class DatabaseLog extends BaseLog {
    
    /**
     * @var string
     */
    var $model = null;
        
    public function __construct(array $config = array()) {
	parent::__construct($config);
	$this->model = isset($config['model']) ? $config['model'] : 'DatabaseLogger.Logging';
    }
    
    public function log($level, $message, array $context = array()) {
	
	$logRegistry = TableRegistry::get($this->model);
	
	/* @var $log \DatabaseLogger\Model\Entity\Logging */
	$log = $logRegistry->newEntity();
	
	$log->message = $message;
	$log->type = strtoupper($level);
	
	
	if($logRegistry->save($log)){
	    
	} else {
	    
	}
	
    }
    
}
