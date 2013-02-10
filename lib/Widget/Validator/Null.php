<?php
/**
 * Widget Framework
 *
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget\Validator;

/**
 * @package     Widget
 * @author      Twin Huang <twinh@yahoo.cn>
 */
class Null extends AbstractValidator
{
    protected $message = '%name% must be null';
    
    public function __invoke($input)
    {
        return is_null($input);
    }
}
