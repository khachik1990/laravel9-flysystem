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
use League\Flysystem\Adapter\Ftp;

/**
 * This is the ftp connector class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
final class FtpConnector implements ConnectorInterface
{
    /**
     * Establish an adapter connection.
     *
     * @param string[] $config
     *
     * @throws \InvalidArgumentException
     *
     * @return \League\Flysystem\Adapter\Ftp
     */
    public function connect(array $config)
    {
        return self::getAdapter($config);
    }

    /**
     * Get the ftp adapter.
     *
     * @param string[] $config
     *
     * @return \League\Flysystem\Adapter\Ftp
     */
    private static function getAdapter(array $config)
    {
        return new Ftp($config);
    }
}
