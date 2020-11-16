<?php declare(strict_types=1);

namespace RichCongress\TestFramework\TestConfiguration;

/**
 * Class TestConfiguration
 *
 * @package    RichCongress\TestFramework\TestConfiguration
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
final class TestConfiguration
{
    /** @var TestConfig */
    private static $currentTestConfig;

    private function __construct()
    {
        // Avoid instantiation
    }

    public static function setCurrentTestConfig(TestConfig $testConfig): void
    {
        self::$currentTestConfig = $testConfig;
    }

    public static function has(string $key): bool
    {
        return self::$currentTestConfig->has($key);
    }

    public static function get(string $key)
    {
        return self::$currentTestConfig->get($key);
    }
}
