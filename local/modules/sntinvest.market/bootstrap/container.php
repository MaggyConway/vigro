<?php
$builder = new \DI\ContainerBuilder();

$builder->useAutowiring(false);
$builder->useAnnotations(false);

/**
 * Get dinamic files
 */
$files = array_merge(
    glob(__DIR__ . '/../config/*.php' ?: [])
);

/**
 * Require files
 */
$config = array_map(function ($file) {
    return require $file;
},$files);

/**
 * Get dependencies
 */
$dependencies = array_merge_recursive(...$config);

/**
 * Add dependencies
 */
$builder->addDefinitions($dependencies);

return $builder->build();