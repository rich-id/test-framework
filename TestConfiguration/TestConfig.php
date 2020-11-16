<?php declare(strict_types=1);

namespace RichCongress\TestFramework\TestConfiguration;

/**
 * Class TestConfig
 *
 * @package    RichCongress\TestFramework\TestConfiguration
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @Annotations
 */
final class TestConfig
{
    /** @var array<string|mixed> */
    private $configurations;

    /**
     * TestConfig constructor.
     *
     * @param array|string $configurations
     */
    public function __construct($configurations)
    {
        $this->configurations = [];
        $configurations = (array) ($configurations['value'] ?? []);
        $isAssociative = static::isAssociative($configurations);

        if ($isAssociative) {
            $this->configurations = $configurations;
        } else {
            $this->configurations = array_combine(
                $configurations,
                array_fill(0, count($configurations), true)
            );
        }
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->configurations);
    }

    public function get(string $key)
    {
        return $this->configurations[$key] ?? null;
    }

    protected static function isAssociative(array $arr): bool
    {
        if ($arr === []) {
            return false;
        }

        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
