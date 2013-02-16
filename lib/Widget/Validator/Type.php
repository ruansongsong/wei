<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget\Validator;

use Widget\Exception;

/**
 * @package     Widget
 * @author      Twin Huang <twinh@yahoo.cn>
 * @method string t(string $message, array $parameters) Translates a message
 * @property \Widget\T $t The translator widget
 */
class Type extends AbstractValidator
{
    protected $typeMessage = '%name% must be %typeName%';
    
    protected $type;

    protected $typeName;
    
    public function __invoke($input, $type = null)
    {
        $type && $this->type = $type;
        
        if (function_exists($fn = 'is_' . $this->type)) {
            $result = $fn($input);
        } elseif (function_exists($fn = 'ctype_' . $this->type)) {
            $result = $fn($input);
        } else {
            $result = $input instanceof $this->type;
        }
        
        if (!$result) {
            $this->addError('type');
        }
        
        return $result;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getMessages()
    {
        $this->loadTranslationMessages();
        
        $this->typeName = $this->t($this->type);
        
        return parent::getMessages();
    }
}
