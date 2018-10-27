<?php

namespace DataNormalizer\Model\Table;

use Cake\Database\Schema\TableSchema;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BadAddresses Model
 *
 * @method \DataNormalizer\Model\Entity\BadAddress get($primaryKey, $options = [])
 * @method \DataNormalizer\Model\Entity\BadAddress newEntity($data = null, array $options = [])
 * @method \DataNormalizer\Model\Entity\BadAddress[] newEntities(array $data, array $options = [])
 * @method \DataNormalizer\Model\Entity\BadAddress|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \DataNormalizer\Model\Entity\BadAddress|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \DataNormalizer\Model\Entity\BadAddress patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \DataNormalizer\Model\Entity\BadAddress[] patchEntities($entities, array $data, array $options = [])
 * @method \DataNormalizer\Model\Entity\BadAddress findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BadAddressesTable extends Table
{

    protected function _initializeSchema(TableSchema $schema)
    {
        $schema->setColumnType('errors', 'json');
        $schema->setColumnType('data', 'json');

        return $schema;
    }

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('bad_addresses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('path')
            ->maxLength('path', 100)
            ->requirePresence('path', 'create')
            ->notEmpty('path');

        $validator
            ->isArray('errors')
            ->requirePresence('errors', 'create')
            ->notEmpty('errors');

        $validator
            ->isArray('data')
            ->requirePresence('data', 'create')
            ->notEmpty('data');

        return $validator;
    }
}
