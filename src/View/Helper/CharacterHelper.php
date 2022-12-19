<?php
declare(strict_types=1);

namespace Avolle\CharacterPagination\View\Helper;

use Cake\View\Helper;

/**
 * Character helper
 *
 * @property \Cake\View\Helper\HtmlHelper $Html
 */
class CharacterHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
        'activeClassName' => 'active',
    ];

    /**
     * Helpers
     *
     * @var string[]
     */
    protected $helpers = [
        'Html',
    ];

    /**
     * Add a link to filter records by character. Will add active class name to current filter.
     * A link for an already filtered character will make the link disable the filter
     *
     * @param string $char Char to paginate by
     * @param array $options Options and HTML attributes
     * @return string Character filter link
     */
    public function link(string $char, array $options = []): string
    {
        $char = strtoupper($char);
        $request = $this->getView()->getRequest();
        $href = [
            'plugin' => $request->getParam('plugin'),
            'controller' => $request->getParam('controller'),
            'action' => $request->getParam('action'),
            '?' => ['characters' => $char, 'page' => null] + $request->getQueryParams(),
        ];
        if ($this->isActiveChar($char)) {
            $options['class'] = ($options['class'] ?? '') . ' ' . $this->getConfig('activeClassName');
            unset($href['?']['characters']);
        }

        return $this->Html->link($char, $href, $options);
    }

    /**
     * Check whether the given $char is the current character being filtered (in query params)
     *
     * @param string $char Char to check for in query params
     * @return bool Whether it is the active character filter
     */
    protected function isActiveChar(string $char): bool
    {
        return $this->getView()->getRequest()->getQuery('characters') === $char;
    }
}
