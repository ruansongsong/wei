<?php
/**
 * Wei Framework
 *
 * @copyright   Copyright (c) 2008-2016 Twin Huang
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 */

namespace Wei\Validator;

/**
 * Check if the input is decimal
 *
 * @author      Twin Huang <twinhuang@qq.com>
 */
class Decimal extends BaseValidator
{
    protected $invalidMessage = '%name% must be decimal';

    protected $negativeMessage = '%name% must not be decimal';

    /**
     * {@inheritdoc}
     */
    protected function doValidate($input)
    {
        if (is_float($input) || (is_numeric($input) && count(explode('.', $input)) == 2)) {
            return true;
        }

        $this->addError('invalid');
        return false;
    }
}
