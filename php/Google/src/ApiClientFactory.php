<?php declare(strict_types = 1);

namespace Contributte\Google;

use Contributte\Google\Exception\Runtime\GoogleAuthException;
use Google_Client;
use Nette\Utils\FileSystem;
use Nette\Utils\Json;

final class ApiClientFactory
{

	public const MANDATORY_CONFIG_ITEMS = [
		'project_id',
		'private_key_id',
		'private_key',
		'client_email',
		'client_id',
		'type',
		'auth_uri',
		'token_uri',
		'auth_provider_x509_cert_url',
		'client_x509_cert_url',
	];

	public const AUTH_JSON_FILE = 'google-auth.json';

	/** @var string */
	private $appName;

	/** @var string[] */
	private $authConfig;

	/** @var string */
	private $tmpDir;

	/**
	 * @param string[] $authConfig
	 */
	public function __construct(array $authConfig, string $appName, string $tmpDir)
	{
		$this->authConfig = $authConfig;
		$this->appName = $appName;
		$this->tmpDir = $tmpDir;
	}

	public function create(): Google_Client
	{
		$configFile = $this->getConfigFilePath();

		if (!file_exists($configFile)) {
			$this->validateAuthConfig($this->authConfig);
			$configFile = $this->createAuthConfigFile();
		}

		$client = new Google_Client();
		$client->setApplicationName($this->appName);
		$client->setAuthConfig($configFile);

		return $client;
	}

	/**
	 * @param string[] $authConfig
	 */
	private function validateAuthConfig(array $authConfig): void
	{
		foreach (self::MANDATORY_CONFIG_ITEMS as $key) {
			if (!array_key_exists($key, $authConfig)) {
				throw new GoogleAuthException(
					sprintf('Please provide valid google auth config. Missing "%s" key', $key)
				);
			}
		}

		foreach ($authConfig as $key => $val) {
			if (empty($val)) {
				throw new GoogleAuthException(
					sprintf('Please provide valid google auth config. Missing value for "%s" key', $key)
				);
			}
		}
	}

	private function createAuthConfigFile(): string
	{
		$filePath = $this->getConfigFilePath();
		FileSystem::write($filePath, Json::encode($this->authConfig));

		return $filePath;
	}

	private function getConfigFilePath(): string
	{
		return $this->tmpDir . '/' . self::AUTH_JSON_FILE;
	}

}
