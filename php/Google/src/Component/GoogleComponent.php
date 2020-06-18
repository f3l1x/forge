<?php declare(strict_types = 1);

namespace Contributte\Google\Component;

use Contributte\Google\Sso;
use Nette\Application\IPresenter;
use Nette\Application\UI\PresenterComponent;
use Nette\InvalidStateException;

final class GoogleComponent extends PresenterComponent
{

	/** @var mixed[] */
	public $onAuthenticate = [];

	/** @var mixed[] */
	public $onConfigure = [];

	/** @var Sso */
	private $googleSso;

	/** @var string[] */
	private $scopes = [];

	public function __construct(Sso $googleSso)
	{
		parent::__construct();
		$this->googleSso = $googleSso;
	}

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 * @param IPresenter $presenter
	 */
	protected function attached($presenter): void
	{
		parent::attached($presenter);

		$this->configure();
	}

	/**
	 * Configure Google SSO. This method is called only once.
	 */
	protected function configure(): void
	{
		$client = $this->googleSso->getClient();
		$client->setRedirectUri($this->presenter->link('//this', ['code' => NULL]));

		if ($this->scopes) {
			$client->addScopes($this->scopes);
		}

		$this->onConfigure($this);
	}

	public function addScope(string $scope): void
	{
		$this->scopes[] = $scope;
	}

	public function setRedirectUrl(string $url): void
	{
		$this->googleSso->getClient()->setRedirectUri($url);
	}

	public function authenticate(string $code): void
	{
		if (!$code) {
			throw new InvalidStateException('Invalid code given');
		}

		$this->googleSso->authenticate($code);
		$this->onAuthenticate($this->googleSso);
	}

	public function authorize(): void
	{
		$this->presenter->sendResponse($this->googleSso->createAuthorizeResponse());
	}

}
