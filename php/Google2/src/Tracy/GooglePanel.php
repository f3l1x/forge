<?php declare(strict_types = 1);

namespace Contributte\Google\Tracy;

use Contributte\Google\Sso;
use Tracy\IBarPanel;

final class GooglePanel implements IBarPanel
{

	/** @var Sso */
	private $sso;

	public function __construct(Sso $sso)
	{
		$this->sso = $sso;
	}

	/**
	 * Renders HTML code for Google tab.
	 */
	public function getTab(): string
	{
		return '<span title="Google panel">'
			. '<img height="16px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAADNElEQVQ4T2NkwAP+rwpl/vbOxv3fj+8m/xn+sTOwsN1nZP6/iTez9BUubYzYJL7MnKz7+/GDOb+vXjRh+PSRCUUNMzMDs5rmKzYNrVbenNJJ6PoxDPzc2zrt2/6dGYzfv2O1DNkAVmOLW4wKmhYCWVnvYeIomj60VG/9tX+XF75gQJETFvrL4+ptw5WadwLDwE/9rR0/tmwoR9HAzsHAoqt3k0VY9CgjM+vX/58/6fy8c936//PnbAzCQn85HT1ceDMLDyDrAbvw644qyS8zTjxh/PwZHl4squof2U3MHLlT8s4ja/g/aRL7h88v17KIinfzpuUdxBqGf67ErPv36kHgp+kMDP/e/WRgkpX7zuboKMsXn/OWaO9DFYJd+PO44Wemr1d4GFllGb5sUWdgkndJ5sspnkeqYSD1jP+fNXD9ud75leH/H7D+f5waP9itL3OiG1ay9Ovtz98YRXCmP+b//2Ykcokw/r9bb/LnfttpmML/AnYP2Ez2KqJrjJn+5cezdwzs+FwdY86ijGkgr/1DNvM9CuQYGG7Dqgf1ctdXhv+/wWZ849T6wW99EcPLGXO/vXn39S8/skUfvjGy/PmLEIm25+YDR8qvE0afGL9c5n3AqstQ8cmUwVrGPKHIMGkhPu817P/Pcf78l6+fvzOCk5oYL8PvFXk8bGAD/1xJXLv3w9eglhfMDN///GJQ4JP+5qBoLJejGY8z2bRt/L58z5W/ETBLTRSZr3RFceqCDTxxb7Z4zcWjzz78RCRsNT65j6Ziuk6FJknnUFz6n4Gxd+/9CTtPi+b9+YeQCTJjDc9xZV8Fz8ttp6a3r7u3pwJZMzszG4O+kNptUW7h40xMLF+//fqmeufjQ6vnX19z6bEmMNy6ZgNWbizHeLc7llsFnA6RDag9NnHL9keHvIlN0Eb8jgy/nkR9s5VnV012436GYSBIoPX0jCk7HxzO+vb3B8HiS1dY7ZWWmKFFqX7YfZgjsGqadG6J1uNvz+ZefHvL9N3398zILmZmZGZQE1R8py2kPK3COK2OgZHhP7I8flf8Z2CcdnmZ3dc/343//2fg4GBie8jDw74rSTXsNa5gAQB0YT2EBXslkgAAAABJRU5ErkJggg=="/>'
			. '</span>';
	}

	/**
	 * Renders HTML code for Google panel.
	 */
	public function getPanel(): string
	{
		ob_start();

		$sso = $this->sso;
		require __DIR__ . '/templates/panel.phtml';

		return ob_get_clean();
	}

}
