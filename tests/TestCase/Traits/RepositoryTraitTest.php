<?php
declare(strict_types=1);

namespace Avolle\CharacterPagination\Test\TestCase\Traits;

use Avolle\CharacterPagination\Traits\RepositoryTrait;
use Cake\ORM\Query\SelectQuery;
use Cake\TestSuite\TestCase;
use TestApp\Model\Table\UsersTable;

class RepositoryTraitTest extends TestCase
{
    use RepositoryTrait;

    /**
     * Fixtures
     *
     * @var string[]
     */
    protected array $fixtures = [
        'plugin.Avolle/CharacterPagination.Users',
    ];

    /**
     * Test determineRepository method
     * A Table instance is passed, assert repository and query properties
     *
     * @return void
     * @uses \Avolle\CharacterPagination\Traits\RepositoryTrait::determineRepository()
     */
    public function testDetermineRepositoryTableInstancePassed(): void
    {
        $this->determineRepository(new UsersTable());
        $this->assertInstanceOf(SelectQuery::class, $this->query);
        $this->assertInstanceOf(UsersTable::class, $this->repository);
    }

    /**
     * Test determineRepository method
     * A Query instance is passed, assert repository and query properties
     *
     * @return void
     * @uses \Avolle\CharacterPagination\Traits\RepositoryTrait::determineRepository()
     */
    public function testDetermineRepositoryQueryInstancePassed(): void
    {
        $this->determineRepository(new SelectQuery(new UsersTable()));
        $this->assertInstanceOf(SelectQuery::class, $this->query);
        $this->assertInstanceOf(UsersTable::class, $this->repository);
    }
}
