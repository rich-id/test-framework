<?php declare(strict_types=1);

namespace RichCongress\TestFramework\Tests;

use PHPUnit\Framework\TestCase;
use RichCongress\TestFramework\PHPUnitExtension;
use RichCongress\TestFramework\TestConfiguration\TestConfiguration;
use RichCongress\TestFramework\TestHook\TestConfigurationHook;
use RichCongress\TestFramework\Tests\Resources\TestHook\DummyTestHook;
use RichCongress\TestFramework\Tests\Resources\TestHook\SecondDummyTestHook;
use RichCongress\TestFramework\Tests\Resources\TestHook\ThirdDummyTestHook;

/**
 * Class TestHookTest
 *
 * @package   RichCongress\TestFramework\Tests
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\TestFramework\PHPUnitExtension
 * @covers \RichCongress\TestFramework\TestHook\AbstractTestHook
 * @covers \RichCongress\TestFramework\TestHook\TestConfigurationHook
 */
class TestHookTest extends TestCase
{
    /** @var PHPUnitExtension */
    protected $extension;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        PHPUnitExtension::$supportedHooks[] = DummyTestHook::class;
        $this->extension = new PHPUnitExtension(SecondDummyTestHook::class, ThirdDummyTestHook::class);
    }

    public function testConstructor(): void
    {
        $reflectionProperty = new \ReflectionProperty(PHPUnitExtension::class, 'hooks');
        $reflectionProperty->setAccessible(true);
        $hooks = $reflectionProperty->getValue($this->extension);

        $executeAfterIncompleteTestHooks = $hooks['executeAfterIncompleteTest'];
        self::assertCount(4, $executeAfterIncompleteTestHooks);
        self::assertInstanceOf(DummyTestHook::class, $executeAfterIncompleteTestHooks[0]['hook']);
        self::assertInstanceOf(SecondDummyTestHook::class, $executeAfterIncompleteTestHooks[1]['hook']);
        self::assertInstanceOf(ThirdDummyTestHook::class, $executeAfterIncompleteTestHooks[2]['hook']);
        self::assertInstanceOf(TestConfigurationHook::class, $executeAfterIncompleteTestHooks[3]['hook']);

        $executeAfterLastTestHooks = $hooks['executeAfterLastTest'];
        self::assertCount(4, $executeAfterLastTestHooks);
        self::assertInstanceOf(SecondDummyTestHook::class, $executeAfterLastTestHooks[0]['hook']);
        self::assertInstanceOf(ThirdDummyTestHook::class, $executeAfterLastTestHooks[1]['hook']);
        self::assertInstanceOf(TestConfigurationHook::class, $executeAfterLastTestHooks[2]['hook']);
        self::assertInstanceOf(DummyTestHook::class, $executeAfterLastTestHooks[3]['hook']);
    }

    public function testExecuteAfterIncompleteTest(): void
    {
        $this->extension->executeAfterIncompleteTest('test', 'message', 1.0);

        self::assertTrue(DummyTestHook::$executeAfterIncompleteTest);
        self::assertTrue(SecondDummyTestHook::$executeAfterIncompleteTest);
        self::assertFalse(SecondDummyTestHook::$firstExecutedAfterIncompleteTest);
    }

    public function testExecuteAfterLastTest(): void
    {
        $this->extension->executeAfterLastTest();

        self::assertTrue(DummyTestHook::$executeAfterLastTest);
        self::assertTrue(SecondDummyTestHook::$executeAfterLastTest);
        self::assertTrue(SecondDummyTestHook::$firstExecutedAfterLastTest);
    }

    public function testExecuteAfterRiskyTest(): void
    {
        $this->extension->executeAfterRiskyTest('test', 'message', 1.0);

        self::assertTrue(DummyTestHook::$executeAfterRiskyTest);
        self::assertTrue(SecondDummyTestHook::$executeAfterRiskyTest);
    }

    public function testExecuteAfterSkippedTest(): void
    {
        $this->extension->executeAfterSkippedTest('test', 'message', 1.0);

        self::assertTrue(DummyTestHook::$executeAfterSkippedTest);
        self::assertTrue(SecondDummyTestHook::$executeAfterSkippedTest);
    }

    public function testExecuteAfterSuccessfulTest(): void
    {
        $this->extension->executeAfterSuccessfulTest('test', 1.0);

        self::assertTrue(DummyTestHook::$executeAfterSuccessfulTest);
        self::assertTrue(SecondDummyTestHook::$executeAfterSuccessfulTest);
    }

    public function testExecuteAfterTest(): void
    {
        $this->extension->executeAfterTest('test', 1.0);

        self::assertTrue(DummyTestHook::$executeAfterTest);
        self::assertTrue(SecondDummyTestHook::$executeAfterTest);
    }

    public function testExecuteAfterTestError(): void
    {
        $this->extension->executeAfterTestError('test', 'message', 1.0);

        self::assertTrue(DummyTestHook::$executeAfterTestError);
        self::assertTrue(SecondDummyTestHook::$executeAfterTestError);
    }

    public function testExecuteAfterTestFailure(): void
    {
        $this->extension->executeAfterTestFailure('test', 'message', 1.0);

        self::assertTrue(DummyTestHook::$executeAfterTestFailure);
        self::assertTrue(SecondDummyTestHook::$executeAfterTestFailure);
    }

    public function testExecuteAfterTestWarning(): void
    {
        $this->extension->executeAfterTestWarning('test', 'message', 1.0);

        self::assertTrue(DummyTestHook::$executeAfterTestWarning);
        self::assertTrue(SecondDummyTestHook::$executeAfterTestWarning);
    }

    public function testExecuteBeforeFirstTest(): void
    {
        $this->extension->executeBeforeFirstTest();

        self::assertTrue(DummyTestHook::$executeBeforeFirstTest);
        self::assertTrue(SecondDummyTestHook::$executeBeforeFirstTest);
    }

    public function testExecuteBeforeTest(): void
    {
        $this->extension->executeBeforeTest(__METHOD__);

        self::assertTrue(DummyTestHook::$executeBeforeTest);
        self::assertTrue(SecondDummyTestHook::$executeBeforeTest);
    }

    public function testExecuteTestConfigurationBeforeTestHookWithBadString(): void
    {
        $currentTestConfig = TestConfiguration::getCurrentTestConfig();
        $hook = new TestConfigurationHook();
        $hook->executeBeforeTest('invalid string');

        self::assertSame($currentTestConfig, TestConfiguration::getCurrentTestConfig());
    }
}
