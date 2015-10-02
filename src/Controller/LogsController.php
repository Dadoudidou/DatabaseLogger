<?php
namespace DatabaseLogger\Controller;

use Cake\ORM\TableRegistry;
use DatabaseLogger\Controller\AppController;

/**
 * Logs Controller
 *
 */
class LogsController extends AppController
{

    public $helpers = [
	'Paginator'
    ];
    
    public function initialize() {
	parent::initialize();
	$this->loadComponent('Paginator');
    }
    
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
	if($this->request->is('ajax') && $this->request->is('post')){
	    $this->viewBuilder()->autoLayout(false);
	    $this->autoRender = false;
	    
	    $paginate_options = [
		'limit' => 100,
		'order' => [ 'Logging.created' => 'desc' ]
	    ];

	    $this->paginate = $paginate_options;
	    $logs = $this->paginate(TableRegistry::get('DatabaseLogger.Logging'));
	    
	    echo json_encode($logs);
	    
	}
	$this->set('logs',[]);
    }

    
}
