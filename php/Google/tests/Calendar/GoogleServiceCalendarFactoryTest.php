<?php declare(strict_types = 1);

namespace Tests\Contributte\Google\Calendar;

use Contributte\Google\Calendar\GoogleServiceCalendarFactory;
use Google_Client;
use Google_Service_Calendar;
use PHPUnit\Framework\TestCase;

final class GoogleServiceCalendarFactoryTest extends TestCase
{

	public function setUp(): void
	{
		parent::setUp();

		$this->markTestSkipped('Not used');
	}

	public function testCreate(): void
	{
		$factory = new GoogleServiceCalendarFactory(new Google_Client());
		$calendarSvc = $factory->create();

		$this->assertContains(Google_Service_Calendar::CALENDAR, $calendarSvc->getClient()->getScopes());
	}

}
