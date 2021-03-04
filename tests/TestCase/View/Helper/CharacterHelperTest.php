<?php
declare(strict_types=1);

namespace Avolle\CharacterPagination\Test\TestCase\View\Helper;

use Avolle\CharacterPagination\View\Helper\CharacterHelper;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * Avolle\CharacterPagination\View\Helper\CharacterHelper Test Case
 */
class CharacterHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Avolle\CharacterPagination\View\Helper\CharacterHelper
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
        $request = $this->makeRequest();
        $view = new View($request);
        $this->Character = new CharacterHelper($view);

        Router::reload();
        Router::connect('/{controller}/{action}/*');
        Router::setRequest($request);
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
     * Test link method
     * Not an active filter link - Assert link making the character filter active
     *
     * @return void
     * @uses \Avolle\CharacterPagination\View\Helper\CharacterHelper::link()
     */
    public function testLinkCreateActiveLink(): void
    {
        $expected = [
            'a' => ['href' => '/movies/index?characters=A'],
            'A',
            '/a',
        ];
        $actual = $this->Character->link('A');
        $this->assertHtml($expected, $actual, true);
    }

    /**
     * Test link method
     * An active filter link - Assert link making the character filter inactive
     *
     * @return void
     * @uses \Avolle\CharacterPagination\View\Helper\CharacterHelper::link()
     */
    public function testLinkRemoveActiveLink(): void
    {
        $request = $this->makeRequest('/movies/index', ['characters' => 'A']);
        $this->Character->getView()->setRequest($request);
        $expected = [
            'a' => ['href' => '/movies/index', 'class' => ' active'],
            'A',
            '/a',
        ];
        $actual = $this->Character->link('A');
        $this->assertHtml($expected, $actual, true);
    }

    /**
     * Test link method
     * Make sure the link keeps other query parameters
     *
     * @return void
     * @uses \Avolle\CharacterPagination\View\Helper\CharacterHelper::link()
     */
    public function testLinkKeepsOtherQueryParameters(): void
    {
        $request = $this->makeRequest('/movies/index', ['sort' => 'name', 'order' => 'desc']);
        $this->Character->getView()->setRequest($request);
        $expected = [
            'a' => ['href' => '/movies/index?characters=C&amp;sort=name&amp;order=desc'],
            'C',
            '/a',
        ];
        $actual = $this->Character->link('C');
        $this->assertHtml($expected, $actual, true);
    }

    /**
     * Test link method
     * Make sure the link removes the page query parameter, as we don't want to start at page X with a new letter
     *
     * @return void
     * @uses \Avolle\CharacterPagination\View\Helper\CharacterHelper::link()
     */
    public function testLinkPageQueryIsResetOnNewLink(): void
    {
        $request = $this->makeRequest('/movies/index', ['page' => '2']);
        $this->Character->getView()->setRequest($request);
        $expected = [
            'a' => ['href' => '/movies/index?characters=C'],
            'C',
            '/a',
        ];
        $actual = $this->Character->link('C');
        $this->assertHtml($expected, $actual, true);
    }

    /**
     * Test link method
     * Make sure the link adds the class name when a non-active link is created
     *
     * @return void
     * @uses \Avolle\CharacterPagination\View\Helper\CharacterHelper::link()
     */
    public function testLinkClassOptionAddsOtherClassNames(): void
    {
        $request = $this->makeRequest('/movies/index');
        $this->Character->getView()->setRequest($request);
        $expected = [
            'a' => ['href' => '/movies/index?characters=C', 'class' => 'test'],
            'C',
            '/a',
        ];
        $actual = $this->Character->link('C', ['class' => 'test']);
        $this->assertHtml($expected, $actual, true);
    }

    /**
     * Test link method
     * Make sure the link appends the class name when an active link is created
     *
     * @return void
     * @uses \Avolle\CharacterPagination\View\Helper\CharacterHelper::link()
     */
    public function testLinkClassOptionAppendsActiveClassName(): void
    {
        $request = $this->makeRequest('/movies/index', ['characters' => 'C']);
        $this->Character->getView()->setRequest($request);
        $expected = [
            'a' => ['href' => '/movies/index', 'class' => 'test active'],
            'C',
            '/a',
        ];
        $actual = $this->Character->link('C', ['class' => 'test']);
        $this->assertHtml($expected, $actual, true);
    }

    /**
     * Test link method
     * Configure a different class name to use when creating an active link
     *
     * @return void
     * @uses \Avolle\CharacterPagination\View\Helper\CharacterHelper::link()
     */
    public function testLinkDifferentActiveClassNameConfigured(): void
    {
        $request = $this->makeRequest('/movies/index', ['characters' => 'C']);
        $this->Character = new CharacterHelper($this->Character->getView(), [
            'activeClassName' => 'differentActiveClassName',
        ]);
        $this->Character->getView()->setRequest($request);
        $expected = [
            'a' => ['href' => '/movies/index', 'class' => 'test differentActiveClassName'],
            'C',
            '/a',
        ];
        $actual = $this->Character->link('C', ['class' => 'test']);
        $this->assertHtml($expected, $actual, true);
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
