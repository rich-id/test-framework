<?php declare(strict_types=1);

namespace RichCongress\TestFramework\TestConfiguration;

use PHPUnit\Event\Code\Test;
use PHPUnit\Event\Code\TestMethod;
use PHPUnit\Event\Test\AfterTestMethodFinished;
use RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig;

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

    public static function registerTestConfig(Test $test): void
    {
        if (!$test instanceof TestMethod) {
            throw new \RuntimeException("test-framework only supports tests in class extending phpunit's TestCase. Other test kinds such as phpt are not supported yet.");
        }

        $testConfig = TestConfigurationExtractor::getRecursively($test->className(), $test->methodName())
            ?? new TestConfig();

        TestConfiguration::setCurrentTestConfig($testConfig);
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
