<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 30.08.14
 * Time: 13:09
 */

namespace Cundd\PersistentObjectStore\Formatter;

use Cundd\PersistentObjectStore\Domain\Model\DocumentInterface;


/**
 * Class JsonFormatter
 *
 * @package Cundd\PersistentObjectStore\Formatter
 */
class JsonFormatter extends AbstractFormatter
{
    /**
     * @var \Cundd\PersistentObjectStore\Serializer\DataInstanceSerializer
     * @Inject
     */
    protected $serializer;

    /**
     * Formats the given input model(s)
     *
     * @param DocumentInterface|DocumentInterface[] $inputModel
     * @return string
     */
    public function format($inputModel)
    {
        return $this->serializer->serialize($this->prepareData($inputModel));
    }

    /**
     * Returns the content suffix for the formatter
     *
     * @return string
     */
    public function getContentSuffix()
    {
        return 'json';
    }

} 