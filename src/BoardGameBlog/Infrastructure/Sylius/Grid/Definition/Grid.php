<?php

/*
 * This file is part of testing-resource.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\BoardGameBlog\Infrastructure\Sylius\Grid\Definition;

use Sylius\Component\Grid\Definition\Grid as BaseGrid;

final class Grid extends BaseGrid
{
    private string $code;

    private string $driver;

    /** @var array */
    private $driverConfiguration;

    /** @var string|callable|null */
    private $provider;

    private function __construct(string $code, string $driver, array $driverConfiguration)
    {
        $this->code = $code;
        $this->driver = $driver;
        $this->driverConfiguration = $driverConfiguration;
    }

    public static function fromCodeAndDriverConfiguration(string $code, string $driver, array $driverConfiguration): self
    {
        return new self($code, $driver, $driverConfiguration);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getDriver(): string
    {
        return $this->driver;
    }

    public function getDriverConfiguration(): array
    {
        return $this->driverConfiguration;
    }

    public function getProvider(): string|callable|null
    {
        return $this->provider;
    }

    public function setProvider(string|callable|null $provider): void
    {
        $this->provider = $provider;
    }
}
