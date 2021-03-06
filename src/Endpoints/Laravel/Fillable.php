<?php

namespace PHPFileManipulator\Endpoints\Laravel;

use PHPFileManipulator\Endpoints\ArrayPropertyResource;

class Fillable extends ArrayPropertyResource
{
    public static function aliases() 
    {
        return [
            'fillable', 'fillables'
        ];
    }

    public function get()
    {
        return $this->canUseReflection() ? $this->getWithReflection('fillable') : $this->getWithParser('fillable');
    }

    public function set($values)
    {
        return $this->setItems('fillable', $values);
    }

    public function add($values)
    {
        return $this->setItems(
            'fillable',
            collect($this->get())->concat($values)->toArray()
        );
    }    
}