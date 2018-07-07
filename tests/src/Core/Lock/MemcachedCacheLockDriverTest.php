<?php


namespace Friendica\Test\src\Core\Lock;


use Friendica\Core\Cache\CacheDriverFactory;
use Friendica\Core\Lock\CacheLockDriver;

class MemcachedCacheLockDriverTest extends LockTest
{
	/**
	 * @var \Friendica\Core\Cache\IMemoryCacheDriver
	 */
	private $cache;

	protected function getInstance()
	{
		if (class_exists('Memcached')) {
			try {
				$this->cache = CacheDriverFactory::create('memcached');
			} catch (\Exception $exception) {
				print "Redis - TestCase failed: " . $exception->getMessage();
				throw new \Exception();
			}
			return new CacheLockDriver($this->cache);
		} else {
			$this->markTestSkipped('Redis driver isn\'t available');
			return null;
		}
	}

	public function tearDown()
	{
		if (class_exists('Redis')) {
			$this->cache->clear();
		}
		parent::tearDown();
	}
}
