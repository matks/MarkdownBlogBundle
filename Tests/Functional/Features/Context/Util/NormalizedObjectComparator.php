<?php

namespace Matks\MarkdownBlogBundle\Tests\Functional\Features\Context\Util;

use Matks\MarkdownBlogBundle\Tests\Functional\Features\Context\Util\PrimitiveUtils;
use Exception;

class NormalizedObjectComparator
{
    /**
     * @param array $expectedData
     * @param array $realData
     *
     * @throws Exception
     */
    public static function assertEqual(array $expectedData, array $realData)
    {
        foreach ($expectedData as $key => $expectedElement) {

            if (false === array_key_exists($key, $realData)) {
                $availableKeys = array_keys($realData);
                throw new Exception("Expected data $key but no such data in object ; available data is " . implode(',', $availableKeys));
            }

            $realElement     = $realData[$key];
            $realElementType = gettype($realElement);

            $isADateTime = (($realElementType === 'object') && (get_class($realElement) === "DateTime"));
            if ($isADateTime) {
                $realElementType = 'datetime';
            }

            $castedExpectedElement = PrimitiveUtils::castElementInType($expectedElement, $realElementType);

            if (false === PrimitiveUtils::isIdentical($castedExpectedElement, $realElement)) {
                if ($realElementType === 'boolean') {
                    $realAsString     = ($realElement) ? 'true' : 'false';
                    $expectedAsString = ($castedExpectedElement) ? 'true' : 'false';

                    throw new Exception("Object $key is " . $realAsString . ' / expected ' . $expectedAsString);
                } elseif ($realElementType === 'array') {
                    sort($realElement);
                    sort($castedExpectedElement);

                    $realAsString     = implode('; ', $realElement);
                    $expectedAsString = implode('; ', $castedExpectedElement);

                    if ('' === $realAsString) {
                        $realAsString = 'empty';
                    }

                    if ('' === $expectedAsString) {
                        $expectedAsString = 'empty';
                    }

                    throw new Exception("Object $key is $realAsString / expected $expectedAsString");
                } elseif ($realElementType === 'datetime') {
                    $realAsString     = $realElement->format('Y/m/d H:i:s');
                    $expectedAsString = $castedExpectedElement->format('Y/m/d H:i:s');

                    throw new Exception("Object $key is $realAsString / expected $expectedAsString");
                } else {
                    throw new Exception("Object $key is " . $realElement . ' / expected ' . $castedExpectedElement);
                }
            }
        }
    }
}
