<?php declare(strict_types=1);

namespace RichCongress\TestFramework\TestConfiguration;

use RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig;

/**
 * Class TestConfigurationExtractor
 *
 * @package    RichCongress\TestFramework\TestConfiguration
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
final class TestConfigurationExtractor
{
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

    public static function getFromReflection(\ReflectionMethod|\ReflectionClass $reflection): ?TestConfig
    {
        return ($reflection->getAttributes(TestConfig::class)[0] ?? null)?->newInstance();
    }
}
