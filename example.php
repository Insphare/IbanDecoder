<?php

require_once 'IbanDecoder.php';

// examples from http://www.rbs.co.uk/corporate/international/g0/guide-to-international-business/regulatory-information/iban/iban-example.ashx

$example = array(
	'Albania' => 'AL47 2121 1009 0000 0002 3569 8741',
	'Andorra' => 'AD12 0001 2030 2003 5910 0100',
	'Austria' => 'AT61 1904 3002 3457 3201',
	'Azerbaijan' => 'AZ21 NABZ 0000 0000 1370 1000 1944',
	'Bahrain' => 'BH67 BMAG 0000 1299 1234 56',
	'Belgium' => 'BE62 5100 0754 7061',
	'Bosnia and Herzegovina' => 'BA39 1290 0794 0102 8494',
	'Brazil' => 'BR97 0036 0305 0000 1000 9795 493P 1',
	'Bulgaria' => 'BG80 BNBG 9661 1020 3456 78',
	'Croatia' => 'HR12 1001 0051 8630 0016 0',
	'Cyprus' => 'CY17 0020 0128 0000 0012 0052 7600',
	'Czech Republic' => 'CZ65 0800 0000 1920 0014 5399',
	'Denmark' => 'DK50 0040 0440 1162 43',
	'Estonia' => 'EE38 2200 2210 2014 5685',
	'Faroe Islands' => 'FO97 5432 0388 8999 44',
	'Finland' => 'FI21 1234 5600 0007 85',
	'France' => 'FR14 2004 1010 0505 0001 3M02 606',
	'Georgia' => 'GE29 NB00 0000 0101 9049 17',
	'Germany' => 'DE89 3704 0044 0532 0130 00',
	'Gibraltar' => 'GI75 NWBK 0000 0000 7099 453',
	'Greece' => 'GR16 0110 1250 0000 0001 2300 695',
	'Greenland' => 'GL56 0444 9876 5432 10',
	'Hungary' => 'HU42 1177 3016 1111 1018 0000 0000',
	'Iceland' => 'IS14 0159 2600 7654 5510 7303 39',
	'Ireland' => 'IE29 AIBK 9311 5212 3456 78',
	'Israel' => 'IL62 0108 0000 0009 9999 999',
	'Italy' => 'IT40 S054 2811 1010 0000 0123 456',
	'Jordan' => 'JO94 CBJO 0010 0000 0000 0131 0003 02',
	'Kuwait' => 'KW81 CBKU 0000 0000 0000 1234 5601 01',
	'Latvia' => 'LV80 BANK 0000 4351 9500 1',
	'Lebanon' => 'LB62 0999 0000 0001 0019 0122 9114',
	'Liechtenstein' => 'LI21 0881 0000 2324 013A A',
	'Lithuania' => 'LT12 1000 0111 0100 1000',
	'Luxembourg' => 'LU28 0019 4006 4475 0000',
	'Macedonia' => 'MK072 5012 0000 0589 84',
	'Malta' => 'MT84 MALT 0110 0001 2345 MTLC AST0 01S',
	'Mauritius' => 'MU17 BOMM 0101 1010 3030 0200 000M UR',
	'Moldova' => 'MD24 AG00 0225 1000 1310 4168',
	'Monaco' => 'MC93 2005 2222 1001 1223 3M44 555',
	'Montenegro' => 'ME25 5050 0001 2345 6789 51',
	'Netherlands' => 'NL39 RABO 0300 0652 64',
	'Norway' => 'NO93 8601 1117 947',
	'Pakistan' => 'PK36 SCBL 0000 0011 2345 6702',
	'Poland' => 'PL60 1020 1026 0000 0422 7020 1111',
	'Portugal' => 'PT50 0002 0123 1234 5678 9015 4',
	'Qatar' => 'QA58 DOHB 0000 1234 5678 90AB CDEF G',
	'Romania' => 'RO49 AAAA 1B31 0075 9384 0000',
	'San Marino' => 'SM86 U032 2509 8000 0000 0270 100',
	'Saudi Arabia' => 'SA03 8000 0000 6080 1016 7519',
	'Serbia' => 'RS35 2600 0560 1001 6113 79',
	'Slovak Republic' => 'SK31 1200 0000 1987 4263 7541',
	'Slovenia' => 'SI56 1910 0000 0123 438',
	'Spain' => 'ES80 2310 0001 1800 0001 2345',
	'Sweden' => 'SE35 5000 0000 0549 1000 0003',
	'Switzerland' => 'CH93 0076 2011 6238 5295 7',
	'Tunisia' => 'TN59 1000 6035 1835 9847 8831',
	'Turkey' => 'TR33 0006 1005 1978 6457 8413 26',
	'UAE' => 'AE07 0331 2345 6789 0123 456',
	'United Kingdom' => 'GB29 NWBK 6016 1331 9268 19',
);

$legend = array(
	'C: Country / Land',
	'B: Bankcode / Bankleitzahl',
	'A: AccountNumber / Kontonummer',
	'F: Branchcode / Filialnummer',
	'T: Accounttype / Konto-Typ',
	'O: Owner account number / Besitzernummer',
	'E: Calculated checksum / Errechete Prüfziffer',
	'S: Checksum from IBAN / Prüfziffer aus der IBAN',
	'V: Whether the iban is valid / Ob die Iban gültig ist',
	'L: Whether the iban length is valid / Ob die Länge der Iban gültig ist',
	'N: Country / Land',
	'',
);

foreach ($legend as $string) {
	echo $string . PHP_EOL;
}

$readings = array(
	'C' => 'getCountryIso',
	'B' => 'getBankCode',
	'A' => 'getAccountNumber',
	'F' => 'getBranchCode',
	'T' => 'getAccountType',
	'O' => 'geOwnerNumber',
	'E' => 'calculateCheckSum',
	'S' => 'getCheckSumFromGivenIban',
	'V' => 'isCheckSumValid',
	'L' => 'checkLengthIsValid',
	'N' => 'getCountryName',
);

$lengths = array(
	'C' => 6,
	'B' => 10,
	'A' => 25,
	'F' => 8,
	'T' => 8,
	'O' => 8,
	'E' => 6,
	'S' => 4,
	'V' => 4,
	'L' => 4,
	'N' => 30,
);

foreach ($example as $country => $iban) {
	echo str_pad($country, 27, ' ', STR_PAD_RIGHT);
	echo '' . str_pad($iban, 44, ' ', STR_PAD_RIGHT);
	$ibanDecoder = new IbanDecoder($iban);

	foreach ($readings as $identifier => $methodName) {
		$value = $ibanDecoder->{$methodName}();
		if (empty($value)) {
			$value = '-';
		}
		echo $identifier . ': ' . str_pad($value, $lengths[$identifier], ' ', STR_PAD_RIGHT);
	}

	echo PHP_EOL;
}
