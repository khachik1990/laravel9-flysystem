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

namespace Khachik\Flysystem;

use Khachik\Flysystem\Adapter\ConnectionFactory as AdapterFactory;
use Khachik\Flysystem\Cache\ConnectionFactory as CacheFactory;
use Illuminate\Support\Arr;
use League\Flysystem\Cached\CachedAdapter;
use League\Flysystem\EventableFilesystem\EventableFilesystem;
use League\Flysystem\Filesystem;

/**
 * This is the filesystem factory class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
class FlysystemFactory
{
    /**
     * The adapter factory instance.
     *
     * @var \Khachik\Flysystem\Adapter\ConnectionFactory
     */
    protected $adapter;

    /**
     * The cache factory instance.
     *
     * @var \Khachik\Flysystem\Cache\ConnectionFactory
     */
    protected $cache;

    /**
     * Create a new filesystem factory instance.
     *
     * @param \Khachik\Flysystem\Adapter\ConnectionFactory $adapter
     * @param \Khachik\Flysystem\Cache\ConnectionFactory   $cache
     *
     * @return void
     */
    public function __construct(AdapterFactory $adapter, CacheFactory $cache)
    {
        $this->adapter = $adapter;
        $this->cache = $cache;
    }

    /**
     * Make a new flysystem instance.
     *
     * @param array                                      $config
     * @param \Khachik\Flysystem\FlysystemManager $manager
     *
     * @throws \InvalidArgumentException
     *
     * @return \League\Flysystem\FilesystemInterface
     */
    public function make(array $config, FlysystemManager $manager)
    {
        $adapter = $this->createAdapter($config);

        if (is_array($cache = Arr::get($config, 'cache', false))) {
            $adapter = new CachedAdapter($adapter, $this->createCache($cache, $manager));
        }

        $options = $this->getOptions($config);

        if (Arr::get($config, 'eventable', false)) {
            return new EventableFilesystem($adapter, $options);
        }

        return new Filesystem($adapter, $options);
    }

    /**
     * Establish an adapter connection.
     *
     * @param array $config
     *
     * @return \League\Flysystem\AdapterInterface
     */
    public function createAdapter(array $config)
    {
        $config = Arr::except($config, ['cache', 'eventable', 'visibility']);

        return $this->adapter->make($config);
    }

    /**
     * Establish a cache connection.
     *
     * @param array                                      $config
     * @param \Khachik\Flysystem\FlysystemManager $manager
     *
     * @return \League\Flysystem\Cached\CacheInterface
     */
    public function createCache(array $config, FlysystemManager $manager)
    {
        return $this->cache->make($config, $manager);
    }

    /**
     * Get the flysystem options.
     *
     * @param array $config
     *
     * @return array|null
     */
    protected function getOptions(array $config)
    {
        $options = [];

        if ($visibility = Arr::get($config, 'visibility')) {
            $options['visibility'] = $visibility;
        }

        if ($pirate = Arr::get($config, 'pirate')) {
            $options['disable_asserts'] = $pirate;
        }

        return $options;
    }

    /**
     * Get the adapter factory instance.
     *
     * @return \Khachik\Flysystem\Adapter\ConnectionFactory
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Get the cache factory instance.
     *
     * @return \Khachik\Flysystem\Cache\ConnectionFactory
     */
    public function getCache()
    {
        return $this->cache;
    }
}
