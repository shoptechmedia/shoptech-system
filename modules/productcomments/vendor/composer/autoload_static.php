<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite2a33a0ac8261e08698313703cbddb51
{
    public static $classMap = array (
        'ProductCommentsModule\\ProductComment' => __DIR__ . '/../..' . '/classes/ProductComment.php',
        'ProductCommentsModule\\ProductCommentCriterion' => __DIR__ . '/../..' . '/classes/ProductCommentCriterion.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInite2a33a0ac8261e08698313703cbddb51::$classMap;

        }, null, ClassLoader::class);
    }
}
