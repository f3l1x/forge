<?php declare(strict_types = 1);

namespace Tlapnet\Forge\Google;

use Contributte\Google\Calendar\Calendar;
use DateTime;

final class CalendarPlugin implements ICalendarPlugin, IPlugin
{

	/** @var Calendar */
	private $service;

	/** @var CalendarEventConverter */
	private $converter;

	public function __construct(Calendar $service, CalendarEventConverter $converter)
	{
		$this->service = $service;
		$this->converter = $converter;
	}

	public function insert(CalendarEvent $event): CalendarEvent
	{
		return $this->converter->fromGoogleEvent(
			$this->service->insert($this->converter->toGoogleEvent($event))
		);
	}

	/**
	 * @return CalendarEvent[]
	 */
	public function find(DateTime $from, DateTime $to, int $limit = 100): array
	{
		$calEvents = [];

		foreach ($this->service->find($from, $to, $limit) as $ge) {
			$calEvents[] = $this->converter->fromGoogleEvent($ge);
		}

		return $calEvents;
	}

	public function delete(string $eventId): bool
	{
		return $this->service->delete($eventId);
	}

	public function update(CalendarEvent $event): CalendarEvent
	{
		return $this->converter->fromGoogleEvent(
			$this->service->update($this->converter->toGoogleEvent($event))
		);
	}

}
