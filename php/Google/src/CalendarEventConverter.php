<?php declare(strict_types = 1);

namespace Tlapnet\Forge\Google;

use Contributte\Google\Calendar\Calendar;
use DateTime;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;

final class CalendarEventConverter
{

	public function toGoogleEvent(CalendarEvent $event): Google_Service_Calendar_Event
	{
		$ge = new Google_Service_Calendar_Event();
		$ge->setId($event->getId());
		$ge->setSummary($event->getTitle());
		$ge->setDescription($event->getDescription());
		$ge->setLocation($event->getLocation());

		$eventStart = new Google_Service_Calendar_EventDateTime();
		$eventStart->setDateTime($event->getStart()->format(Calendar::GOOGLE_DATE_FORMAT));
		$ge->setStart($eventStart);

		$eventEnd = new Google_Service_Calendar_EventDateTime();
		$eventEnd->setDateTime($event->getEnd()->format(Calendar::GOOGLE_DATE_FORMAT));
		$ge->setEnd($eventEnd);

		return $ge;
	}

	public function fromGoogleEvent(Google_Service_Calendar_Event $event): CalendarEvent
	{
		$ce = new CalendarEvent();
		$ce->setId($event->getId() ?? '');
		$ce->setTitle($event->getSummary() ?? '');
		$ce->setDescription($event->getDescription() ?? '');
		$ce->setLocation($event->getLocation() ?? '');
		$ce->setStart(new DateTime($event->getStart()->getDateTime()) ?? new DateTime());
		$ce->setEnd(new DateTime($event->getEnd()->getDateTime()) ?? new DateTime());

		return $ce;
	}

}
