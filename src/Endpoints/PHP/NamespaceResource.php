<?php

namespace PHPFileManipulator\Endpoints\PHP;

use PHPFileManipulator\Endpoints\ResourceEndpointProvider;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\NodeFinder;
use PhpParser\BuilderFactory;

class NamespaceResource extends ResourceEndpointProvider
{
    public static function aliases()
    {
        return [
            'namespace'
        ];
    }

    public function get()
    {
        $namespace = (new NodeFinder)->findFirstInstanceOf($this->ast(), Namespace_::class);
        return $namespace ? implode('\\', $namespace->name->parts) : null;
    }

    public function set($newNamespace)
    {
        $namespace = (new NodeFinder)->findFirstInstanceOf($this->ast(), Namespace_::class);
        
        if($namespace) {
            // Modifying existing namespace
            $namespace->name->parts = explode("\\", $newNamespace);
        } else {
            // Add a namespace
            array_unshift(
                $this->file->ast,
                (new BuilderFactory)->namespace($newNamespace)->getNode()
            );
        }
        
        return $this->file;
    }

    public function remove($_ = null)
    {
        $namespace = (new NodeFinder)->findFirstInstanceOf($this->ast(), Namespace_::class);
        
        if($namespace) {
            $this->file->ast = $namespace->stmts;
        }

        return $this->file;
    }    
}