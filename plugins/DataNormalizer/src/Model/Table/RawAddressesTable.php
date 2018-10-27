<?php
namespace DataNormalizer\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RawAddresses Model
 *
 * @method \DataNormalizer\Model\Entity\RawAddress get($primaryKey, $options = [])
 * @method \DataNormalizer\Model\Entity\RawAddress newEntity($data = null, array $options = [])
 * @method \DataNormalizer\Model\Entity\RawAddress[] newEntities(array $data, array $options = [])
 * @method \DataNormalizer\Model\Entity\RawAddress|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \DataNormalizer\Model\Entity\RawAddress|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \DataNormalizer\Model\Entity\RawAddress patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \DataNormalizer\Model\Entity\RawAddress[] patchEntities($entities, array $data, array $options = [])
 * @method \DataNormalizer\Model\Entity\RawAddress findOrCreate($search, callable $callback = null, $options = [])
 */
class RawAddressesTable extends Table
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

        $this->setTable('raw_addresses');
        $this->setDisplayField('hash');
        $this->setPrimaryKey('hash');
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
            ->scalar('id')
            ->maxLength('id', 100)
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('hash')
            ->maxLength('hash', 100)
            ->requirePresence('hash', 'create')
            ->notEmpty('hash');

        $validator
            ->scalar('path')
            ->maxLength('path', 100)
            ->allowEmpty('path');

        $validator
            ->decimal('lon')
            ->allowEmpty('lon');

        $validator
            ->decimal('lat')
            ->allowEmpty('lat');

        $validator
            ->scalar('number')
            ->maxLength('number', 100)
            ->allowEmpty('number');

        $validator
            ->scalar('street')
            ->maxLength('street', 100)
            ->allowEmpty('street');

        $validator
            ->scalar('unit')
            ->maxLength('unit', 100)
            ->allowEmpty('unit');

        $validator
            ->scalar('city')
            ->maxLength('city', 100)
            ->allowEmpty('city');

        $validator
            ->scalar('district')
            ->maxLength('district', 100)
            ->allowEmpty('district');

        $validator
            ->scalar('region')
            ->maxLength('region', 100)
            ->allowEmpty('region');

        $validator
            ->scalar('postcode')
            ->maxLength('postcode', 100)
            ->allowEmpty('postcode');

        return $validator;
    }
}
