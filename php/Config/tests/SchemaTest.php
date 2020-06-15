<?php declare(strict_types = 1);

namespace Tests\Tlapnet\Forge\Unit\Config;

use Nette\InvalidStateException;
use Nette\Utils\AssertionException;
use PHPUnit\Framework\TestCase;
use Tlapnet\Forge\Config\Node;
use Tlapnet\Forge\Config\Schema;

class SchemaTest extends TestCase
{

	public function testUnknownOptions(): void
	{
		$this->expectException(InvalidStateException::class);
		$this->expectExceptionMessage('Unknown configuration option email, foo');

		Schema::root()
			->validate(['email' => 'foo@bar.baz', 'foo' => 1]);
	}

	public function testStringValidator(): void
	{
		$this->expectException(AssertionException::class);
		$this->expectExceptionMessage('The variable "email" expects to be string, int 25 given.');

		Schema::root()
			->add(Node::create('email')->isString())
			->validate(['email' => 25]);
	}

	public function testIntegerValidator(): void
	{
		$this->expectException(AssertionException::class);
		$this->expectExceptionMessage("The variable \"count\" expects to be int, string '25' given.");

		Schema::root()
			->add(Node::create('count')->isInt())
			->validate(['count' => '25']);
	}

	public function testArrayValidator(): void
	{
		$this->expectException(AssertionException::class);
		$this->expectExceptionMessage('The variable "data" expects to be array, int 25 given.');

		Schema::root()
			->add(Node::create('data')->isArray())
			->validate(['data' => 25]);
	}

	public function testFloatValidator(): void
	{
		$this->expectException(AssertionException::class);
		$this->expectExceptionMessage('The variable "count" expects to be float, int 1 given.');

		Schema::root()
			->add(Node::create('count')->isFloat())
			->validate(['count' => 1]);
	}

	public function testChildrenValidator1(): void
	{
		$this->expectException(AssertionException::class);
		$this->expectExceptionMessage('The variable "students" expects to be array, int 1 given.');

		Schema::root()
			->add(Node::create('students')->children([
				Node::create('name')->isString(),
			]))
			->validate(['students' => 1]);
	}

	public function testChildrenValidator2(): void
	{
		$this->expectException(AssertionException::class);
		$this->expectExceptionMessage('The variable "name" expects to be string, int 1 given.');

		Schema::root()
			->add(Node::create('students')->children([
				Node::create('name')->isString(),
			]))
			->validate(['students' => [['name' => 1]]]);
	}

	public function testNestedValidator1(): void
	{
		$this->expectException(AssertionException::class);
		$this->expectExceptionMessage('The variable "address" expects to be array, int 1 given.');

		Schema::root()
			->add(Node::create('address')->nested([
				Node::create('street')->isString(),
			]))
			->validate(['address' => 1]);
	}

	public function testNestedValidator2(): void
	{
		$this->expectException(AssertionException::class);
		$this->expectExceptionMessage('The variable "street" expects to be string, int 1 given.');

		Schema::root()
			->add(Node::create('address')->nested([
				Node::create('street')->isString(),
			]))
			->validate(['address' => ['street' => 1]]);
	}

	public function testSuccess(): void
	{
		$data = Schema::root()
			->add(Node::create('url1')->isString())
			->add(Node::create('url2')->isString()->setDefault('www.foo.baz2'))
			->add(Node::create('url3')->isString()->nullable()->setDefault('www.foo.baz3'))
			->process([
				'url1' => 'www.foo.bar1',
				'url3' => null,
			]);

		$this->assertSame('www.foo.bar1', $data['url1']);
		$this->assertSame('www.foo.baz2', $data['url2']);
		$this->assertNull($data['url3']);
	}

	public function testSuccessWithChildren(): void
	{
		$data = Schema::root()
			->add(Node::create('students')->children([
				Node::create('name')->isString(),
				Node::create('surname')->isString()->setDefault('Doe'),
			]))
			->process(['students' => [['name' => 'John']]]);

		$this->assertSame('John', $data['students'][0]['name']);
		$this->assertSame('Doe', $data['students'][0]['surname']);

		$data = Schema::root()
			->add(Node::create('students1')->children([
				Node::create('students2')->children([
					Node::create('name')->isString(),
					Node::create('surname')->isString()->setDefault('Doe'),
				]),
			]))
			->process(['students1' => [['students2' => [['name' => 'John']]]]]);

		$this->assertSame('John', $data['students1'][0]['students2'][0]['name']);
		$this->assertSame('Doe', $data['students1'][0]['students2'][0]['surname']);
	}

	public function testSuccessWithNesting(): void
	{
		$data = Schema::root()
			->add(Node::create('address')->nested([
				Node::create('street')->isString(),
				Node::create('zip')->isInt()->setDefault(12345),
			]))
			->process(['address' => ['street' => 'Prague']]);

		$this->assertSame('Prague', $data['address']['street']);
		$this->assertSame(12345, $data['address']['zip']);

		$data = Schema::root()
			->add(Node::create('address1')->nested([
				Node::create('address2')->nested([
					Node::create('street')->isString(),
					Node::create('zip')->isInt()->setDefault(12345),
				]),
			]))
			->process(['address1' => ['address2' => ['street' => 'Prague']]]);

		$this->assertSame('Prague', $data['address1']['address2']['street']);
		$this->assertSame(12345, $data['address1']['address2']['zip']);
	}

	public function testSuccessWithNestingAndChildren(): void
	{
		$data = Schema::root()
			->add(Node::create('students')->children([
				Node::create('address')->nested([
					Node::create('street')->isString(),
					Node::create('zip')->isInt()->setDefault(12345),
				]),
			]))
			->process(['students' => [['address' => ['street' => 'Prague']]]]);

		$this->assertSame('Prague', $data['students'][0]['address']['street']);
		$this->assertSame(12345, $data['students'][0]['address']['zip']);
	}

}
