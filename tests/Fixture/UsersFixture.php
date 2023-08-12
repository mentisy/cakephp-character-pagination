<?php
namespace Avolle\CharacterPagination\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'name' => ['type' => 'string', 'length' => 40, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'email' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'number' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 70, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'role' => ['type' => 'tinyinteger', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'email' => ['type' => 'unique', 'columns' => ['email'], 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'A User Name',
                'email' => 'some.user@users.com',
                'number' => '+4799999999',
                'password' => '$2y$10$5fTuNphejvCQGth5jTIEFuWzYN646DWsSEXA6VfMitkeLVba4Dzwa', //Lorem ipsum dolor sit amet
                'role' => 0,
            ],
            [
                'id' => 2,
                'name' => 'B User Name 2',
                'email' => 'Xsome.other.user@users.com',
                'number' => '+4798888888',
                'password' => '$2y$10$5fTuNphejvCQGth5jTIEFuWzYN646DWsSEXA6VfMitkeLVba4Dzwa', //Lorem ipsum dolor sit amet
                'role' => 2,
            ],
            [
                'id' => 3,
                'name' => 'A User Name 3',
                'email' => 'Xsome.other.other.user@users.com',
                'number' => '+4797777777',
                'password' => '$2y$10$5fTuNphejvCQGth5jTIEFuWzYN646DWsSEXA6VfMitkeLVba4Dzwa', //Lorem ipsum dolor sit amet
                'role' => 0,
            ],
            [
                'id' => 4,
                'name' => 'K User Name 4',
                'email' => 'Ksome.other.other.other.user@users.com',
                'number' => '+4796666666',
                'password' => '$2y$10$5fTuNphejvCQGth5jTIEFuWzYN646DWsSEXA6VfMitkeLVba4Dzwa', //Lorem ipsum dolor sit amet
                'role' => 1,
            ],
            [
                'id' => 5,
                'name' => 'Å user name',
                'email' => 'Ysome.other.other.other.user@users.com',
                'number' => '+4797777777',
                'password' => '$2y$10$5fTuNphejvCQGth5jTIEFuWzYN646DWsSEXA6VfMitkeLVba4Dzwa', //Lorem ipsum dolor sit amet
                'role' => 0,
            ],
        ];
        parent::init();
    }
}
