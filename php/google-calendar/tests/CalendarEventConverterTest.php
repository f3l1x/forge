<?php declare(strict_types = 1);

namespace Tests\Tlapnet\Forge\Unit\Google;

use DateTime;
use PHPUnit\Framework\TestCase;
use Tlapnet\Forge\Google\CalendarEvent;
use Tlapnet\Forge\Google\CalendarEventConverter;

final class CalendarEventConverterTest extends TestCase
{

	public function testConvertingFromAndTo(): void
	{
		$converter = new CalendarEventConverter();

		$e = new CalendarEvent();
		$e->setTitle('Title');
		$e->setStart(new DateTime('2018-05-05 05:00:00'));
		$e->setEnd(new DateTime('2018-05-05 10:00:00'));
		$e->setLocation('Hradec Kralove');

		$ge = $converter->toGoogleEvent($e);
		$copy = $converter->fromGoogleEvent($ge);

		$this->assertEquals($e->getTitle(), $copy->getTitle());
		$this->assertEquals($e->getLocation(), $copy->getLocation());
		$this->assertEquals($e->getDescription(), $copy->getDescription());
		$this->assertEquals($e->getStart()->getTimestamp(), $copy->getStart()->getTimestamp());
		$this->assertEquals($e->getEnd()->getTimestamp(), $copy->getEnd()->getTimestamp());
	}

}
