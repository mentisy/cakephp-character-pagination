<?php
declare(strict_types=1);

namespace TestApp\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @method \TestApp\Model\Entity\Movie get($primaryKey, $options = [])
 * @method \TestApp\Model\Entity\Movie newEntity($data = null, array $options = [])
 * @method \TestApp\Model\Entity\Movie[] newEntities(array $data, array $options = [])
 * @method \TestApp\Model\Entity\Movie|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \TestApp\Model\Entity\Movie|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \TestApp\Model\Entity\Movie patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \TestApp\Model\Entity\Movie[] patchEntities($entities, array $data, array $options = [])
 * @method \TestApp\Model\Entity\Movie findOrCreate($search, callable $callback = null, $options = [])
 */
class MoviesTable extends Table
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

        $this->setTable('movies');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');
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
            ->requirePresence('title', 'create')
            ->scalar('title')
            ->notEmptyString('title');

        return $validator;
    }
}
