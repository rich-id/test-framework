<?php declare(strict_types=1);

namespace RichCongress\TestFramework\Tests\TestConfiguration;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestFramework\TestConfiguration\TestConfigurationExtractor;
use RichCongress\TestFramework\Tests\Resources\DummyTestCaseWithTestConfig;

/**
 * Class WithTestCaseConfigTest
 *
 * @package    RichCongress\TestFramework\Tests\TestConfiguration
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig
 * @covers \RichCongress\TestFramework\TestConfiguration\TestConfigurationExtractor
 */
final class WithTestCaseConfigTest extends DummyTestCaseWithTestConfig
{
    /**
     * @TestConfig("test_method_configuration")
     */
    public function testWithTestConfig(): void
    {
        $testConfig = TestConfigurationExtractor::getRecursively(__CLASS__, __FUNCTION__);

        self::assertInstanceOf(TestConfig::class, $testConfig);
        self::assertTrue($testConfig->has('test_method_configuration'));
        self::assertFalse($testConfig->has('test_case_configuration'));
        self::assertFalse($testConfig->has('test_case_configuration_2'));
    }

    public function testWithoutTestConfig(): void
    {
        $testConfig = TestConfigurationExtractor::getRecursively(__CLASS__, __FUNCTION__);

        self::assertInstanceOf(TestConfig::class, $testConfig);
        self::assertFalse($testConfig->has('test_method_configuration'));

        self::assertTrue($testConfig->has('test_case_configuration'));
        self::assertEquals('this is a test', $testConfig->get('test_case_configuration'));
        self::assertTrue($testConfig->has('test_case_configuration_2'));
        self::assertEquals(10, $testConfig->get('test_case_configuration_2'));
    }
}
