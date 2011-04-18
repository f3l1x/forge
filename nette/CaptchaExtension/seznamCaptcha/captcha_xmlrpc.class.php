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
Captcha zalozena na komunikaci pomoci xmlrpc

AUTHOR
Josef Kyrian <josef.kyrian@firma.seznam.cz>

*/


/**
 * CLASS CaptchaXMLRPC
 *
 * @author     Josef Kyrian <josef.kyrian@firma.seznam.cz>
 * @copyright  2008
 * @version    1.0
 */


// {{{ CaptchaXMLRPC
/**
 * Hlavni trida zajistujici praci s captchou
 */
class CaptchaXMLRPC extends Captcha
{
	// {{{ _call()
	/**
	* Provede volani funkce na captcha server
	*
	* @param string $methodName               nazev metody
	* @param array $params                    parametry
	*
	* @return mixed    vysledek volani
	*/
	protected function _call($methodName, $params = array())
	{
		if (!function_exists('xmlrpc_encode_request')) {
			throw new Exception("PHP XMLRPC extension neni nainstalovana");
		}

		$ch = curl_init(sprintf('http://%s:%d', $this->_serverHostname, $this->_serverPort));
		if (!$ch) {
			throw new Exception("Chyba volani curl_init");
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		if ($this->_proxyHostname) {
			curl_setopt($ch, CURLOPT_PROXY, $this->_proxyHostname);
			curl_setopt($ch, CURLOPT_PROXYPORT, $this->_proxyPort);
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Content-Type: text/xml",
			"charset=UTF-8",
		));
		$request = xmlrpc_encode_request($methodName, $params, array('encoding' => 'UTF-8'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		$response = curl_exec($ch);
		if ($response === false) {
			throw new Exception("Chyba volani curl_exec");
		}
		$info = curl_getinfo($ch);
		if ($info['http_code'] != 200) {
			throw new Exception("Chyba volani curl_exec. HTTP status code ".$info['http_code']);
		}

		$response = xmlrpc_decode($response, 'UTF-8');

		if (empty($response) || xmlrpc_is_fault($response)) {
			throw new Exception(sprintf("XMLRPC error: %s", print_r($response, true)));
		}
		return $response;
	}
	// }}}


	// {{{ create()
	/**
	* Vytvori novou captchu a vrati hash
	*
	* @return string    hash
	*/
	public function create()
	{
		$result = $this->_call("captcha.create");

		if (empty($result) || $result['status'] != 200) {
			throw new Exception(sprintf("Chyba volani: %s", print_r($result, true)));
		}

		return $result['hash'];
	}
	// }}}


	// {{{ getImage()
	/**
	* Vrati captcha obrazek na zaklade hash
	*
	* @return string    binarni obrazkova data
	*/
	public function getImage($hash)
	{
		$result = $this->_call("captcha.getImage", array($hash));

		if (empty($result) || $result['status'] != 200) {
			throw new Exception(sprintf("Chyba volani: %s", print_r($result, true)));
		}

		return $result['data']->scalar;
	}
	// }}}


	// {{{ getAudio()
	/**
	* Vrati captcha zvuk na zaklade hash
	*
	* @return string    binarni audio data
	*/
	public function getAudio($hash)
	{
		$result = $this->_call("captcha.getAudio", array($hash));

		if (empty($result) || $result['status'] != 200) {
			throw new Exception(sprintf("Chyba volani: %s", print_r($result, true)));
		}

		return $result['data']->scalar;
	}
	// }}}


	// {{{ check()
	/**
	* Vrati zda-li kod zadany uzivatelem souhlasi s captchou identifikovanou danym hashem
	*  Pri chybnem zavolani teto funkce se hash zneplatni a je potreba znovu zavolat create
	*
	* @param string $hash                  hash
	* @param string $code                  kod
	*
	* @return boolean    zda-li kod souhlasi
	*/
	public function check($hash, $code)
	{
		$result = $this->_call("captcha.check", array($hash, $code));

		if (empty($result) || (
            $result['status'] != 200 &&
            $result['status'] != 402 &&
            $result['status'] != 403 &&
            $result['status'] != 404)) {
			throw new Exception(sprintf("Chyba volani: %s", print_r($result, true)));
		}

		return $result['status'] == 200;
	}
	// }}}
}
// }}}
?>
