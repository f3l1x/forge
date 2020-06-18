<?php declare(strict_types = 1);

namespace Tlapnet\Forge\Google;

use DateTime;

interface ICalendarPlugin
{

	/**
	 * @return CalendarEvent[]
	 */
	public function find(DateTime $from, DateTime $to, int $limit = 100): array;

	public function insert(CalendarEvent $event): CalendarEvent;

	public function delete(string $eventId): bool;

	public function update(CalendarEvent $event): CalendarEvent;

}
