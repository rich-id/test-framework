<?php declare(strict_types=1);

namespace RichCongress\TestFramework\TestHook;

/**
 * Class AbstractTestHook
 *
 * @package   RichCongress\TestFramework\TestHook
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 */
abstract class AbstractTestHook implements TestHookInterface
{
    /**
     * @return array
     */
    public function getExecutionPriorities(): array
    {
        return [];
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
        // TODO: Implement executeAfterIncompleteTest() method.
    }

    /**
     * @return void
     */
    public function executeAfterLastTest(): void
    {
        // TODO: Implement executeAfterLastTest() method.
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
        // TODO: Implement executeAfterRiskyTest() method.
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
        // TODO: Implement executeAfterSkippedTest() method.
    }

    /**
     * @param string $test
     * @param float  $time
     *
     * @return void
     */
    public function executeAfterSuccessfulTest(string $test, float $time): void
    {
        // TODO: Implement executeAfterSuccessfulTest() method.
    }

    /**
     * @param string $test
     * @param float  $time
     *
     * @return void
     */
    public function executeAfterTest(string $test, float $time): void
    {
        // TODO: Implement executeAfterTest() method.
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
        // TODO: Implement executeAfterTestError() method.
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
        // TODO: Implement executeAfterTestFailure() method.
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
        // TODO: Implement executeAfterTestWarning() method.
    }

    /**
     * @return void
     */
    public function executeBeforeFirstTest(): void
    {
        // TODO: Implement executeBeforeFirstTest() method.
    }

    /**
     * @param string $test
     *
     * @return void
     */
    public function executeBeforeTest(string $test): void
    {
        // TODO: Implement executeBeforeTest() method.
    }
}
