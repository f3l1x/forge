<?php declare(strict_types = 1);

namespace Contributte\Google;

use Nette\Http\Session as NetteSession;
use Nette\Http\SessionSection;

final class Session
{

	private const GOOGLE_SESSION = 'Lotus.SSO.Google';

	/** @var SessionSection */
	private $section;

	public function __construct(NetteSession $session)
	{
		$this->section = $session->getSection(self::GOOGLE_SESSION);
	}

	/**
	 * @param string[] $token
	 */
	public function storeToken(array $token): void
	{
		$this->section->token = $token;
	}

	public function hasToken(): bool
	{
		return $this->section->offsetExists('token');
	}

	/**
	 * Parse access_token from token
	 *
	 * @return string|false|null
	 */
	public function getAccessToken()
	{
		if (!$this->hasToken()) {
			return FALSE;
		}

		$token = $this->section->offsetGet('token');

		return $token['access_token'] ?? NULL;
	}

	/**
	 * Remove all data from session.
	 */
	public function reset(): void
	{
		$this->section->remove();
	}

}
