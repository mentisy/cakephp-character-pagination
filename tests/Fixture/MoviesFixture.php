<?php
namespace Avolle\CharacterPagination\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MoviesFixture
 */
class MoviesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'title' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'link' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'release_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
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
                'title' => 'Shawshank Redemption',
                'link' => 'https://imdb.com/shawshank-redemption',
            ],
            [
                'id' => 2,
                'title' => 'The Green Mile',
                'link' => 'https://imdb.com/the-green-mile',
            ],
            [
                'id' => 3,
                'title' => 'Gone in Sixty Seconds',
                'link' => 'https://imdb.com/gone-in-sixty-seconds',
            ],
            [
                'id' => 4,
                'title' => 'American History X',
                'link' => 'https://imdb.com/american-history-x',
            ],
        ];
        parent::init();
    }
}
