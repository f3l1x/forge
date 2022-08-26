<?php

namespace Contributte\Advisories\Tracy;

use Contributte\Advisories\Exception\ComplainException;
use Contributte\Advisories\Tracy\Suggestion\UISuggestions;
use Exception;

class SuggestionBlueScreen
{

	/** @var array */
	public static $mapping = [
		ComplainException::class => [
			ComplainException::UI_PRESENTER_CONTAINER => [UISuggestions::class, 'presenterContext'],
		],
	];

	/**
	 * @param Exception $e
	 * @return array|null
	 */
	public function __invoke($e)
	{
		if (!$e) return NULL;
		if (!($e instanceof ComplainException)) return NULL;
		if (!isset(
			self::$mapping[ComplainException::class],
			self::$mapping[ComplainException::class][$e->getCode()]
		)) return NULL;

		return [
			'tab' => 'Advisory::Suggestion',
			'panel' => call_user_func_array(self::$mapping[ComplainException::class][$e->getCode()], [$e]),
		];
	}

}
