<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit92a0aff011ddada70ee1bd03a5304712
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'AlanBlair\\AT_FW_Import\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'AlanBlair\\AT_FW_Import\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/AlanBlair/AT_FW_Import',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit92a0aff011ddada70ee1bd03a5304712::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit92a0aff011ddada70ee1bd03a5304712::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit92a0aff011ddada70ee1bd03a5304712::$classMap;

        }, null, ClassLoader::class);
    }
}
