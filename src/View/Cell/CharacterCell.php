<?php
declare(strict_types=1);

namespace Avolle\CharacterPagination\View\Cell;

use Avolle\CharacterPagination\Traits\RepositoryTrait;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\Table;
use Cake\View\Cell;

/**
 * Character cell
 *
 * @property \Avolle\CharacterPagination\View\Helper\CharacterHelper $Character
 */
class CharacterCell extends Cell
{
    use RepositoryTrait;

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array<string>
     */
    protected array $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->View = $this->createView();
        if (!$this->View->helpers()->has('Character')) {
            $this->View->loadHelper('Avolle/CharacterPagination.Character');
        }
    }

    /**
     * Default display method.
     *
     * @param \Cake\ORM\Table|\Cake\ORM\Query\SelectQuery $object Model class to load character records from
     * @return void
     */
    public function display(Table|SelectQuery $object): void
    {
        $characters = $this->getCharacters($object)->all();
        $links = [];
        foreach ($characters->toArray() as $character) {
            /** @noinspection PhpUndefinedFieldInspection */
            $links[] = $this->View->Character->link($character['firstChar']);
        }
        $this->set(compact('links'));
    }

    /**
     * Get all used first characters from a given model
     * Will check if CharacterBehavior exists in model. If not, add it.
     * Then find characters from the behavior finder
     *
     * @param \Cake\ORM\Table|\Cake\ORM\Query\SelectQuery $object Model class to get character records from
     * @return \Cake\ORM\Query\SelectQuery
     */
    protected function getCharacters(Table|SelectQuery $object): SelectQuery
    {
        $this->determineRepository($object);
        if (!$this->repository->hasBehavior('Character')) {
            $this->repository->addBehavior('Avolle/CharacterPagination.Character');
        }

        return $this->query->find('characters');
    }
}
