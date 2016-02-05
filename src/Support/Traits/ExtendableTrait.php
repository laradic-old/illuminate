<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Laradic\Support\Traits;


use BadMethodCallException;
use Closure;
use Illuminate\Container\Container;
use Sebwite\Support\Str;

trait ExtendableTrait
{
    protected $extensionFunctions = [ ];

    protected $extensionClasses = [ ];

    protected $extensionInstances = [ ];

    public function getContainer()
    {
        return Container::getInstance();
    }

    public function extensions()
    {
        return array_merge(
            array_keys($this->extensionFunctions),
            array_keys($this->extensionClasses)
        );
    }

    public function extendFunction($name, $extension)
    {
        $this->extensionFunctions[ $name ] = $extension;
    }

    public function extendClass($name, $extension)
    {
        $this->extensionClasses[ $name ] = $extension;
    }

    protected function callFunctionExtension($name, $parameters)
    {
        $callback = $this->extensionFunctions[ $name ];

        if ( $callback instanceof Closure )
        {
            return call_user_func_array($callback->bindTo($this, get_class($this)), $parameters);
        }
        elseif ( is_string($callback) )
        {
            if ( Str::contains($callback, '@') )
            {
            }

            return $this->createClassExtension($callback, $parameters);
        }
    }

    protected function createClassExtension($callback, $parameters)
    {
        list($class, $method) = explode('@', $callback);
        $instance = $this->getContainer()->make($class, [
            'parent' => $this
        ]);

        return call_user_func_array([ $instance, $method ], $parameters);
    }

    protected function getClassExtensionInstance($name)
    {
        $extension = $this->extensionClasses[ $name ];

        if ( is_string($extension) && class_exists($extension) )
        {
            if ( !array_key_exists($name, $this->extensionInstances) )
            {
                $this->extensionInstances[ $name ] = $this->getContainer()->make($extension, [
                    'parent' => $this
                ]);
            }

            return $this->extensionInstances[ $name ];
        }
    }

    public function __call($name, array $params = [ ])
    {
        if ( array_key_exists($name, $this->extensionFunctions) )
        {
            return $this->callFunctionExtension($name, $params);
        }
        throw new BadMethodCallException("Method [$name] does not exist.");
    }

    public function __get($name)
    {
        if ( array_key_exists($name, $this->extensionClasses) )
        {
            return $this->getClassExtensionInstance($name);
        }
    }
}
