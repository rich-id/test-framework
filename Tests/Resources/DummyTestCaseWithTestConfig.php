<?php declare(strict_types=1);

namespace RichCongress\TestFramework\Tests\Resources;

use PHPUnit\Framework\TestCase;
use RichCongress\TestFramework\TestConfiguration\TestConfig;

/**
 * Class DummyTestCaseWithTestConfig
 *
 * @package    RichCongress\TestFramework\Tests\Resources
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @TestConfig({
 *     "test_case_configuration": "this is a test",
 *     "test_case_configuration_2": 10
 * })
 */
abstract class DummyTestCaseWithTestConfig extends TestCase
{
}
