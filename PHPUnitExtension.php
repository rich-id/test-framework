<?php declare(strict_types=1);

namespace RichCongress\TestFramework;

use PHPUnit\Event\Subscriber;
use PHPUnit\Event\Test\PreparationStarted;
use PHPUnit\Event\Test\PreparationStartedSubscriber;
use PHPUnit\Event\Application\FinishedSubscriber;
use PHPUnit\Event\Application\Finished;
use PHPUnit\Runner\Extension\Extension;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration;
use RichCongress\TestFramework\TestConfiguration\TestConfiguration;

class PHPUnitExtension implements Extension
{
    public function bootstrap(Configuration $configuration, Facade $facade, ParameterCollection $parameters): void
    {
        $seed = (int) \getenv('PHPUNIT_SEED');
        if ($seed === 0) {
            $seed = mt_rand();
            \putenv("PHPUNIT_SEED=$seed");
        }

        $facade->registerSubscriber(new class implements PreparationStartedSubscriber {
            public function notify(PreparationStarted $event): void
            {
                TestConfiguration::registerTestConfig($event->test());
            }
        });

        $facade->registerSubscriber(new class($seed) implements FinishedSubscriber {
            public function __construct(public int $seed) {}

            public function notify(Finished $event): void
            {
                fwrite(STDOUT, "Seed used: $this->seed" . PHP_EOL);
            }
        });
    }
}
