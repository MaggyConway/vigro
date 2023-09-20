<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration;

use Psr\Container\ContainerInterface;

use Exception;

/**
 * Description of Container
 *
 * @author dimay
 */
final class Container implements ContainerInterface
{
    private static $instance = null;
    
    private $app;

    /**
     * gets the instance via lazy initialization (created on first usage)
     */
    public static function getInstance(string $path = null): Container
    {
        if (self::$instance === null) {
            self::$instance = new self($path);
        }

        return self::$instance;
    }

    /**
     * is not allowed to call from outside to prevent from creating multiple instances,
     * to use the singleton, you have to obtain the instance from Singleton::getInstance() instead
     */
    private function __construct(string $path)
    {
        if (file_exists($path))
        {
            $app = require $path;
            
            if ($app instanceof ContainerInterface)
            {
                $this->app = $app;
            }
            else
            {
                throw new Exception("no instanceof ContainerInterface");
            }
        }
        else
        {
            throw new Exception("no path");
        }
    }

    /**
     * prevent the instance from being cloned (which would create a second instance of it)
     */
    private function __clone()
    {
    }

    /**
     * prevent from being unserialized (which would create a second instance of it)
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }
    
    public function get($id)
    {
        return $this->app->get($id);
    }
    
    public function has($id) 
    {      
        return $this->app->has($id);
    }
    
    public static function callMethod($classData) 
    {     
        $container = self::getInstance();

        $class = $container->get($classData[0]);

        $method = $classData[1];

        $props = $classData[2];
        
        return $class->$method($props);
    }
    
    public static function getClassData($namespace, $method, $params) 
    {     
        return array_merge(
            explode('::', str_replace($namespace.'\\', '', $method)),
            [$params]
        );
    }
}
