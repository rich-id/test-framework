<?php declare(strict_types=1);

namespace RichCongress\TestFramework\TestHook;

use RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig;
use RichCongress\TestFramework\TestConfiguration\TestConfiguration;
use RichCongress\TestFramework\TestConfiguration\TestConfigurationExtractor;

/**
 * Class TestConfigurationHook
 *
 * @package    RichCongress\TestFramework\TestHook
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
class TestConfigurationHook extends AbstractTestHook
{
    public const PRIORITY = 999;

    /**
     * @return array
     */
    public function getExecutionPriorities(): array
    {
        return [
            'executeBeforeTest' => self::PRIORITY,
        ];
    }

    /**
     * The argument is formed like Namespace\Class::testMethod
     */
    public function executeBeforeTest(string $test): void
    {
        $explodedTestName = explode('::', $test);

        if (count($explodedTestName) !== 2) {
            return;
        }

        [$class, $method] = $explodedTestName;
        $testConfig = TestConfigurationExtractor::getRecursively($class, $method) ?? new TestConfig();
        TestConfiguration::setCurrentTestConfig($testConfig);
    }
}
