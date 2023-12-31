<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Flysystem.
 *
 * (c) Graham Campbell <hello@gjcampbell.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Khachik\Flysystem\Adapter\Connector;

use Khachik\Manager\ConnectorInterface;
use League\Flysystem\Adapter\NullAdapter;

/**
 * This is the null connector class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
final class NullConnector implements ConnectorInterface
{
    /**
     * Establish an adapter connection.
     *
     * @param string[] $config
     *
     * @throws \InvalidArgumentException
     *
     * @return \League\Flysystem\Adapter\NullAdapter
     */
    public function connect(array $config)
    {
        return self::getAdapter();
    }

    /**
     * Get the null adapter.
     *
     * @return \League\Flysystem\Adapter\NullAdapter
     */
    private static function getAdapter()
    {
        return new NullAdapter();
    }
}
