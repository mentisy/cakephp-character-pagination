<?php
declare(strict_types=1);

namespace Avolle\CharacterPagination\Controller\Component;

use Avolle\CharacterPagination\Traits\RepositoryTrait;
use Cake\Controller\Component;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\EventDispatcherTrait;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\Table;
use Cake\View\CellTrait;

/**
 * Character component
 */
class CharacterComponent extends Component
{
    use CellTrait;
    use EventDispatcherTrait;
    use RepositoryTrait;

    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected array $_defaultConfig = [];

    /**
     * Components to use in this Component
     *
     * @var array
     */
    protected array $components = [
        'Paginator',
    ];

    /**
     * Server Request
     *
     * @var \Cake\Http\ServerRequest
     */
    protected ServerRequest $request;

    /**
     * Response
     *
     * @var \Cake\Http\Response
     */
    protected Response $response;

    /**
     * Paginate the results after filtering the records that start with the requested character.
     *
     * @param \Cake\ORM\Table|\Cake\ORM\Query $object Object to filter and paginate
     * @param array $settings Pagination settings
     * @return \Cake\Datasource\ResultSetInterface
     * @throws \Exception
     */
    public function paginate($object, $settings = []): ResultSetInterface
    {
        $this->determineRepository($object);
        if (!$this->repository->hasBehavior('Character')) {
            $this->repository->addBehavior('Avolle/CharacterPagination.Character');
        }
        $this->setRequestResponse();
        $this->createCell($this->repository);

        $requestCharacters = $this->getRequestCharacters();
        if (!empty($requestCharacters)) {
            $this->query = $this->query->find('recordsWithCharacters', ['characters' => $requestCharacters]);
        }

        return $this->getController()->paginate($this->query, $settings);
    }

    /**
     * Set request and response objects to component
     *
     * @return void
     */
    protected function setRequestResponse(): void
    {
        $controller = $this->getController();
        $this->request = $controller->getRequest();
        $this->response = $controller->getResponse();
    }

    /**
     * Create a Character cell
     *
     * @param \Cake\ORM\Table|\Cake\ORM\Query $object Table or Query instance passed to cell
     * @return void
     * @uses \Avolle\CharacterPagination\View\Cell\CharacterCell
     */
    protected function createCell($object): void
    {
        $characterCell = $this->cell('Avolle/CharacterPagination.Character', [$object]);
        $this->getController()->viewBuilder()->setVar('characterCell', $characterCell);
    }

    /**
     * Get the `characters` request query argument
     *
     * @return array
     */
    protected function getRequestCharacters(): array
    {
        return (array)$this->getController()->getRequest()->getQuery('characters');
    }
}
