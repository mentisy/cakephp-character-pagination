<?php
namespace Avolle\CharacterPagination\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
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
            ],
            [
                'id' => 2,
                'name' => 'B User Name 2',
                'email' => 'Xsome.other.user@users.com',
            ],
            [
                'id' => 3,
                'name' => 'A User Name 3',
                'email' => 'Xsome.other.other.user@users.com',
            ],
            [
                'id' => 4,
                'name' => 'K User Name 4',
                'email' => 'Ksome.other.other.other.user@users.com',
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
