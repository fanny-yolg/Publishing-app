<?php 

namespace App\Helpers;

class JsonSerializer extends \SimpleXmlElement implements \JsonSerializable
{
    const ATTRIBUTE_INDEX = "@attr";
    const CONTENT_NAME = "_text";

    /**
     * SimpleXMLElement JSON serialization
     *
     * @return array
     *
     * @link http://php.net/JsonSerializable.jsonSerialize
     * @see JsonSerializable::jsonSerialize
     * @see https://stackoverflow.com/a/31276221/36175
     */
    function jsonSerialize()
    {
        $array = [];

        if ($this->count()) {
            /**
             * @var string $tag
             * @var JsonSerializer $child
             */

            // serialize children if there are children
            foreach ($this as $tag => $child) {
                $temp       = $child->jsonSerialize();
                $attributes = [];

                foreach ($child->attributes() as $name => $value) {
                    $attributes["$name"] = (string) $value;
                }

                $array[$tag][] = array_merge($temp, [self::ATTRIBUTE_INDEX => $attributes]);
            }
        } else {
            // serialize attributes and text for a leaf-elements
            $temp = (string) $this;

            // if only contains empty string, it is actually an empty element
            if (trim($temp) !== "") {
                $array[self::CONTENT_NAME] = $temp;
            }
        }

        return $array;
    }
}