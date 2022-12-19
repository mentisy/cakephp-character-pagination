<?php
declare(strict_types=1);

namespace Avolle\CharacterPagination\Test\TestCase\Controller\Component;

use Avolle\CharacterPagination\Controller\Component\CharacterComponent;
use Avolle\CharacterPagination\View\Cell\CharacterCell;
use Cake\Controller\ComponentRegistry;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use TestApp\Controller\AppController;
use TestApp\Model\Table\MoviesTable;
use TestApp\Model\Table\UsersTable;

/**
 * Avolle\CharacterPagination\Controller\Component\CharacterComponent Test Case
 */
class CharacterComponentTest extends TestCase
{
    protected array $fixtures = [
        'plugin.Avolle/CharacterPagination.Movies',
        'plugin.Avolle/CharacterPagination.Users',
    ];

    /**
     * Test subject
     *
     * @var \Avolle\CharacterPagination\Controller\Component\CharacterComponent
     */
    protected CharacterComponent $Character;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry(new AppController(new ServerRequest([
            'query' => [
                'characters' => 'A',
            ],
        ])));
        $this->Character = new CharacterComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Character);

        parent::tearDown();
    }

    /**
     * Test paginate method
     * Paginate a Query object
     *
     * @return void
     * @throws \Exception
     * @uses \Avolle\CharacterPagination\Controller\Component\CharacterComponent::paginate()
     */
    public function testPaginateQueryObject(): void
    {
        $users = $this->Character->paginate((new UsersTable())->find());
        $expected = [
            'A User Name',
            'A User Name 3',
        ];
        $this->assertSame($expected, $users->extract('name')->toArray());
    }

    /**
     * Test paginate method
     * Paginate a Table object
     *
     * @return void
     * @throws \Exception
     * @uses \Avolle\CharacterPagination\Controller\Component\CharacterComponent::paginate()
     */
    public function testPaginateTableObject(): void
    {
        $users = $this->Character->paginate(new UsersTable());
        $expected = [
            'A User Name',
            'A User Name 3',
        ];
        $this->assertSame($expected, $users->extract('name')->toArray());
    }

    /**
     * Test paginate method
     * The behavior has not been added in the table class configuration. Assert it will be added during pagination.
     *
     * @return void
     * @throws \Exception
     * @uses \Avolle\CharacterPagination\Controller\Component\CharacterComponent::paginate()
     */
    public function testBehaviorAddedInRunTime(): void
    {
        $moviesTable = new MoviesTable();
        $this->assertFalse($moviesTable->hasBehavior('Character'));
        $this->Character->paginate($moviesTable);
        $this->assertTrue($moviesTable->hasBehavior('Character'));
    }

    /**
     * Test createCell method
     * Assert a cell has been created
     *
     * @return void
     * @throws \Exception
     * @uses \Avolle\CharacterPagination\Controller\Component\CharacterComponent::createCell()
     */
    public function testCreateCell(): void
    {
        $this->Character->paginate(new MoviesTable());
        $cell = $this->Character->getController()->viewBuilder()->getVar('characterCell');
        $this->assertInstanceOf(CharacterCell::class, $cell);
    }
}
