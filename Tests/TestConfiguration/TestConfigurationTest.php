<?php declare(strict_types=1);

namespace RichCongress\TestFramework\Tests\TestConfiguration;

use PHPUnit\Framework\TestCase;
use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestFramework\TestConfiguration\TestConfiguration;
use RichCongress\TestFramework\TestConfiguration\TestConfigurationExtractor;

/**
 * Class TestConfigurationTest
 *
 * @package    RichCongress\TestFramework\Tests\TestConfiguration
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\TestFramework\TestConfiguration\TestConfiguration
 */
final class TestConfigurationTest extends TestCase
{
    /**
     * @TestConfig("custom_configuration")
     */
    public function testTestConfiguration(): void
    {
        $testConfig = TestConfigurationExtractor::get(__CLASS__, __FUNCTION__);
        self::assertInstanceOf(TestConfig::class, $testConfig);

        TestConfiguration::setCurrentTestConfig($testConfig);
        self::assertTrue($testConfig->has('custom_configuration'));
        self::assertTrue($testConfig->get('custom_configuration'));
    }
}
