<?php

namespace FindingAPI\Core\Response;

use FindingAPI\EbayApiInterface;

class EbayOfflineMode
{
    /**
     * @var EbayApiInterface $ebayApiObject
     */
    private $ebayApiObject;
    /**
     * @var resource $requestHandle
     */
    private $requestHandle;
    /**
     * EbayOfflineMode constructor.
     * @param EbayApiInterface $ebayApi
     */
    public function __construct(EbayApiInterface $ebayApi)
    {
        $this->ebayApiObject = $ebayApi;

        $this->requestHandle = fopen('requests.csv', 'a+');
    }

    public function isResponseStored(string $request) : bool
    {
        
    }

    public function addResponse(string $request, string $response) : EbayOfflineMode
    {
        $requests = file(__DIR__.'/requests.csv');
        $lastLine = array_pop($requests);

        if ($lastLine === false) {
            fputcsv($this->requestHandle, array(1, $request), ';');
            $responseFile = __DIR__.'/responses/'.(int) $lastLine[0]++.'.txt';
            fclose(fopen($responseFile, 'a+'));
            
            file_put_contents($responseFile, $response);

            return $this;
        }
        
        fputcsv($this->requestHandle, array(
            $lastLine[0],
            $request
        ));

        $responseFile = __DIR__.'/responses/'.(int) $lastLine[0]++.'.txt';
        fclose(fopen($responseFile, 'a+'));
        
        file_put_contents($responseFile, $response);

        return $this;
    }

    public function findResponse(string $request)
    {

    }
}