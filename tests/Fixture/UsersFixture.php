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
        ];
        parent::init();
    }
}
