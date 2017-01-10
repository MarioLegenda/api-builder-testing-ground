<?php

namespace FindingAPI\Core\Listener;

use SDKBuilder\Event\RequestEvent;
use SDKBuilder\Request\RequestParameters;

class PreSendRequestListener
{
    /**
     * @param RequestEvent $event
     */
    public function onPreSendRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        if ($request->getMethod() === 'post') {
            $headers = array(
                'X-EBAY-SOA-REQUEST-DATA-FORMAT : '.$request->getGlobalParameters()->getParameter('response_data_format')->getValue(),
                'Content-Type : text/xml;charset=utf-8',
            );

            $mappedHeaders = RequestParameters::map(array(
                'X-EBAY-SOA-OPERATION-NAME' => 'operation_name',
                'X-EBAY-SOA-SERVICE-VERSION' => 'service_version',
                'X-EBAY-SOA-GLOBAL-ID' => 'global_id',
                'X-EBAY-SOA-SECURITY-APPNAME' => 'security_appname',
            ), $request->getGlobalParameters(), $request->getSpecialParameters());

            $headers = array_merge($headers, $mappedHeaders);

            $client = $request->getClient();

            $client->setHeaders($headers);
            $client->setMethod($request->getMethod());
            $client->setUri($request->getGlobalParameters()->getParameter('ebay_url')->getValue());
        }
    }
}