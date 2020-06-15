<?php declare(strict_types = 1);

namespace Contributte\Google;

use Contributte\Google\Exception\Runtime\AuthenticationException;
use Contributte\Google\Exception\Runtime\NotAuthenticatedException;
use Google_Service_Oauth2_Userinfoplus;
use Nette\Application\Responses\CallbackResponse;
use Nette\Http\Request;
use Nette\Http\Response;

final class Sso
{

	/** @var OAuthClient */
	private $client;

	/** @var Session */
	private $storage;

	public function __construct(OAuthClient $client, Session $storage)
	{
		$this->client = $client;
		$this->storage = $storage;
	}

	public function getClient(): OAuthClient
	{
		return $this->client;
	}

	public function createAuthorizeUrl(): string
	{
		return $this->client->createAuthorizeUrl();
	}

	public function createAuthorizeResponse(): CallbackResponse
	{
		return new CallbackResponse(function (Request $request, Response $response): void {
			$response->redirect($this->createAuthorizeUrl());
		});
	}

	/**
	 * Authenticate via given code.
	 */
	public function authenticate(string $code): void
	{
		$auth = $this->client->authenticate($code);

		if (isset($auth['access_token'])) {
			$this->storage->reset();
			$this->storage->storeToken($auth);
		} else {
			$error = isset($auth['error']) ?? 'unknown';
			$description = isset($auth['error_description']) ?? 'undefined reason';

			throw new AuthenticationException(sprintf('Authentication failed (%s) because "%s"', $error, $description));
		}
	}

	/**
	 * Exists token is storage? Then we are authenticated.
	 *
	 * @todo expiration checking
	 */
	public function isAuthenticated(): bool
	{
		return $this->storage->hasToken();
	}

	public function getProfile(): Google_Service_Oauth2_Userinfoplus
	{
		if (!$this->isAuthenticated()) {
			throw new NotAuthenticatedException('User is not authenticated');
		}

		$this->client->setAccessToken((string) $this->storage->getAccessToken());
		$oauth = $this->client->createServiceOauth2();

		return $oauth->userinfo->get();
	}

}
