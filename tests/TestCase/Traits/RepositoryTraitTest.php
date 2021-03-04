<?php
declare(strict_types=1);

namespace Avolle\CharacterPagination\Test\TestCase\Traits;

use Avolle\CharacterPagination\Plugin as CharacterPaginationPlugin;
use Avolle\CharacterPagination\Traits\RepositoryTrait;
use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Query;
use TestApp\Model\Table\UsersTable;

class RepositoryTraitTest extends \Cake\TestSuite\TestCase
{
    use RepositoryTrait;

    /**
     * Fixtures
     *
     * @var string[]
     */
    protected $fixtures = [
        'plugin.Avolle/CharacterPagination.Users',
    ];

    /**
     * Test determineRepository method
     * A Table instance is passed, assert repository and query properties
     *
     * @return void
     * @throws \Exception
     * @uses \Avolle\CharacterPagination\Traits\RepositoryTrait::determineRepository()
     */
    public function testDetermineRepositoryTableInstancePassed(): void
    {
        $this->determineRepository(new UsersTable());
        $this->assertInstanceOf(Query::class, $this->query);
        $this->assertInstanceOf(UsersTable::class, $this->repository);
    }

    /**
     * Test determineRepository method
     * A Query instance is passed, assert repository and query properties
     *
     * @return void
     * @throws \Exception
     * @uses \Avolle\CharacterPagination\Traits\RepositoryTrait::determineRepository()
     */
    public function testDetermineRepositoryQueryInstancePassed(): void
    {
        $connection = new Connection(ConnectionManager::get('test')->config());
        $this->determineRepository(new Query($connection, new UsersTable()));
        $this->assertInstanceOf(Query::class, $this->query);
        $this->assertInstanceOf(UsersTable::class, $this->repository);
    }

    /**
     * Test determineRepository method
     * Invalid argument passed to method. Is not an object, so exception message will use value.
     * Assert exception
     *
     * @return void
     * @throws \Exception
     * @uses \Avolle\CharacterPagination\Traits\RepositoryTrait::determineRepository()
     * @noinspection PhpParamsInspection
     */
    public function testDetermineRepositoryInvalidArgumentPassed(): void
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Invalid argument `random` when creating character pagination. '
            . 'Instance of Cake\ORM\Table or Cake\ORM\Query expected.');
        $this->determineRepository('random');
    }

    /**
     * Test determineRepository method
     * Invalid argument passed to method. Is an object, so exception will use object class name.
     * Assert exception
     *
     * @return void
     * @throws \Exception
     * @uses \Avolle\CharacterPagination\Traits\RepositoryTrait::determineRepository()
     * @noinspection PhpParamsInspection
     */
    public function testDetermineRepositoryInvalidInstancePassed(): void
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage(
            'Invalid argument `Avolle\CharacterPagination\Plugin` when creating character pagination. '
                . 'Instance of Cake\ORM\Table or Cake\ORM\Query expected.'
        );
        $this->determineRepository(new CharacterPaginationPlugin());
    }
}
