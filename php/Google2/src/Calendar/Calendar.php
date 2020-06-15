<?php declare(strict_types = 1);

namespace Contributte\Google\Calendar;

use App\Model\Exception\Logic\InvalidArgumentException;
use Contributte\Google\Exception\Runtime\GoogleApiCallException;
use DateTime;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Exception;

final class Calendar
{

	public const GOOGLE_DATE_FORMAT = DateTime::RFC3339;

	/** @var Google_Service_Calendar */
	private $service;

	/** @var string */
	private $calendarId;

	public function __construct(Google_Service_Calendar $service, string $calendarId)
	{
		$this->service    = $service;
		$this->calendarId = $calendarId;
	}


	public function insert(Google_Service_Calendar_Event $event): Google_Service_Calendar_Event
	{
		try {
			return $this->service->events->insert($this->calendarId, $event);
		} catch (Google_Service_Exception $e) {
			throw new GoogleApiCallException(
				'Could not insert new calendar event. Error: ' . $e->getMessage(),
				$e->getCode(),
				$e
			);
		}
	}

	/**
	 * @return Google_Service_Calendar_Event[]
	 */
	public function find(DateTime $from, DateTime $to, int $limit = 100): array
	{
		try {
			$result = $this->service->events->listEvents(
				$this->calendarId,
				[
					'timeMin'      => $from->format(self::GOOGLE_DATE_FORMAT),
					'timeMax'      => $to->format(self::GOOGLE_DATE_FORMAT),
					'maxResults'   => $limit,
					'orderBy'      => 'startTime',
					'singleEvents' => TRUE,
				]
			);

			return $result->getItems();

		} catch (Google_Service_Exception $e) {
			throw new GoogleApiCallException(
				'Could not list calendar events. Error: ' . $e->getMessage(),
				$e->getCode(),
				$e
			);
		}
	}

	public function delete(string $eventId): bool
	{
		try {
			$this->service->events->delete($this->calendarId, $eventId);

			return TRUE;
		} catch (Google_Service_Exception $e) {
			throw new GoogleApiCallException(
				sprintf('Could not delete calendar event id=%s. Error: %s', $eventId, $e->getMessage()),
				$e->getCode(),
				$e
			);
		}
	}

	public function update(Google_Service_Calendar_Event $event): Google_Service_Calendar_Event
	{
		if (empty($event->getId())) {
			throw new InvalidArgumentException('Cannot update calendar event without ID');
		}

		try {
			return $this->service->events->update($this->calendarId, $event->getId(), $event);
		} catch (Google_Service_Exception $e) {
			throw new GoogleApiCallException(
				sprintf('Could not delete calendar event id=%s. Error: %s', $event->getId(), $e->getMessage()),
				$e->getCode(),
				$e
			);
		}
	}

}
