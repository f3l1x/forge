<?php declare(strict_types = 1);

namespace Contributte\Google;

use Google_Client;
use Google_Service_Oauth2;

final class OAuthClient
{

	/** @var Google_Client */
	private $client;

	public function __construct(string $clientId, string $clientSecret)
	{
		$this->client = new Google_Client();

		$this->client->setClientId($clientId);
		$this->client->setClientSecret($clientSecret);
	}

	public function addScope(string $scope): void
	{
		$this->client->addScope($scope);
	}

	/**
	 * @param string[] $scopes
	 */
	public function addScopes(array $scopes): void
	{
		foreach ($scopes as $scope) {
			$this->addScope($scope);
		}
	}

	/**
	 * @param string[] $scopes
	 */
	public function setScopes(array $scopes): void
	{
		$this->client->setScopes($scopes);
	}

	public function setRedirectUri(string $uri): void
	{
		$this->client->setRedirectUri($uri);
	}

	public function setAccessToken(string $token): void
	{
		$this->client->setAccessToken($token);
	}

	public function createAuthorizeUrl(): string
	{
		return $this->client->createAuthUrl();
	}

	/**
	 * @param string[] $scopes
	 */
	public function createAuthorizeScopedUrl(array $scopes): string
	{
		return $this->client->createAuthUrl($scopes);
	}

	/**
	 * @return string[]
	 */
	public function authenticate(string $code): array
	{
		return $this->client->fetchAccessTokenWithAuthCode($code);
	}

	public function createServiceOauth2(): Google_Service_Oauth2
	{
		return new Google_Service_Oauth2($this->client);
	}

}
