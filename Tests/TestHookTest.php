<?php declare(strict_types=1);

namespace RichCongress\TestFramework\Tests;

use PHPUnit\Framework\TestCase;
use RichCongress\TestFramework\PHPUnit\PHPUnitExtension;
use RichCongress\TestFramework\Tests\Resources\DummyTestHook;
use RichCongress\TestFramework\Tests\Resources\SecondDummyTestHook;
use RichCongress\TestFramework\Tests\Resources\ThirdDummyTestHook;

/**
 * Class TestHookTest
 *
 * @package   RichCongress\TestFramework\Tests
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\TestFramework\PHPUnit\PHPUnitExtension
 * @covers \RichCongress\TestFramework\TestHook\AbstractTestHook
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
        self::assertCount(3, $executeAfterIncompleteTestHooks);
        self::assertInstanceOf(DummyTestHook::class, $executeAfterIncompleteTestHooks[0]['hook']);
        self::assertInstanceOf(SecondDummyTestHook::class, $executeAfterIncompleteTestHooks[1]['hook']);
        self::assertInstanceOf(ThirdDummyTestHook::class, $executeAfterIncompleteTestHooks[2]['hook']);

        $executeAfterLastTestHooks = $hooks['executeAfterLastTest'];
        self::assertCount(3, $executeAfterLastTestHooks);
        self::assertInstanceOf(SecondDummyTestHook::class, $executeAfterLastTestHooks[0]['hook']);
        self::assertInstanceOf(ThirdDummyTestHook::class, $executeAfterLastTestHooks[1]['hook']);
        self::assertInstanceOf(DummyTestHook::class, $executeAfterLastTestHooks[2]['hook']);
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
        $this->extension->executeBeforeTest('test');

        self::assertTrue(DummyTestHook::$executeBeforeTest);
        self::assertTrue(SecondDummyTestHook::$executeBeforeTest);
    }
}
