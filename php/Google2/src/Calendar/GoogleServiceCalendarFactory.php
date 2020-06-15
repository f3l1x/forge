<?php declare(strict_types = 1);

namespace Contributte\Google\Calendar;

use Google_Client;
use Google_Service_Calendar;

final class GoogleServiceCalendarFactory
{

	/** @var Google_Client */
	private $client;

	public function __construct(Google_Client $client)
	{
		$this->client = $client;
		$this->client->addScope([Google_Service_Calendar::CALENDAR]);
	}

	public function create(): Google_Service_Calendar
	{
		return new Google_Service_Calendar($this->client);
	}

}
