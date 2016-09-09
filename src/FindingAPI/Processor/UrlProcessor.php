<?php
/**
 * Created by PhpStorm.
 * User: marioskrlec
 * Date: 09/09/16
 * Time: 23:12
 */

namespace FindingAPI\Processor;


use FindingAPI\Core\Request;

class UrlProcessor implements ProcessorInterface
{
    /**
     * @var Request $request
     */
    private $request;
    /**
     * UrlProcessor constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * @return string
     */
    public function process() : string
    {
        
    }
}