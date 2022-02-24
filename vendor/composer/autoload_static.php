<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb3a4e5b0ef7cff3bc195416d063e012b
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Atree\\GetwhiskyMvc\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Atree\\GetwhiskyMvc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb3a4e5b0ef7cff3bc195416d063e012b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb3a4e5b0ef7cff3bc195416d063e012b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb3a4e5b0ef7cff3bc195416d063e012b::$classMap;

        }, null, ClassLoader::class);
    }
}