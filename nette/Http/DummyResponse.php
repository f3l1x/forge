<?php declare(strict_types = 1);

namespace Tests\Mocks\Dummy;

use Nette\Http\IResponse;

/**
 * @method self deleteHeader(string $name)
 */
final class DummyResponse implements IResponse
{

	public function setCode(int $code, string $reason = NULL)
	{

	}

	public function getCode(): int
	{

	}

	public function setHeader(string $name, string $value)
	{

	}

	public function addHeader(string $name, string $value)
	{

	}

	public function setContentType(string $type, string $charset = NULL)
	{

	}

	public function redirect(string $url, int $code = self::S302_FOUND): void
	{

	}

	public function setExpiration(?string $expire)
	{

	}

	public function isSent(): bool
	{

	}

	public function getHeader(string $header): ?string
	{

	}

	public function getHeaders(): array
	{

	}

	public function setCookie(string $name, string $value, $expire, string $path = NULL, string $domain = NULL, bool $secure = NULL, bool $httpOnly = NULL)
	{

	}

	public function deleteCookie(string $name, string $path = NULL, string $domain = NULL, bool $secure = NULL)
	{

	}

}
