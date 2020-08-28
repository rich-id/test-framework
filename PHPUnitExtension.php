<?php declare(strict_types=1);

namespace RichCongress\TestFramework;

use PHPUnit\Runner\AfterIncompleteTestHook;
use PHPUnit\Runner\AfterRiskyTestHook;
use PHPUnit\Runner\AfterSkippedTestHook;
use PHPUnit\Runner\AfterSuccessfulTestHook;
use PHPUnit\Runner\AfterTestErrorHook;
use PHPUnit\Runner\AfterTestFailureHook;
use PHPUnit\Runner\AfterTestHook;
use PHPUnit\Runner\AfterTestWarningHook;
use PHPUnit\Runner\BeforeFirstTestHook;
use PHPUnit\Runner\AfterLastTestHook;
use PHPUnit\Runner\BeforeTestHook;
use RichCongress\TestFramework\TestHook\TestHookInterface;

/**
 * Class PHPUnitExtension
 *
 * @package   RichCongress\TestFramework
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 */
class PHPUnitExtension implements
    AfterIncompleteTestHook,
    AfterLastTestHook,
    AfterRiskyTestHook,
    AfterSkippedTestHook,
    AfterSuccessfulTestHook,
    AfterTestErrorHook,
    AfterTestFailureHook,
    AfterTestHook,
    AfterTestWarningHook,
    BeforeFirstTestHook,
    BeforeTestHook
{
    /** @var array|string[] */
    public static $supportedHooks = [];

    /** @var array */
    protected $hooks = [
        'executeAfterIncompleteTest' => [],
        'executeAfterLastTest'       => [],
        'executeAfterRiskyTest'      => [],
        'executeAfterSkippedTest'    => [],
        'executeAfterSuccessfulTest' => [],
        'executeAfterTest'           => [],
        'executeAfterTestError'      => [],
        'executeAfterTestFailure'    => [],
        'executeAfterTestWarning'    => [],
        'executeBeforeFirstTest'     => [],
        'executeBeforeTest'          => [],
    ];

    /**
     * PHPUnitExtension constructor.
     *
     * @param string ...$hooksClass
     */
    public function __construct(string ...$hooksClass)
    {
        $supportedHooks = array_merge($hooksClass, static::$supportedHooks);

        foreach ($supportedHooks as $class) {
            /** @var TestHookInterface $hook */
            $hook = new $class();
            $priorities = $hook->getExecutionPriorities();

            foreach (array_keys($this->hooks) as $method) {
                $this->hooks[$method][] = [
                    'hook'     => $hook,
                    'priority' => $priorities[$method] ?? 0,
                ];
            }
        }

        foreach ($this->hooks as $method => $hooksParams) {
            usort(
                $hooksParams,
                static function (array $a, array $b) {
                    $aPriority = $a['priority'] ?? 0;
                    $bPriority = $b['priority'] ?? 0;

                    if ($aPriority === $bPriority) {
                        return 0;
                    }

                    return ($aPriority < $bPriority) ? 1 : -1;
                }
            );

            $this->hooks[$method] = $hooksParams;
        }
    }

    public function executeAfterIncompleteTest(string $test, string $message, float $time): void
    {
        $this->callHooks(__FUNCTION__, $test, $message, $time);
    }

    public function executeAfterLastTest(): void
    {
        $this->callHooks(__FUNCTION__);
    }

    public function executeAfterRiskyTest(string $test, string $message, float $time): void
    {
        $this->callHooks(__FUNCTION__, $test, $message, $time);
    }

    public function executeAfterSkippedTest(string $test, string $message, float $time): void
    {
        $this->callHooks(__FUNCTION__, $test, $message, $time);
    }

    public function executeAfterSuccessfulTest(string $test, float $time): void
    {
        $this->callHooks(__FUNCTION__, $test, $time);
    }

    public function executeAfterTestError(string $test, string $message, float $time): void
    {
        $this->callHooks(__FUNCTION__, $test, $message, $time);
    }

    public function executeAfterTestFailure(string $test, string $message, float $time): void
    {
        $this->callHooks(__FUNCTION__, $test, $message, $time);
    }

    public function executeAfterTest(string $test, float $time): void
    {
        $this->callHooks(__FUNCTION__, $test, $time);
    }

    public function executeAfterTestWarning(string $test, string $message, float $time): void
    {
        $this->callHooks(__FUNCTION__, $test, $message, $time);
    }

    public function executeBeforeFirstTest(): void
    {
        $this->callHooks(__FUNCTION__);
    }

    public function executeBeforeTest(string $test): void
    {
        $this->callHooks(__FUNCTION__, $test);
    }

    public function callHooks(string $method, ...$arguments): void
    {
        foreach ($this->hooks[$method] as $hookParams) {
            $callback = [$hookParams['hook'], $method];
            \call_user_func_array($callback, $arguments);
        }
    }
}
