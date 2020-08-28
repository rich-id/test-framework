<?php declare(strict_types=1);

namespace RichCongress\TestFramework\TestHook;

/**
 * Interface TestHookInterface
 *
 * @package   RichCongress\TestFramework\TestHook
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 */
interface TestHookInterface
{
    /**
     * A list or 'method' => priority (string => int)
     *
     * @return array
     */
    public function getExecutionPriorities(): array;

    public function executeAfterIncompleteTest(string $test, string $message, float $time): void;
    public function executeAfterLastTest(): void;
    public function executeAfterRiskyTest(string $test, string $message, float $time): void;
    public function executeAfterSkippedTest(string $test, string $message, float $time): void;
    public function executeAfterSuccessfulTest(string $test, float $time): void;
    public function executeAfterTest(string $test, float $time): void;
    public function executeAfterTestError(string $test, string $message, float $time): void;
    public function executeAfterTestFailure(string $test, string $message, float $time): void;
    public function executeAfterTestWarning(string $test, string $message, float $time): void;
    public function executeBeforeFirstTest(): void;
    public function executeBeforeTest(string $test): void;
}
