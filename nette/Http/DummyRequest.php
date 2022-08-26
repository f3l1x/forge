<?php declare(strict_types = 1);

namespace Tests\Mocks\Dummy;

use Nette\Http\IRequest;
use Nette\Http\UrlScript;

final class DummyRequest implements IRequest
{

	private ?UrlScript $url;

	public function getUrl(): UrlScript
	{
		return $this->url;
	}

	public function getQuery(string $key = NULL)
	{

	}

	public function getPost(string $key = NULL)
	{

	}

	public function getFile(string $key)
	{

	}

	public function getFiles(): array
	{

	}

	public function getCookie(string $key)
	{

	}

	public function getCookies(): array
	{

	}

	public function getMethod(): string
	{

	}

	public function isMethod(string $method): bool
	{

	}

	public function getHeader(string $header): ?string
	{

	}

	public function getHeaders(): array
	{

	}

	public function isSecured(): bool
	{

	}

	public function isAjax(): bool
	{

	}

	public function getRemoteAddress(): ?string
	{

	}

	public function getRemoteHost(): ?string
	{

	}

	public function getRawBody(): ?string
	{

	}

}
