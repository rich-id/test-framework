<?php declare(strict_types=1);

namespace RichCongress\TestFramework\TestConfiguration;

use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Class TestConfigurationExtractor
 *
 * @package    RichCongress\TestFramework\TestConfiguration
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
final class TestConfigurationExtractor
{
    /** @var AnnotationReader */
    private static $annotationReader;

    public static function get(string $class, string $method): ?TestConfig
    {
        $reflectionClass = new \ReflectionClass($class);

        try {
            $reflectionMethod = new \ReflectionMethod($class, $method);

            return self::getFromReflection($reflectionMethod) ?? self::getFromReflection($reflectionClass);
        } catch (\ReflectionException $e) {
            return self::getFromReflection($reflectionClass);
        }
    }

    public static function getRecursively(string $class, string $method): ?TestConfig
    {
        $config = static::get($class, $method);

        if ($config !== null) {
            return $config;
        }

        $reflectionClass = new \ReflectionClass($class);
        $parentClass = $reflectionClass->getParentClass();

        return $parentClass instanceof \ReflectionClass
            ? static::getRecursively($parentClass->getName(), $method)
            : null;
    }

    public static function getFromReflection(\Reflector $reflection): ?TestConfig
    {
        $annotation = null;

        if ($reflection instanceof \ReflectionClass) {
            /** @var TestConfig|null $annotation */
            $annotation = self::getAnnotationReader()->getClassAnnotation($reflection, TestConfig::class);
        }

        if ($reflection instanceof \ReflectionMethod) {
            /** @var TestConfig|null $annotation */
            $annotation = self::getAnnotationReader()->getMethodAnnotation($reflection, TestConfig::class);
        }

        return $annotation;
    }

    private static function getAnnotationReader(): AnnotationReader
    {
        if (self::$annotationReader === null) {
            self::$annotationReader = new AnnotationReader();
        }

        return self::$annotationReader;
    }
}
