<?php

namespace Avolle\CharacterPagination\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MoviesFixture
 */
class MoviesFixture extends TestFixture
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
