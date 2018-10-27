<?php
namespace DataNormalizer\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CompiledAddresses Model
 *
 * @method \DataNormalizer\Model\Entity\CompiledAddress get($primaryKey, $options = [])
 * @method \DataNormalizer\Model\Entity\CompiledAddress newEntity($data = null, array $options = [])
 * @method \DataNormalizer\Model\Entity\CompiledAddress[] newEntities(array $data, array $options = [])
 * @method \DataNormalizer\Model\Entity\CompiledAddress|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \DataNormalizer\Model\Entity\CompiledAddress|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \DataNormalizer\Model\Entity\CompiledAddress patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \DataNormalizer\Model\Entity\CompiledAddress[] patchEntities($entities, array $data, array $options = [])
 * @method \DataNormalizer\Model\Entity\CompiledAddress findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CompiledAddressesTable extends Table
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

        $this->setTable('compiled_addresses');
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
            ->scalar('uuid')
            ->maxLength('uuid', 100)
            ->allowEmpty('uuid')
            ->add('uuid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('hash')
            ->maxLength('hash', 100)
            ->allowEmpty('hash')
            ->add('hash', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->decimal('lat')
            ->allowEmpty('lat');

        $validator
            ->decimal('lng')
            ->allowEmpty('lng');

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

        $validator
            ->dateTime('modifed')
            ->allowEmpty('modifed');

        $validator
            ->scalar('path')
            ->maxLength('path', 100)
            ->allowEmpty('path');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['uuid']));
        $rules->add($rules->isUnique(['hash']));

        return $rules;
    }
}
