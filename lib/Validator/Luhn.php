<?php
/**
 * Wei Framework
 *
 * @copyright   Copyright (c) 2008-2016 Twin Huang
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 */

namespace Wei\Validator;

/**
 * Check if the input is valid by the Luhn algorithm
 *
 * @author      Twin Huang <twinhuang@qq.com>
 */
class Luhn extends BaseValidator
{
    protected $invalidMessage = '%name% is not a valid number';

    /**
     * {@inheritdoc}
     */
    protected function doValidate($input)
    {
        if (!$this->isString($input)) {
            $this->addError('notString');
            return false;
        }

        $checksum = $this->getChecksum(substr($input, 0, -1));
        if ($checksum != substr($input, -1)) {
            return false;
        }

        return true;
    }

    /**
     * Return the checksum char of luhn algorithm
     *
     * @param string $string
     * @return string
     */
    protected function getChecksum($string)
    {
        $checksum = '';
        foreach (str_split(strrev($string)) as $i => $d) {
            $checksum .= ($i % 2 === 0) ? ($d * 2) : $d;
        }
        return (10 - array_sum(str_split($checksum)) % 10) % 10;
    }
}
