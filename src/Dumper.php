<?php
/**
 *
 * This file is part of AutoRoute for PHP.
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 */
declare(strict_types=1);

namespace AutoRoute;

use ReflectionClass;

class Dumper
{
    protected $actions;

    public function __construct(Actions $actions)
    {
        $this->actions = $actions;
    }

    public function dumpRoutes() : array
    {
        $files = $this->getFiles();
        $classes = $this->getClassesFromFiles($files);
        $urls = $this->getUrlsFromClasses($classes);
        return $urls;
    }

    protected function getFiles() : array
    {
        return $this->glob_recursive($this->actions->getDirectory().\DIRECTORY_SEPARATOR. '*.php');
    }

    protected function glob_recursive($pattern, $flags = 0)
    {
        $files = \glob($pattern, $flags);
        foreach (\glob(\dirname($pattern).\DIRECTORY_SEPARATOR.'*', \GLOB_ONLYDIR | \GLOB_NOSORT) as $dir) {
            $files = \array_merge($files, $this->glob_recursive($dir .\DIRECTORY_SEPARATOR. \basename($pattern), $flags));
        }

        return $files;
    }

    protected function getClassesFromFiles(array $files) : array
    {
        $classes = [];

        foreach ($files as $file) {
            $class = $this->actions->fileToClass($file);
            if ($class !== null) {
                $classes[] = $class;
            }
        }

        sort($classes);
        return $classes;
    }

    protected function getUrlsFromClasses(array $classes) : array
    {
        $urls = [];
        foreach ($classes as $class) {
            list ($verb, $path, $argc) = $this->actions->dump($class);
            $urls[$path][$verb] = $class;
        }
        ksort($urls);
        return $urls;
    }
}
