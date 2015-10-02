<?php
namespace DatabaseLogger\Model\Table;

use ArrayObject;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\Routing\Router;
use Cake\Validation\Validator;
use DatabaseLogger\Model\Entity\Logging;

/**
 * Logging Model
 *
 */
class LoggingTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('logging');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

    }

    /**
     * Default validation rules.
     *
     * @param Validator $validator Validator instance.
     * @return Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('type');

        $validator
            ->allowEmpty('message');

        $validator
            ->allowEmpty('ip');

        $validator
            ->allowEmpty('hostname');

        $validator
            ->allowEmpty('uri');

        $validator
            ->allowEmpty('refer');

        return $validator;
    }
    
    public function beforeSave(Event $event, Entity $entity, ArrayObject $options){
	/* @var $entity Logging */
	$entity->ip = env('REMOTE_ADDR');
	$entity->hostname = env('HTTP_HOST');
	$entity->uri = env('REQUEST_URI');
	$entity->refer = env('HTTP_REFERER');
	$entity->request = json_encode(Router::getRequest(true));
	return true;
    }
    
}
