<?php declare(strict_types=1);

namespace RichCongress\TestFramework\TestConfiguration;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;

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

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // Avoid instantiation
    }

    public static function setCurrentTestConfig(TestConfig $testConfig): void
    {
        self::$currentTestConfig = $testConfig;
    }

    public static function getCurrentTestConfig(): ?TestConfig
    {
        return self::$currentTestConfig;
    }

    public static function has(string $key): bool
    {
        return self::$currentTestConfig && self::$currentTestConfig->has($key);
    }

    public static function get(string $key)
    {
        return self::$currentTestConfig ? self::$currentTestConfig->get($key) : null;
    }
}
