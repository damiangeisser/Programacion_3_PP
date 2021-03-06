<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1f7b818598a348e4bc2ba9b1afb24c6f
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1f7b818598a348e4bc2ba9b1afb24c6f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1f7b818598a348e4bc2ba9b1afb24c6f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
