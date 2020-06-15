<?php declare(strict_types = 1);

namespace Tests\Contributte\Google;

use Contributte\Google\ApiClientFactory;
use Contributte\Google\Exception\Runtime\GoogleAuthException;
use Google_Client;
use PHPUnit\Framework\TestCase;

final class ApiClientFactoryTest extends TestCase
{

	public function setUp(): void
	{
		parent::setUp();

		$this->markTestSkipped('Not used');
	}

	public function testCreateMissingConfigKey(): void
	{
		$conf = $this->prepareValidConfig();
		/** @var string $randKey */
		$randKey = array_rand($conf, 1);
		unset($conf[$randKey]);

		$factory = new ApiClientFactory($conf, 'app name', './');

		$this->expectException(GoogleAuthException::class);
		$factory->create();
	}

	public function testCreateMissingConfigValue(): void
	{
		$conf = $this->prepareValidConfig();
		/** @var string $randKey */
		$randKey = array_rand($conf, 1);
		$conf[$randKey] = '';

		$factory = new ApiClientFactory($conf, 'app name', './');

		$this->expectException(GoogleAuthException::class);
		$factory->create();
	}

	public function testCreate(): void
	{
		$conf = $this->prepareValidConfig();
		$conf['type'] = 'service_account';

		$factory = new ApiClientFactory($conf, 'app name', './');

		$client = $factory->create();
		$this->assertInstanceOf(Google_Client::class, $client);
		$this->assertFileExists('./' . ApiClientFactory::AUTH_JSON_FILE);

		unlink('./' . ApiClientFactory::AUTH_JSON_FILE);
	}

	/**
	 * @return string[]
	 */
	private function prepareValidConfig(): array
	{
		$conf = [];
		foreach (ApiClientFactory::MANDATORY_CONFIG_ITEMS as $key) {
			$conf[$key] = 'value';
		}

		return $conf;
	}

}
