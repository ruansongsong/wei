<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget\Validator;

/**
 * @package     Widget
 * @author      Twin Huang <twinh@yahoo.cn>
 */
class Required extends AbstractValidator
{
    protected $message = '%name% is required';
    
    protected $required = true;
    
    public function __invoke($input, $required = null)
    {
        is_bool($required) && $this->required = $required;
        
        return !$this->required || $input;
    }
}
