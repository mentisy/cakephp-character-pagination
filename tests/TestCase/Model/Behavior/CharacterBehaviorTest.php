<?php
declare(strict_types=1);

namespace Avolle\CharacterPagination\Test\TestCase\Model\Behavior;

use Cake\TestSuite\TestCase;
use TestApp\Model\Table\UsersTable;

class CharacterBehaviorTest extends TestCase
{
    /**
     * Fixtures for tests
     *
     * @var string[]
     */
    protected array $fixtures = [
        'plugin.Avolle/CharacterPagination.Users',
    ];

    /**
     * Test findCharacters method
     *
     * @return void
     * @uses \Avolle\CharacterPagination\Model\Behavior\CharacterBehavior::findCharacters()
     */
    public function testFindCharacters(): void
    {
        $usersTable = new UsersTable();
        $actual = $usersTable->find('characters');

        $this->assertSame(['A', 'B', 'K'], $actual->all()->extract('firstChar')->toArray());
    }

    /**
     * Test findRecordsWithCharacters method
     * No `characters` option provided - Get records with character `A`
     *
     * @return void
     * @uses \Avolle\CharacterPagination\Model\Behavior\CharacterBehavior::findRecordsWithCharacters()
     */
    public function testFindRecordsWithCharactersNoCharactersOptionProvided(): void
    {
        $usersTable = new UsersTable();
        $actual = $usersTable->find('recordsWithCharacters');

        $expected = [
            'A User Name',
            'A User Name 3',
        ];
        $this->assertSame($expected, $actual->all()->extract('name')->toArray());
    }

    /**
     * Test findRecordsWithCharacters method
     * `characters` option provided, and is only `A` - Get records with character `A`
     *
     * @return void
     * @uses \Avolle\CharacterPagination\Model\Behavior\CharacterBehavior::findRecordsWithCharacters()
     */
    public function testFindRecordsWithCharactersCharactersOptionsIsSingleCharacterA(): void
    {
        $usersTable = new UsersTable();
        $actual = $usersTable->find('recordsWithCharacters', characters: ['A']);

        $expected = [
            'A User Name',
            'A User Name 3',
        ];
        $this->assertSame($expected, $actual->all()->extract('name')->toArray());
    }

    /**
     * Test findRecordsWithCharacters method
     * `characters` option provided, and is only `A` - Get records with character `A`
     *
     * @return void
     * @uses \Avolle\CharacterPagination\Model\Behavior\CharacterBehavior::findRecordsWithCharacters()
     */
    public function testFindRecordsWithCharactersCharactersOptionsIsMultipleCharacters(): void
    {
        $usersTable = new UsersTable();
        $actual = $usersTable->find('recordsWithCharacters', characters: ['A', 'B']);
        $expected = [
            'A User Name',
            'A User Name 3',
            'B User Name 2',
        ];
        $this->assertSame($expected, $actual->all()->extract('name')->toArray());

        $actual = $usersTable->find('recordsWithCharacters', characters: ['B', 'A']);
        $expected = [
            'A User Name',
            'A User Name 3',
            'B User Name 2',
        ];
        $this->assertSame($expected, $actual->all()->extract('name')->toArray());

        $actual = $usersTable->find('recordsWithCharacters', characters: ['B', 'B']);
        $expected = [
            'B User Name 2',
        ];
        $this->assertSame($expected, $actual->all()->extract('name')->toArray());

        $actual = $usersTable->find('recordsWithCharacters', characters: ['B', 'C']);
        $expected = [
            'B User Name 2',
        ];
        $this->assertSame($expected, $actual->all()->extract('name')->toArray());

        $actual = $usersTable->find('recordsWithCharacters', characters: ['J', 'K']);
        $expected = [
            'K User Name 4',
        ];
        $this->assertSame($expected, $actual->all()->extract('name')->toArray());

        $actual = $usersTable->find('recordsWithCharacters', characters: ['C', 'D']);
        $this->assertEmpty($actual->all()->extract('name')->toArray());
    }

    /**
     * Test findRecordsWithCharacters method
     * `field` configuration option is customized
     *
     * @return void
     * @uses \Avolle\CharacterPagination\Model\Behavior\CharacterBehavior::findRecordsWithCharacters()
     */
    public function testFindRecordsWithCharactersDifferentFieldNameConfigured(): void
    {
        $usersTable = new UsersTable();
        $usersTable->getBehavior('Character')->setConfig('field', 'email');
        $actual = $usersTable->find('recordsWithCharacters', characters: ['X']);
        $expected = [
            'A User Name 3',
            'B User Name 2',
        ];
        $this->assertSame($expected, $actual->all()->extract('name')->toArray());
    }
}
