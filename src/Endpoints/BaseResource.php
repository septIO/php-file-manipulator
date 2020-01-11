<?php

namespace PHPFileManipulator\Endpoints;

use PHPFileManipulator\PHPFile;
use PHPFileManipulator\Support\Endpoint;
use BadMethodCallException;
use Illuminate\Support\Str;

abstract class BaseResource extends Endpoint
{
    const NOT_IMPLEMENTED = 'Method not implemented for this resource';

    public function getResourceName()
    {
        return Str::replaceLast(
            'Resource', '', class_basename(static::class)
        );
    }

    public function __call($method, $args)
    {
        $resource = $this->getResourceName();

        // exact matches are getters/setters
        if(preg_match("/^$resource\$/i", $method)) {
            return $args ? $this->set(...$args) : $this->get();
        }
        // adders
        if(preg_match("/^add$resource\$/i", $method)) {
            return $this->add(...$args);
        }
        // removers
        if(preg_match("/^remove$resource\$/i", $method)) {
            return $this->remove(...$args);
        }        

        throw new BadMethodCallException("Resource " . static::class . " could not resolve method " . $method);
    }

    public function get()
    {
        throw new BadMethodCallException($this::NOT_IMPLEMENTED);
    }

    public function set($args)
    {
        throw new BadMethodCallException($this::NOT_IMPLEMENTED);
    }
    
    public function add($args)
    {
        throw new BadMethodCallException($this::NOT_IMPLEMENTED);
    }
    
    public function remove($args = null)
    {
        throw new BadMethodCallException($this::NOT_IMPLEMENTED);
    }
}