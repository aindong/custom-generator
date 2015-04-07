<?php
namespace Aindong\CustomGenerator\Generators;

use Illuminate\Support\Pluralizer;

class ControllerGenerator extends Generator {
    protected $template;

    public function getTemplate($name, $namespace)
    {
        $path = __DIR__.'/templates/controller.txt';
        $this->template = $this->file->get($path);
        $name = strtolower(Pluralizer::plural(
            str_ireplace('Controller', '', $name)
        ));

        // Prepare strings to be placed on the template
        $singular       = Pluralizer::singular(ucfirst($name));
        $singularLower  = strtolower($singular);
        $plural         = Pluralizer::plural(ucfirst($name));

        // Replace
        $this->template = str_replace('{{namespace}}', $namespace, $this->template);
        $this->template = str_replace('{{singular}}', $singular, $this->template);
        $this->template = str_replace('{{plural}}', $plural, $this->template);
        $this->template = str_replace('{{singularLower}}', $singularLower, $this->template);

        return $this->template;
    }
}