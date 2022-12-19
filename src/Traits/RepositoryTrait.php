<?php
declare(strict_types=1);

namespace Avolle\CharacterPagination\Traits;

use Cake\ORM\Query;
use Cake\ORM\Table;
use InvalidArgumentException;

trait RepositoryTrait
{
    /**
     * @var \Cake\ORM\Query
     */
    protected $query;

    /**
     * @var \Cake\ORM\Table
     */
    protected Table $repository;

    /**
     * Setup `query` and `repositories` properties in class based on which argument is passed to method
     *
     * @param \Cake\ORM\Table|\Cake\ORM\Query $object Table or Query instance to use loading and filtering characters
     * @return void
     * @throws \Exception
     */
    protected function determineRepository($object): void
    {
        if ($object instanceof Table) {
            $this->repository = $object;
            $this->query = $object->query();
        } elseif ($object instanceof Query) {
            $this->repository = $object->getRepository();
            $this->query = $object;
        } else {
            if (is_object($object)) {
                $message = get_class($object);
            } else {
                $message = $object;
            }
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid argument `%s` when creating character pagination. '
                    . 'Instance of Cake\\ORM\\Table or Cake\\ORM\\Query expected.',
                    $message
                )
            );
        }
    }
}
