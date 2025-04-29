<?php

/**
 * This file is part of the PropelBundle package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */
namespace Propel\Bundle\PropelBundle\DataFixtures\Dumper;

use Symfony\Component\Yaml\Yaml;

/**
 * YAML fixtures dumper.
 *
 * @author William Durand <william.durand1@gmail.com>
 */
class YamlDataDumper extends AbstractDataDumper
{
    /**
     * {@inheritdoc}
     */
    protected function transformArrayToData($data)
    {
        $processedData = $this->convertNumericStringsToIntegers($data);
        return Yaml::dump(
            $processedData,
            3,
            4,
            Yaml::DUMP_OBJECT | Yaml::DUMP_EXCEPTION_ON_INVALID_TYPE
        );
    }

    private function convertNumericStringsToIntegers(array $data)
    {
        $result = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $result[$key] = $this->convertNumericStringsToIntegers($value);
            } else {
                if (is_string($value) && is_numeric($value) && strpos($value, '.') === false) {
                    $result[$key] = (int)$value;
                } else {
                    $result[$key] = $value;
                }
            }
        }

        return $result;
    }
}
