<?php
declare(strict_types=1);

namespace Avolle\CharacterPagination\Traits;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\Table;

trait RepositoryTrait
{
    /**
     * @var \Cake\ORM\Query\SelectQuery
     */
    protected SelectQuery $query;

    /**
     * @var \Cake\ORM\Table
     */
    protected Table $repository;

    /**
     * Setup `query` and `repositories` properties in class based on which argument is passed to method
     *
     * @param \Cake\ORM\Table|\Cake\ORM\Query\SelectQuery $object Table or Query instance to use loading and filtering characters
     * @return void
     */
    protected function determineRepository(Table|SelectQuery $object): void
    {
        if ($object instanceof Table) {
            $this->repository = $object;
            $this->query = $object->query();
        } else {
            $this->repository = $object->getRepository();
            $this->query = $object;
        }
    }
}
