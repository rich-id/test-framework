<?php declare(strict_types=1);

namespace RichCongress\TestFramework\Tests\Resources;

use RichCongress\TestFramework\TestHook\AbstractTestHook;

/**
 * Class DummyTestHook
 *
 * @package   RichCongress\TestFramework\Tests\Resources
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 */
class DummyTestHook extends AbstractTestHook
{
    public static $executeAfterIncompleteTest = false;
    public static $executeAfterLastTest = false;
    public static $executeAfterRiskyTest = false;
    public static $executeAfterSkippedTest = false;
    public static $executeAfterSuccessfulTest = false;
    public static $executeAfterTest = false;
    public static $executeAfterTestError = false;
    public static $executeAfterTestFailure = false;
    public static $executeAfterTestWarning = false;
    public static $executeBeforeFirstTest = false;
    public static $executeBeforeTest = false;

    public function __construct()
    {
        static::$executeAfterIncompleteTest = false;
        static::$executeAfterLastTest = false;
        static::$executeAfterRiskyTest = false;
        static::$executeAfterSkippedTest = false;
        static::$executeAfterSuccessfulTest = false;
        static::$executeAfterTest = false;
        static::$executeAfterTestError = false;
        static::$executeAfterTestFailure = false;
        static::$executeAfterTestWarning = false;
        static::$executeBeforeFirstTest = false;
        static::$executeBeforeTest = false;
    }

    /**
     * @return array
     */
    public function getExecutionPriorities(): array
    {
        return [
            'executeAfterIncompleteTest' => 100,
            'executeAfterLastTest'       => -100,
        ];
    }

    /**
     * @param string $test
     * @param string $message
     * @param float  $time
     *
     * @return void
     */
    public function executeAfterIncompleteTest(string $test, string $message, float $time): void
    {
        static::$executeAfterIncompleteTest = true;
    }

    /**
     * @return void
     */
    public function executeAfterLastTest(): void
    {
        static::$executeAfterLastTest = true;
    }

    /**
     * @param string $test
     * @param string $message
     * @param float  $time
     *
     * @return void
     */
    public function executeAfterRiskyTest(string $test, string $message, float $time): void
    {
        static::$executeAfterRiskyTest = true;
    }

    /**
     * @param string $test
     * @param string $message
     * @param float  $time
     *
     * @return void
     */
    public function executeAfterSkippedTest(string $test, string $message, float $time): void
    {
        static::$executeAfterSkippedTest = true;
    }

    /**
     * @param string $test
     * @param float  $time
     *
     * @return void
     */
    public function executeAfterSuccessfulTest(string $test, float $time): void
    {
        static::$executeAfterSuccessfulTest = true;
    }

    /**
     * @param string $test
     * @param float  $time
     *
     * @return void
     */
    public function executeAfterTest(string $test, float $time): void
    {
        static::$executeAfterTest = true;
    }

    /**
     * @param string $test
     * @param string $message
     * @param float  $time
     *
     * @return void
     */
    public function executeAfterTestError(string $test, string $message, float $time): void
    {
        static::$executeAfterTestError = true;
    }

    /**
     * @param string $test
     * @param string $message
     * @param float  $time
     *
     * @return void
     */
    public function executeAfterTestFailure(string $test, string $message, float $time): void
    {
        static::$executeAfterTestFailure = true;
    }

    /**
     * @param string $test
     * @param string $message
     * @param float  $time
     *
     * @return void
     */
    public function executeAfterTestWarning(string $test, string $message, float $time): void
    {
        static::$executeAfterTestWarning = true;
    }

    /**
     * @return void
     */
    public function executeBeforeFirstTest(): void
    {
        static::$executeBeforeFirstTest = true;
    }

    /**
     * @param string $test
     *
     * @return void
     */
    public function executeBeforeTest(string $test): void
    {
        static::$executeBeforeTest = true;
    }
}
