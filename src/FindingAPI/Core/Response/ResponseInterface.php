<?php

namespace FindingAPI\Core\Response;

use FindingAPI\Core\ResponseParser\ResponseItem\RootItem;

interface ResponseInterface
{
    /**
     * @return RootItem
     */
    public function getRoot() : RootItem;
    /**
     * @param null $default
     * @return mixed
     */
    public function getAspectHistogramContainer($default = null);
    /**
     * @param null $default
     * @return mixed
     */
    public function getSearchResults($default = null);
    /**
     * @param null $default
     * @return mixed
     */
    public function getConditionHistogramContainer($default = null);
    /**
     * @param null $default
     * @return mixed
     */
    public function getPaginationOutput($default = null);
    /**
     * @param null $default
     * @return mixed
     */
    public function getCategoryHistogramContainer($default = null);
    /**
     * @param null $default
     * @return mixed
     */
    public function getErrors($default = null);
    /**
     * @return bool
     */
    public function isErrorResponse() : bool;
    /**
     * @return string
     */
    public function getRawResponse() : string;
}