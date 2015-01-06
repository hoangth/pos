<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 10.10.14
 * Time: 14:49
 */

namespace Cundd\PersistentObjectStore\Server\ValueObject;

use Cundd\PersistentObjectStore\Immutable;
use Cundd\PersistentObjectStore\Utility\GeneralUtility;
use React\Http\Request;


/**
 * Object that holds information about a parsed request
 *
 * @package Cundd\PersistentObjectStore\Server\ValueObject
 */
class RequestInfo implements Immutable
{
    /**
     * Identifier for the database
     *
     * @var string
     */
    protected $databaseIdentifier = '';

    /**
     * Identifier for the Document instance
     *
     * @var string
     */
    protected $dataIdentifier = '';

    /**
     * Current request method
     *
     * @var string
     */
    protected $method;

    /**
     * Original request
     *
     * @var Request
     */
    protected $request;

    /**
     * A special handler action that is implemented in the handler
     *
     * @var string
     */
    protected $specialHandlerAction;

    /**
     * Special controller class name
     *
     * @var string
     */
    protected $controllerClass;

    /**
     * Create a new RequestInfo object
     *
     * @param Request $request
     * @param string  $dataIdentifier
     * @param string  $databaseIdentifier
     * @param string  $method
     * @param string  $specialHandlerAction
     * @param string  $controllerClass
     */
    public function __construct(
        $request,
        $dataIdentifier,
        $databaseIdentifier,
        $method,
        $specialHandlerAction = null,
        $controllerClass = null
    ) {
        if ($method) {
            GeneralUtility::assertRequestMethod($method);
        }
        if ($dataIdentifier) {
            GeneralUtility::assertDataIdentifier($dataIdentifier);
        }
        if ($databaseIdentifier) {
            GeneralUtility::assertDatabaseIdentifier($databaseIdentifier);
        }
        $this->method               = $method;
        $this->dataIdentifier       = $dataIdentifier;
        $this->databaseIdentifier   = $databaseIdentifier;
        $this->specialHandlerAction = $specialHandlerAction ?: null;
        $this->request              = $request;
        $this->controllerClass = $controllerClass ?: null;
    }

    /**
     * Returns the original request
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Returns the identifier for the Document instance
     *
     * @return string
     */
    public function getDataIdentifier()
    {
        return $this->dataIdentifier;
    }

    /**
     * Return the identifier for the database
     *
     * @return string
     */
    public function getDatabaseIdentifier()
    {
        return $this->databaseIdentifier;
    }

    /**
     * Returns the request method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Returns the special handler action
     *
     * @return string
     */
    public function getSpecialHandlerAction()
    {
        return $this->specialHandlerAction;
    }

    /**
     * Returns the special handler action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->getSpecialHandlerAction();
    }

    /**
     * Returns the special controller class name
     *
     * @return string
     */
    public function getControllerClass()
    {
        return $this->controllerClass;
    }

    /**
     * Returns if the request is a write request
     *
     * @return bool
     */
    public function isWriteRequest()
    {
        return !$this->isReadRequest();
    }

    /**
     * Returns if the request is a read request
     *
     * @return bool
     */
    public function isReadRequest()
    {
        return $this->method === 'GET' || $this->method === 'HEAD';
    }


}