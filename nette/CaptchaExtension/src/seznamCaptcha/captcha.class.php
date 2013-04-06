<?php
/*
Licencováno pod MIT Licencí

© 2008 Seznam.cz, a.s.

Tímto se uděluje bezúplatná nevýhradní licence k oprávnění užívat Software,
časově i místně neomezená, v souladu s příslušnými ustanoveními autorského zákona.

Nabyvatel/uživatel, který obdržel kopii tohoto softwaru a další přidružené
soubory (dále jen „software“) je oprávněn k nakládání se softwarem bez
jakýchkoli omezení, včetně bez omezení práva software užívat, pořizovat si
z něj kopie, měnit, sloučit, šířit, poskytovat zcela nebo zčásti třetí osobě
(podlicence) či prodávat jeho kopie, za následujících podmínek:

- výše uvedené licenční ujednání musí být uvedeno na všech kopiích nebo
podstatných součástech Softwaru.

- software je poskytován tak jak stojí a leží, tzn. autor neodpovídá
za jeho vady, jakož i možné následky, ledaže věc nemá vlastnost, o níž autor
prohlásí, že ji má, nebo kterou si nabyvatel/uživatel výslovně vymínil.



Licenced under the MIT License

Copyright (c) 2008 Seznam.cz, a.s.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

DESCRIPTION
Trida pro praci s tzv. captchou (test pro odliseni lidi a stroju pomoci
obrazku ci zvuku)

AUTHOR
Josef Kyrian <josef.kyrian@firma.seznam.cz>

*/

/**
 * CLASS Captcha
 *
 * @author     Josef Kyrian <josef.kyrian@firma.seznam.cz>
 * @copyright  2008
 * @version    1.0
 */


// {{{ Captcha
/**
 * Hlavni trida zajistujici praci s captchou
 */
abstract class Captcha
{
	// {{{ properties

	/**
	 * Nastaveni server hostname
	 *
	 * @var string
	 */
	protected $_serverHostname;

	/**
	 * Nastaveni server port
	 *
	 * @var int
	 */
	protected $_serverPort;

	/**
	 * Nastaveni proxy hostname
	 *
	 * @var string
	 */
	protected $_proxyHostname;

	/**
	 * Nastaveni proxy port
	 *
	 * @var int
	 */
	protected $_proxyPort;

	/**
	 * Hash
	 *
	 * @var string
	 */
	protected $_hash;

	// }}}


	// {{{ __construct()
	/**
	* Konstruktor
	*
	* @param string $captchaHostname              nazev serveru s captchou
	* @param int $captchaPort                     port serveru s captchou
	*/
	public function __construct($captchaHostname, $captchaPort)
	{
		if (empty($captchaHostname)) {
			throw new Exception("Argument captchaHostname musi byt zadan");
		}
		if (!is_integer($captchaPort)) {
			throw new Exception("Argument captchaPort musi byt cele cislo");
		}
		
		$this->_serverHostname = $captchaHostname;
		$this->_serverPort = $captchaPort;
		
		$this->_proxyHostname = NULL;
		$this->_proxyPort = NULL;
		
		$this->_hash = NULL;
	}
	// }}}


	// {{{ create()
	/**
	* Vytvori novou captchu a vrati hash
	*/
	abstract public function create();
	// }}}


	// {{{ getImage()
	/**
	* Vrati captcha obrazek na zaklade hash
	*/
	abstract public function getImage($hash);
	// }}}


	// {{{ getAudio()
	/**
	* Vrati captcha zvuk na zaklade hash
	*/
	abstract public function getAudio($hash);
	// }}}


	// {{{ check()
	/**
	* Vrati zda-li kod zadany uzivatelem souhlasi s captchou identifikovanou danym hashem
	*  Pri chybnem zavolani teto funkce se hash zneplatni a je potreba znovu zavolat create
	*/
	abstract public function check($hash, $code);
	// }}}


	// {{{ setProxy()
	/**
	* Nastavi proxy
	*
	* @param string $hostname              nazev hostitele (NULL pro vypnuti proxy)
	* @param int $port                     port (NULL pro vypnuti proxy)
	*/
	public function setProxy($hostname, $port)
	{
		if (isset($hostname) || isset($port)) {
			if (empty($hostname)) {
				throw new Exception("Argument hostname musi byt zadan");
			}
			if (!is_integer($port)) {
				throw new Exception("Argument port musi byt cele cislo");
			}
		}
		
		$this->_proxyHostname = $hostname;
		$this->_proxyPort = $port;
	}
	// }}}
}
// }}}
?>
