<?php
declare(strict_types=1);

namespace Avolle\CharacterPagination\View\Cell;

use Avolle\CharacterPagination\Traits\RepositoryTrait;
use Cake\Datasource\QueryInterface;
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
     * @var string[]
     */
    protected $_validCellOptions = [];

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
     * @param \Cake\ORM\Table|\Cake\ORM\Query $object Model class to load character records from
     * @return void
     * @throws \Exception
     */
    public function display($object): void
    {
        $characters = $this->getCharacters($object);
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
     * @param \Cake\ORM\Table|\Cake\ORM\Query $object Model class to get character records from
     * @return \Cake\Datasource\QueryInterface
     * @throws \Exception
     */
    protected function getCharacters($object): QueryInterface
    {
        $this->determineRepository($object);
        if (!$this->repository->hasBehavior('Character')) {
            $this->repository->addBehavior('Avolle/CharacterPagination.Character');
        }

        return $this->query->find('characters');
    }
}
