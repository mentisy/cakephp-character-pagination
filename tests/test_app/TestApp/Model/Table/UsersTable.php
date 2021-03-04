<?php
declare(strict_types=1);

namespace TestApp\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @method \TestApp\Model\Entity\User get($primaryKey, $options = [])
 * @method \TestApp\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \TestApp\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \TestApp\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \TestApp\Model\Entity\User|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \TestApp\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \TestApp\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \TestApp\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Avolle/CharacterPagination.Character');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->requirePresence('name', 'create')
            ->scalar('name')
            ->notEmptyString('name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->email('email');

        $validator
            ->requirePresence('number', 'create')
            ->notEmptyString('number')
            ->regex('number', '/^(\+[0-9]{1,3})?[\-0-9]{1,12}$/', __('Phone number must only contain numbers and the symbols + and -'));

        $validator
            ->requirePresence('password', 'create')
            ->minLength('password', 4, __('Passwords must be at least 4 characters long.'))
            ->notEmptyString('password');

        $validator
            ->requirePresence('role', 'create')
            ->notEmptyString('role')
            ->numeric('role', 'Invalid Role');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
