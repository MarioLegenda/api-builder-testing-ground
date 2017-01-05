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
                'X-EBAY-SOA-SERVICE-NAME' => 'FindingService',
                'X-EBAY-SOA-REQUEST-DATA-FORMAT' => 'XML',
            );

            $mappedHeaders = RequestParameters::map(array(
                'X-EBAY-SOA-OPERATION-NAME' => 'operation_name',
                'X-EBAY-SOA-SERVICE-VERSION' => 'service_version',
                'X-EBAY-SOA-GLOBAL-ID' => 'global_id',
                'X-EBAY-SOA-SECURITY-APPNAME' => 'security_appname',
            ), $request->getGlobalParameters(), $request->getSpecialParameters());

            $headers = array_merge($headers, $mappedHeaders);

            $request->setClient('POST', array(
                'headers' => $headers,
            ));
        }
    }
}