<?php declare(strict_types = 1);

namespace Tests\Tlapnet\Forge\Unit\Latte;

use Nette\Utils\FileSystem;
use PHPUnit\Framework\TestCase;
use stdClass;
use Tlapnet\Forge\Latte\Tiny\Renderer;
use Tlapnet\Forge\Latte\Tiny\RendererFactory;
use Tlapnet\Forge\Latte\Tiny\TextProcessingRendererException;

final class RendererTest extends TestCase
{

	/** @var Renderer */
	private $renderer;

	public function setUp(): void
	{
		parent::setUp();

		FileSystem::createDir(__DIR__ . '/../../../temp/latte');
		$this->renderer = (new RendererFactory(__DIR__ . '/../../../temp/latte'))->create();
	}

	/**
	 * @dataProvider renderData
	 * @param mixed[] $parameters
	 */
	public function testRender(string $content, array $parameters, string $expected): void
	{
		$out = $this->renderer->render($content, $parameters);
		$this->assertEquals($expected, $out);
	}

	public function testRenderWhenStrictModeIsOn(): void
	{
		$this->expectException(TextProcessingRendererException::class);

		$this->renderer->setStrictMode(true);
		$this->renderer->render('string with missing {$name} variable', ['foo' => 'bar']);
	}

	public function testRenderWhenStrictModeIsOff(): void
	{
		$content = 'string with missing  variable';

		$this->renderer->setStrictMode(false);
		$this->assertEquals($content, $this->renderer->render($content, ['foo' => 'bar']));
	}

	public function testRenderFailsWhenUsingMacro(): void
	{
		$this->expectException(TextProcessingRendererException::class);
		$this->renderer->setStrictMode(true);

		$this->renderer->render('{spaceless}  something  {/spaceless}');
	}

	public function testRenderFailsWhenTryingToCallPhpFunction(): void
	{
		$content = '{strlen("some string")}';

		// should not fail, but return original string
		$this->renderer->setStrictMode(false);
		$this->assertEquals($content, $this->renderer->render($content));

		// should end with exception
		$this->expectException(TextProcessingRendererException::class);
		$this->renderer->setStrictMode(true);
		$this->renderer->render($content);
	}

	/**
	 * @return mixed[]
	 */
	public function renderData(): array
	{
		$user = new stdClass();
		$user->email = 'info@tlapnet.cz';
		$user->fullname = 'tlapnet';

		return [
			[
				'some latte compatible string with variable {$name}',
				['name' => 'Tlapnet'],
				'some latte compatible string with variable Tlapnet',
			],
			[
				'{$name} string with {$count} variables',
				['name' => 'Tlapnet', 'count' => 2],
				'Tlapnet string with 2 variables',
			],
			[
				'User email: "{$user->email}"',
				['user' => $user],
				'User email: "info@tlapnet.cz"',
			],
			[
				'User email: "{$user->email}", User fullname: {$user->fullname|upper}', // filters are ignored
				['user' => $user],
				'User email: "info@tlapnet.cz", User fullname: tlapnet',
			],
		];
	}

}
