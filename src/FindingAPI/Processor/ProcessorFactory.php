<?php
/**
 * Created by PhpStorm.
 * User: marioskrlec
 * Date: 09/09/16
 * Time: 23:11
 */

namespace FindingAPI\Processor;


use FindingAPI\Core\Request;

class ProcessorFactory
{
    /**
     * @param Request $request
     * @return UrlProcessor
     */
    public static function getProcessor(Request $request)
    {
        $method = $request->getParameters()->getParameter('method');

        if ($method === 'get') {
            return new UrlProcessor($request);
        }
    }
}