<?php

namespace Lib;

class Psr4AutoloaderClass
{
    private $prefixes = array();

    // Enregistre un préfixe de namespace et son répertoire de base
    public function addNamespace($prefix, $base_dir)
    {
        $prefix = rtrim($prefix, '\\') . '\\';
        if (!isset($this->prefixes[$prefix])) {
            $this->prefixes[$prefix] = array();
        }
        $this->prefixes[$prefix][] = rtrim($base_dir, DIRECTORY_SEPARATOR) . '/';
    }

    // Enregistre l'autoloader avec spl_autoload_register
    public function register()
    {
        spl_autoload_register(array($this, 'autoload'));
    }

    // Charge une classe en fonction de son nom
    public function autoload($class)
    {
        $prefix = $class;
        while (false !== $pos = strrpos($prefix, '\\')) {
            $prefix = substr($class, 0, $pos + 1);
            $relative_class = substr($class, $pos + 1);
            $mapped_file = $this->loadMappedFile($prefix, $relative_class);
            if ($mapped_file) {
                return $mapped_file;
            }
            $prefix = rtrim($prefix, '\\');
        }
        return false;
    }

    // Charge un fichier de classe correspondant à un namespace donné
    public function loadMappedFile($prefix, $relative_class)
    {
        if (isset($this->prefixes[$prefix])) {
            foreach ($this->prefixes[$prefix] as $base_dir) {
                $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
                if ($this->requireFile($file)) {
                    return $file;
                }
            }
        }
        return false;
    }

    // Inclut le fichier si celui-ci existe
    public function requireFile($file)
    {
        if (file_exists($file)) {
            require $file;
            return true;
        }
        return false;
    }
}
