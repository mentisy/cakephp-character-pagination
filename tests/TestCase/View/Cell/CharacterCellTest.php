<?php
declare(strict_types=1);

namespace Avolle\CharacterPagination\Test\TestCase\View\Cell;

use Avolle\CharacterPagination\Plugin as CharacterPaginationPlugin;
use Avolle\CharacterPagination\View\Cell\CharacterCell;
use Cake\Core\Plugin;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use TestApp\Model\Table\MoviesTable;
use TestApp\Model\Table\UsersTable;

/**
 * Avolle\CharacterPagination\View\Cell\CharacterCell Test Case
 */
class CharacterCellTest extends TestCase
{
    /**
     * Fixtures
     *
     * @var string[]
     */
    protected $fixtures = [
        'plugin.Avolle/CharacterPagination.Movies',
        'plugin.Avolle/CharacterPagination.Users',
    ];

    /**
     * Request mock
     *
     * @var \Cake\Http\ServerRequest|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $request;

    /**
     * Response mock
     *
     * @var \Cake\Http\Response|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $response;

    /**
     * Test subject
     *
     * @var \Avolle\CharacterPagination\View\Cell\CharacterCell
     */
    protected $Character;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        Plugin::getCollection()->add(new CharacterPaginationPlugin());
        $this->request = $this->makeRequest();
        $this->response = $this->getMockBuilder('Cake\Http\Response')->getMock();
        $this->Character = new CharacterCell($this->request, $this->response, null, [
            'action' => 'display',
            'args' => [new UsersTable()],
        ]);

        Router::reload();
        Router::connect('/{controller}/{action}/*');
        Router::setRequest($this->request);
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
     * Test display method
     * Assert links are created
     *
     * @return void
     * @throws \Exception
     */
    public function testDisplayLinksVar(): void
    {
        $this->Character->display(new UsersTable());
        $links = $this->Character->viewBuilder()->getVar('links');
        $this->assertNotEmpty($links);
        $this->assertHtml([
            'a' => ['href' => '/movies/index?characters=A'],
            'A',
            '/a',
        ], $links[0]);
    }

    /**
     * Test display method
     * Assert links are rendered with a pipe (|) divider
     *
     * @return void
     * @throws \Exception
     * @noinspection HtmlUnknownTarget
     */
    public function testDisplayRendered(): void
    {
        $this->Character->viewBuilder()->setTemplate('Avolle/CharacterPagination.display');
        $res = (string)$this->Character->render();
        $expected = '<a href="/movies/index?characters=A">A</a> | <a href="/movies/index?characters=B">B</a>';
        $this->assertStringContainsString($expected, $res);
    }

    /**
     * Test display method
     * Character behavior not preloaded in used Table. Load on runtime
     * The MoviesTable does not preload the Character behavior, so any character rendering is a successful test
     *
     * @return void
     * @throws \Exception
     * @uses \Avolle\CharacterPagination\View\Cell\CharacterCell::display()
     */
    public function testDisplayBehaviorNotPreloaded(): void
    {
        $this->Character->display(new MoviesTable());
        $links = $this->Character->viewBuilder()->getVar('links');
        $this->assertNotEmpty($links);
        $this->assertHtml([
            'a' => ['href' => '/movies/index?characters=G'],
            'G',
            '/a',
        ], $links[1]);
    }

    /**
     * Create a server request
     *
     * @param string $url Url
     * @param array $query Query parameters
     * @return \Cake\Http\ServerRequest
     */
    protected function makeRequest(string $url = '/', array $query = []): ServerRequest
    {
        $request = [
            'url' => $url,
            'query' => $query,
            'params' => [
                'plugin' => null,
                'controller' => 'movies',
                'action' => 'index',
            ],
        ];

        return new ServerRequest($request);
    }
}
