<?php
declare(strict_types=1);

namespace Avolle\CharacterPagination\Model\Behavior;

use Cake\Database\Expression\ComparisonExpression;
use Cake\Database\Expression\FunctionExpression;
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

        return $query->select(compact('firstChar'))->groupBy('ASCII(firstChar)')->orderByAsc('ASCII(firstChar)');
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
        $fieldIdentifier = new IdentifierExpression($this->determineField());
        $field = $this->asciiLeft($fieldIdentifier);
        $or = [];
        foreach ($characters as $character) {
            $asciiCond = $this->ascii($character);
            $or[] = new ComparisonExpression($field, $asciiCond);
        }
        $cond = $query->newExpr()->or($or);

        return $query->where($cond)->orderByAsc($fieldIdentifier);
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

    /**
     * Get the SQL ASCII value. E.g.: ASCII(name) or ASCII('Something')
     *
     * @param \Cake\Database\Expression\FunctionExpression|string $value Value to ASCII
     * @return \Cake\Database\Expression\FunctionExpression
     */
    protected function ascii(FunctionExpression|string $value): FunctionExpression
    {
        return new FunctionExpression('ASCII', [$value]);
    }

    /**
     * Get the SQL ASCII LEFT value. E.g.: ASCII(LEFT(name, 1))
     *
     * @param \Cake\Database\Expression\IdentifierExpression $fieldIdentifier Field Identifier to LEFT
     * @return \Cake\Database\Expression\FunctionExpression
     */
    protected function asciiLeft(IdentifierExpression $fieldIdentifier): FunctionExpression
    {
        $leftFunc = new FunctionExpression('LEFT', [$fieldIdentifier, 1], [1 => 'integer']);

        return $this->ascii($leftFunc);
    }
}
