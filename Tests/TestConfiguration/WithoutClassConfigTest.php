<?php declare(strict_types=1);

namespace RichCongress\TestFramework\Tests\TestConfiguration;

use PHPUnit\Framework\TestCase;
use RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig;
use RichCongress\TestFramework\TestConfiguration\TestConfigurationExtractor;

/**
 * Class WithoutClassConfigTest
 *
 * @package    RichCongress\TestFramework\Tests\TestConfiguration
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig
 * @covers \RichCongress\TestFramework\TestConfiguration\TestConfigurationExtractor
 */
final class WithoutClassConfigTest extends TestCase
{
    #[TestConfig('test_method_configuration')]
    public function testWithTestConfig(): void
    {
        $testConfig = TestConfigurationExtractor::getRecursively(__CLASS__, __FUNCTION__);
        self::assertInstanceOf(TestConfig::class, $testConfig);
        self::assertTrue($testConfig->has('test_method_configuration'));
        self::assertFalse($testConfig->has('test_class_configuration'));
    }

    #[TestConfig('test_attribute_method_configuration')]
    public function testWithTestConfigAttribute(): void
    {
        $testConfig = TestConfigurationExtractor::getRecursively(__CLASS__, __FUNCTION__);
        self::assertInstanceOf(TestConfig::class, $testConfig);
        self::assertTrue($testConfig->has('test_attribute_method_configuration'));
        self::assertFalse($testConfig->has('test_class_configuration'));
    }

    public function testWithoutTestConfig(): void
    {
        $testConfig = TestConfigurationExtractor::getRecursively(__CLASS__, __FUNCTION__);
        self::assertNull($testConfig);
    }
}
