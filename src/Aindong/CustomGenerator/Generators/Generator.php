<?php
namespace Aindong\CustomGenerator\Generators;

use Illuminate\Filesystem\Filesystem as File;

abstract class Generator {
    /**
     * @var
     */
    protected $path;

    /**
     * @var File
     */
    protected $file;

    /**
     * @var
     */
    protected $name;

    /**
     * Constructor
     *
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Make
     * Make/Generate the file
     *
     * @param $path
     * @param $template
     * @return bool
     */
    public function make($path, $namespace)
    {
        $this->name = basename($path, '.php');
        $this->path = $this->getPath($path);
        $template = $this->getTemplate($this->name, $namespace);

        if (! $this->file->exists($this->path)) {
            return $this->file->put($this->path, $template) !== false;
        }

        return false;
    }

    /**
     * getPath
     * Get the path
     *
     * @param $path
     * @return mixed
     */
    protected function getPath($path)
    {
        // By default, we won't do anything, but
        // it can be overridden from a child class
        return $path;
    }

    /**
     * getTemplate
     * Contract for child classes
     *
     * @param $template
     * @param $name
     * @return mixed
     */
    abstract protected function getTemplate($name, $namespace);
}