<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInite40f3515bbd0db87fb4a8d7a5e26a50e
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInite40f3515bbd0db87fb4a8d7a5e26a50e', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInite40f3515bbd0db87fb4a8d7a5e26a50e', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInite40f3515bbd0db87fb4a8d7a5e26a50e::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
