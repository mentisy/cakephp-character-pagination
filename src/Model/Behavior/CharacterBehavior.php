<?php
declare(strict_types=1);

namespace Avolle\CharacterPagination\Model\Behavior;

use Cake\Database\Expression\IdentifierExpression;
use Cake\ORM\Behavior;
use Cake\ORM\Query\SelectQuery;

/**
 * Class CharacterBehavior
 *
 * @package Avolle\CharacterPagination\Model\Behavior
 */
class CharacterBehavior extends Behavior
{
    /**
     * Default config
     *  - field: Which field to run characters pagination for (if null, will attempt to use table's displayField)
     *  - cacheKey: Defines the cache key to use for caching characters query results. If null, cache will not be used.
     *
     * @var array<string, mixed>
     */
    protected array $_defaultConfig = [
        'field' => null,
        'cacheKey' => null,
    ];

    /**
     * Find all used first characters with the configured field in table
     *
     * @param \Cake\ORM\Query\SelectQuery $query Query
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findCharacters(SelectQuery $query): SelectQuery
    {
        $nameIdentifier = new IdentifierExpression($this->determineField());
        $firstChar = $query->func()
            ->aggregate('LEFT', [$nameIdentifier, 1], [], 'string');

        return $query->select(compact('firstChar'))->groupBy('firstChar')->orderByAsc('firstChar');
    }

    /**
     * Get all records matching the selected `characters` argument.
     * Filtering is used by leveraging the REGEXP sql function, filtering records starting by either characters provided
     *
     * @param \Cake\ORM\Query\SelectQuery $query Query
     * @param array<string> $characters Characters to find records starting with
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findRecordsWithCharacters(SelectQuery $query, array $characters = ['A']): SelectQuery
    {
        $charactersString = implode('|', $characters);
        $cond = sprintf("%s REGEXP '^(%s)'", $this->determineField(), $charactersString);

        return $query->where($cond)->orderByAsc($this->determineField());
    }

    /**
     * Determine which table field (column) to filter records by
     *
     * @return string Field (column) to filter by
     */
    protected function determineField(): string
    {
        $field = $this->getConfig('field');
        if ($field === null) {
            $field = $this->table()->getDisplayField();
        }

        return sprintf('%s.%s', $this->table()->getAlias(), $field);
    }
}
