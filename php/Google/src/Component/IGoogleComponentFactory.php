<?php declare(strict_types = 1);

namespace Contributte\Google\Component;

interface IGoogleComponentFactory
{

	public function create(): GoogleComponent;

}
