<?php declare(strict_types = 1);

namespace Tlapnet\Forge\Google;

use DateTime;

final class CalendarEvent
{

	/** @var string */
	private $id = '';

	/** @var string */
	private $title = '';

	/** @var DateTime */
	private $end;

	/** @var DateTime */
	private $start;

	/** @var string */
	private $description = '';

	/** @var string */
	private $location = '';

	public function __construct()
	{
		$this->start = new DateTime();
		$this->end = new DateTime();
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function setId(string $id): self
	{
		$this->id = $id;

		return $this;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function setTitle(string $title): self
	{
		$this->title = $title;

		return $this;
	}

	public function getEnd(): DateTime
	{
		return $this->end;
	}

	public function setEnd(DateTime $end): self
	{
		$this->end = $end;

		return $this;
	}

	public function getStart(): DateTime
	{
		return $this->start;
	}

	public function setStart(DateTime $start): self
	{
		$this->start = $start;

		return $this;
	}

	public function getDescription(): string
	{
		return $this->description;
	}

	public function setDescription(string $description): self
	{
		$this->description = $description;

		return $this;
	}

	public function getLocation(): string
	{
		return $this->location;
	}

	public function setLocation(string $location): self
	{
		$this->location = $location;

		return $this;
	}

}
