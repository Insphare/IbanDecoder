<?php

/**
 * @author Manuel Will <insphare@gmail.com>
 * @copyright Manuel Will <insphare@gmail.com>
 *
 * Class IbanDecoder
 *
 * Decodes the bankcode.
 */
class IbanDecoder {

	/**
	 * @var null|string
	 */
	private $internationalBankAccountNumber = null;

	/**
	 * AD, BE, ... Länderkennzeichen
	 * pp    zweistellige Prüfsumme
	 * b     Stelle der Bankleitzahl
	 * d     Kontotyp
	 * k     Stelle der Kontonummer
	 * K     Kontrollziffern
	 * r     Regionalcode
	 * s     Stelle der Filialnummer (Branch Code / code guichet)
	 * O     Besitzernummer
	 * X     sonstige Funktionen
	 *
	 * @var array
	 */
	private $countryDefinition = array(
		'Ägypten' => array(
			'length' => 27,
			'rule' => 'EGpp kkkk kkkk kkkk kkkk kkkk kkk'
		),
		'Albanien' => array(
			'length' => 28,
			'rule' => 'ALpp bbbs sssK kkkk kkkk kkkk kkkk'
		),
		'Algerien' => array(
			'length' => 24,
			'rule' => 'DZpp kkkk kkkk kkkk kkkk kkkk'
		),
		'Andorra' => array(
			'length' => 24,
			'rule' => 'ADpp bbbb ssss kkkk kkkk kkkk'
		),
		'Angola' => array(
			'length' => 25,
			'rule' => 'AOpp bbbb ssss kkkk kkkk kkkK K'
		),
		'Aserbaidschan' => array(
			'length' => 28,
			'rule' => 'AZpp bbbb kkkk kkkk kkkk kkkk kkkk'
		),
		'Bahrain' => array(
			'length' => 22,
			'rule' => 'BHpp bbbb kkkk kkkk kkkk kk'
		),
		'Belgien' => array(
			'length' => 16,
			'rule' => 'BEpp bbbk kkkk kkKK'
		),
		'Benin' => array(
			'length' => 28,
			'rule' => 'BJpp bbbb bsss sskk kkkk kkkk kkKK'
		),
		'Bosnien und Herzegowina' => array(
			'length' => 20,
			'rule' => 'BApp bbbs sskk kkkk kkKK'
		),
		'Brasilien' => array(
			'length' => 29,
			'rule' => 'BRpp bbbb bbbb ssss skkk kkkk kkkd O'
		),
		'Britische Jungferninseln' => array(
			'length' => 24,
			'rule' => 'VGpp bbbb kkkk kkkk kkkk kkkk'
		),
		'Bulgarien' => array(
			'length' => 22,
			'rule' => 'BGpp bbbb ssss ddkk kkkk kk'
		),
		'Burkina Faso' => array(
			'length' => 27,
			'rule' => 'BFpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Burundi' => array(
			'length' => 16,
			'rule' => 'BIpp kkkk kkkk kkkk'
		),
		'Costa Rica' => array(
			'length' => 21,
			'rule' => 'CRpp bbbk kkkk kkkk kkkk k'
		),
		'Côte d\'Ivoire (Elfenbeinküste)' => array(
			'length' => 28,
			'rule' => 'CIpp bbbb bsss sskk kkkk kkkk kkKK'
		),
		'Dänemark' => array(
			'length' => 18,
			'rule' => 'DKpp bbbb kkkk kkkk kK'
		),
		'Deutschland' => array(
			'length' => 22,
			'rule' => 'DEpp bbbb bbbb kkkk kkkk kk'
		),
		'Dominikanische Republik' => array(
			'length' => 28,
			'rule' => 'DOpp bbbb kkkk kkkk kkkk kkkk kkkk'
		),
		'Estland' => array(
			'length' => 20,
			'rule' => 'EEpp bbkk kkkk kkkk kkkK'
		),
		'Färöer' => array(
			'length' => 18,
			'rule' => 'FOpp bbbb kkkk kkkk kK'
		),
		'Finnland' => array(
			'length' => 18,
			'rule' => 'FIpp bbbb bbkk kkkk kK'
		),
		'Frankreich' => array(
			'length' => 27,
			'rule' => 'FRpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Französisch-Guayana' => array(
			'length' => 27,
			'rule' => 'FRpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Französisch-Polynesien' => array(
			'length' => 27,
			'rule' => 'FRpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Französische Süd- und Antarktisgebiete' => array(
			'length' => 27,
			'rule' => 'FRpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Guadeloupe' => array(
			'length' => 27,
			'rule' => 'FRpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Martinique' => array(
			'length' => 27,
			'rule' => 'FRpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Réunion' => array(
			'length' => 27,
			'rule' => 'FRpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Mayotte' => array(
			'length' => 27,
			'rule' => 'FRpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Neukaledonien' => array(
			'length' => 27,
			'rule' => 'FRpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Saint-Barthélemy' => array(
			'length' => 27,
			'rule' => 'FRpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Saint-Martin' => array(
			'length' => 27,
			'rule' => 'FRpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Saint-Pierre und Miquelon' => array(
			'length' => 27,
			'rule' => 'FRpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Wallis und Futuna' => array(
			'length' => 27,
			'rule' => 'FRpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Gabun' => array(
			'length' => 27,
			'rule' => 'GApp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Georgien' => array(
			'length' => 22,
			'rule' => 'GEpp bbkk kkkk kkkk kkkk kk'
		),
		'Gibraltar' => array(
			'length' => 23,
			'rule' => 'GIpp bbbb kkkk kkkk kkkk kkk'
		),
		'Griechenland' => array(
			'length' => 27,
			'rule' => 'GRpp bbbs sssk kkkk kkkk kkkk kkk'
		),
		'Grönland' => array(
			'length' => 18,
			'rule' => 'GLpp bbbb kkkk kkkk kK'
		),
		'Guatemala' => array(
			'length' => 28,
			'rule' => 'GTpp bbbb kkkk kkkk kkkk kkkk kkkk'
		),
		'Iran' => array(
			'length' => 26,
			'rule' => 'IRpp kkkk kkkk kkkk kkkk kkkk kk'
		),
		'Irland' => array(
			'length' => 22,
			'rule' => 'IEpp bbbb ssss sskk kkkk kk'
		),
		'Island' => array(
			'length' => 26,
			'rule' => 'ISpp bbbb sskk kkkk XXXX XXXX XX'
		),
		'Israel' => array(
			'length' => 23,
			'rule' => 'ILpp bbbs sskk kkkk kkkk kkk'
		),
		'Italien' => array(
			'length' => 27,
			'rule' => 'ITpp Kbbb bbss sssk kkkk kkkk kkk'
		),
		'Jordanien' => array(
			'length' => 30,
			'rule' => 'JOpp bbbb ssss kkkk kkkk kkkk kkkk kk'
		),
		'Kamerun' => array(
			'length' => 27,
			'rule' => 'CMpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Kap Verde' => array(
			'length' => 25,
			'rule' => 'CVpp bbbb ssss kkkk kkkk kkkK K'
		),
		'Kasachstan' => array(
			'length' => 20,
			'rule' => 'KZpp bbbk kkkk kkkk kkkk'
		),
		'Katar' => array(
			'length' => 29,
			'rule' => 'QApp bbbb kkkk kkkk kkkk kkkk kkkk k'
		),
		'Kongo (Brazzaville)' => array(
			'length' => 27,
			'rule' => 'CGpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Kosovo' => array(
			'length' => 20,
			'rule' => 'XKpp bbbb kkkk kkkk kkkk'
		),
		'Kroatien' => array(
			'length' => 21,
			'rule' => 'HRpp bbbb bbbk kkkk kkkk k'
		),
		'Kuwait' => array(
			'length' => 30,
			'rule' => 'KWpp bbbb kkkk kkkk kkkk kkkk kkkk kk'
		),
		'Lettland' => array(
			'length' => 21,
			'rule' => 'LVpp bbbb kkkk kkkk kkkk k'
		),
		'Libanon' => array(
			'length' => 28,
			'rule' => 'LBpp bbbb kkkk kkkk kkkk kkkk kkkk'
		),
		'Liechtenstein' => array(
			'length' => 21,
			'rule' => 'LIpp bbbb bkkk kkkk kkkk k'
		),
		'Litauen' => array(
			'length' => 20,
			'rule' => 'LTpp bbbb bkkk kkkk kkkk'
		),
		'Luxemburg' => array(
			'length' => 20,
			'rule' => 'LUpp bbbk kkkk kkkk kkkk'
		),
		'Madagaskar' => array(
			'length' => 27,
			'rule' => 'MGpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Mali' => array(
			'length' => 28,
			'rule' => 'MLpp bbbb bsss sskk kkkk kkkk kkKK'
		),
		'Malta' => array(
			'length' => 31,
			'rule' => 'MTpp bbbb ssss skkk kkkk kkkk kkkk kkk'
		),
		'Mauretanien' => array(
			'length' => 27,
			'rule' => 'MRpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Mauritius' => array(
			'length' => 30,
			'rule' => 'MUpp bbbb bbss kkkk kkkk kkkk kkkK KK'
		),
		'Mazedonien' => array(
			'length' => 19,
			'rule' => 'MKpp bbbk kkkk kkkk kKK'
		),
		'Moldawien' => array(
			'length' => 24,
			'rule' => 'MDpp bbkk kkkk kkkk kkkk kkkk'
		),
		'Monaco' => array(
			'length' => 27,
			'rule' => 'MCpp bbbb bsss sskk kkkk kkkk kKK'
		),
		'Montenegro' => array(
			'length' => 22,
			'rule' => 'MEpp bbbk kkkk kkkk kkkk KK'
		),
		'Mosambik' => array(
			'length' => 25,
			'rule' => 'MZpp bbbb ssss kkkk kkkk kkkK K'
		),
		'Niederlande' => array(
			'length' => 18,
			'rule' => 'NLpp bbbb kkkk kkkk kk'
		),
		'Norwegen' => array(
			'length' => 15,
			'rule' => 'NOpp bbbb kkkk kkK'
		),
		'Österreich' => array(
			'length' => 20,
			'rule' => 'ATpp bbbb bkkk kkkk kkkk'
		),
		'Osttimor' => array(
			'length' => 23,
			'rule' => 'TLpp bbbk kkkk kkkk kkkk kKK'
		),
		'Pakistan' => array(
			'length' => 24,
			'rule' => 'PKpp bbbb rrkk kkkk kkkk kkkk'
		),
		'Palästinensische Autonomiegebiete' => array(
			'length' => 29,
			'rule' => 'PSpp bbbb rrrr rrrr rkkk kkkk kkkk k'
		),
		'Polen' => array(
			'length' => 28,
			'rule' => 'PLpp bbbs sssK kkkk kkkk kkkk kkkk'
		),
		'Portugal' => array(
			'length' => 25,
			'rule' => 'PTpp bbbb ssss kkkk kkkk kkkK K'
		),
		'Rumänien' => array(
			'length' => 24,
			'rule' => 'ROpp bbbb kkkk kkkk kkkk kkkk'
		),
		'San Marino' => array(
			'length' => 27,
			'rule' => 'SMpp Kbbb bbss sssk kkkk kkkk kkk'
		),
		'São Tomé und Príncipe' => array(
			'length' => 25,
			'rule' => 'STpp bbbb ssss kkkk kkkk kkkK K'
		),
		'Saudi-Arabien' => array(
			'length' => 24,
			'rule' => 'SApp bbkk kkkk kkkk kkkk kkkk'
		),
		'Schweden' => array(
			'length' => 24,
			'rule' => 'SEpp bbbk kkkk kkkk kkkk kkkK'
		),
		'Schweiz' => array(
			'length' => 21,
			'rule' => 'CHpp bbbb bkkk kkkk kkkk k'
		),
		'Senegal' => array(
			'length' => 28,
			'rule' => 'SNpp bbbb bsss sskk kkkk kkkk kkKK'
		),
		'Serbien' => array(
			'length' => 22,
			'rule' => 'RSpp bbbk kkkk kkkk kkkk KK'
		),
		'Slowakei' => array(
			'length' => 24,
			'rule' => 'SKpp bbbb ssss sskk kkkk kkkk'
		),
		'Slowenien' => array(
			'length' => 19,
			'rule' => 'SIpp bbss skkk kkkk kKK'
		),
		'Spanien' => array(
			'length' => 24,
			'rule' => 'ESpp bbbb ssss KKkk kkkk kkkk'
		),
		'Tschechien' => array(
			'length' => 24,
			'rule' => 'CZpp bbbb kkkk kkkk kkkk kkkk'
		),
		'Tunesien' => array(
			'length' => 24,
			'rule' => 'TNpp bbss skkk kkkk kkkk kkKK'
		),
		'Türkei' => array(
			'length' => 26,
			'rule' => 'TRpp bbbb brkk kkkk kkkk kkkk kk'
		),
		'Ungarn' => array(
			'length' => 28,
			'rule' => 'HUpp bbbs sssK kkkk kkkk kkkk kkkK'
		),
		'Vereinigte Arabische Emirate' => array(
			'length' => 23,
			'rule' => 'AEpp bbbk kkkk kkkk kkkk kkk'
		),
		'Vereinigtes Königreich' => array(
			'length' => 22,
			'rule' => 'GBpp bbbb ssss sskk kkkk kk'
		),
		'Jersey' => array(
			'length' => 22,
			'rule' => 'GBpp bbbb ssss sskk kkkk kk'
		),
		'Guernsey' => array(
			'length' => 22,
			'rule' => 'GBpp bbbb ssss sskk kkkk kk'
		),
		'Isle of Man' => array(
			'length' => 22,
			'rule' => 'GBpp bbbb ssss sskk kkkk kk'
		),
		'Zypern' => array(
			'length' => 28,
			'rule' => 'CYpp bbbs ssss kkkk kkkk kkkk kkkk'
		),
		'Zentralafrikanische Republik' => array(
			'length' => 27,
			'rule' => 'CFpp bbbb bsss sskk kkkk kkkk kKK'
		),
	);

	/**
	 * Alphabet position number + 9
	 *
	 * @var array
	 */
	private $charMap = array(
		'A' => 10,
		'B' => 11,
		'C' => 12,
		'D' => 13,
		'E' => 14,
		'F' => 15,
		'G' => 16,
		'H' => 17,
		'I' => 18,
		'J' => 19,
		'K' => 20,
		'L' => 21,
		'M' => 22,
		'N' => 23,
		'O' => 24,
		'P' => 25,
		'Q' => 26,
		'R' => 27,
		'S' => 28,
		'T' => 29,
		'U' => 30,
		'V' => 31,
		'W' => 32,
		'X' => 33,
		'Y' => 34,
		'Z' => 35,
	);

	/**
	 * @param string $iban
	 */
	public function __construct($iban) {
		$this->internationalBankAccountNumber = (string)$iban;
	}

	/**
	 * @param string $iban
	 */
	private function trimAndRemoveWhiteSpace(&$iban) {
		$iban = preg_replace('~\s~', '', trim($iban));
	}

	/**
	 * @param string $iban
	 */
	private function removeCountryAndCheckSum(&$iban) {
		$iban = preg_replace('~^[A-Z]{2}(pp|\d{2})(.+)~', '$2', trim($iban));
	}

	/**
	 * @param string $searchPattern
	 * @return string
	 */
	private function extract($searchPattern) {
		$iban = $this->getFilteredIban();

		foreach ($this->countryDefinition as $config) {
			$definition = $config['rule'];
			$originDefinition = $definition;
			$this->trimAndRemoveWhiteSpace($definition);
			$this->removeCountryAndCheckSum($definition);

			if (substr($this->internationalBankAccountNumber, 0, 2) !== substr($originDefinition, 0, 2)) {
				continue;
			}

			$posStart = strpos($definition, $searchPattern);
			$posEnd = strrpos($definition, $searchPattern);

			if (false === $posEnd || false === $posStart) {
				continue;
			}

			return substr($iban, $posStart, ($posEnd - $posStart + 1));
		}

		return null;
	}

	/**
	 * @return string
	 */
	public function getBankCode() {
		return $this->extract('b');
	}

	/**
	 * @return string
	 */
	public function getAccountNumber() {
		return $this->extract('k');
	}

	/**
	 * @return string
	 */
	public function getBranchCode() {
		return $this->extract('s');
	}

	/**
	 * @return string
	 */
	public function getAccountType() {
		return $this->extract('d');
	}

	/**
	 * @return string
	 */
	public function geOwnerNumber() {
		return $this->extract('O');
	}

	/**
	 * @return string
	 */
	public function getCountryIso() {
		return substr($this->internationalBankAccountNumber, 0, 2);
	}

	/**
	 * @return int|null|string
	 */
	public function getCountryName() {
		foreach ($this->countryDefinition as $countryName => $config) {
			$definition = $config['rule'];
			if (substr($this->internationalBankAccountNumber, 0, 2) === substr($definition, 0, 2)) {
				return $countryName;
			}
		}

		return null;
	}

	/**
	 * @return string
	 */
	public function getCheckSumFromGivenIban() {
		$iban = $this->internationalBankAccountNumber;
		$this->trimAndRemoveWhiteSpace($iban);
		return substr($iban, 2, 2);
	}

	/**
	 * @param string $value
	 * @return string
	 */
	private function moduloIban($value) {
		$iban = strtr($value, $this->charMap);
		$len = strlen($iban);
		$residualValue = '';
		$currentPos = 0;
		while (true) {
			$forwardStep = ($currentPos === 0 ? 9 : 7);
			$usagePartString = $residualValue . substr($iban, $currentPos, $forwardStep);
			$residualValue = str_pad((int)bcmod($usagePartString, 97), 2, 0, STR_PAD_LEFT);
			$currentPos += $forwardStep;

			if ($currentPos >= $len) {
				break;
			}
		}

		return $residualValue;
	}

	/**
	 * @return string
	 */
	public function calculateCheckSum() {
		$iban = $this->getFilteredIban();
		$countryIso = $this->getCountryIso();
		$iban .= $countryIso . '00';
		$residualValue = $this->moduloIban($iban);
		return str_pad((int)bcsub(98, $residualValue), 2, 0, STR_PAD_LEFT);
	}

	/**
	 * @return bool
	 */
	public function isCheckSumValid() {
		$iban = $this->internationalBankAccountNumber;
		$this->trimAndRemoveWhiteSpace($iban);
		$fourDigits = substr($iban, 0, 4);
		$this->removeCountryAndCheckSum($iban);
		$iban .= $fourDigits;
		$residualValue = (int)$this->moduloIban($iban); // have to be 1

		return ($residualValue === 1 && $this->getCheckSumFromGivenIban() === $this->calculateCheckSum());
	}

	/**
	 * Checks whether the iban is valid. Checks the length of iban and the checksum.
	 *
	 * @return bool
	 */
	public function isValid() {
		return (true === ($this->isCheckSumValid() && $this->checkLengthIsValid()));
	}

	/**
	 * @return bool
	 */
	public function checkLengthIsValid() {
		$iban = $this->internationalBankAccountNumber;
		$this->trimAndRemoveWhiteSpace($iban);

		foreach ($this->countryDefinition as $countryName => $config) {
			$definition = $config['rule'];
			if (substr($this->internationalBankAccountNumber, 0, 2) === substr($definition, 0, 2)) {
				return (strlen($iban) === (int)$config['length']);
			}
		}

		return false;
	}

	/**
	 * @return null|string
	 */
	private function getFilteredIban() {
		$iban = $this->internationalBankAccountNumber;
		$this->trimAndRemoveWhiteSpace($iban);
		$this->removeCountryAndCheckSum($iban);

		return $iban;
	}
}

