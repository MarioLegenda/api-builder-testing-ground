<?php
/**
 * Created by PhpStorm.
 * User: marioskrlec
 * Date: 05/10/16
 * Time: 16:38
 */

namespace FindingAPI\Processor\Get;


use FindingAPI\Core\ItemFilter\ItemFilterStorage;
use FindingAPI\Processor\AbstractProcessor;
use FindingAPI\Processor\ProcessorInterface;
use FindingAPI\Core\Request;

class GetItemFiltersProcessor extends AbstractProcessor implements ProcessorInterface
{
    /**
     * @var string $processed
     */
    private $processed = '';
    /**
     * @var ItemFilterStorage $itemFilterStorage
     */
    private $itemFilterStorage;

    public function __construct(Request $request, ItemFilterStorage $itemFilterStorage)
    {
        parent::__construct($request);

        $this->itemFilterStorage = $itemFilterStorage;
    }

    /**
     * @return string
     * @throws \FindingAPI\Core\Exception\RequestException
     */
    public function process() : ProcessorInterface
    {
        return $this;
    }
    /**
     * @return string
     */
    public function getProcessed() : string
    {
        return $this->processed;
    }
}