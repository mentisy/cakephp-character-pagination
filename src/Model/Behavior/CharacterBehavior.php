<?php
declare(strict_types=1);

namespace Avolle\CharacterPagination\Model\Behavior;

use Cake\Database\Expression\IdentifierExpression;
use Cake\ORM\Behavior;
use Cake\ORM\Query;

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
     * @param \Cake\ORM\Query $query Query
     * @return \Cake\ORM\Query
     */
    public function findCharacters(Query $query): Query
    {
        $nameIdentifier = new IdentifierExpression($this->determineField());
        $firstChar = $query->func()
            ->aggregate('LEFT', [$nameIdentifier, 1], [], 'string');

        return $query->select(compact('firstChar'))->group('firstChar')->orderAsc('firstChar');
    }

    /**
     * Get all records matching the selected `characters` option
     * Filtering is used by leveraging the REGEXP sql function, filtering records starting by either characters provided
     *
     * @param \Cake\ORM\Query $query Query
     * @param array $options Options
     * @return \Cake\ORM\Query
     */
    public function findRecordsWithCharacters(Query $query, array $options): Query
    {
        if (!isset($options['characters']) || !is_array($options['characters'])) {
            $options['characters'] = ['A'];
        }
        $charactersString = implode('|', $options['characters']);
        $cond = sprintf("%s REGEXP '^(%s)'", $this->determineField(), $charactersString);

        return $query->where($cond)->orderAsc($this->determineField());
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
