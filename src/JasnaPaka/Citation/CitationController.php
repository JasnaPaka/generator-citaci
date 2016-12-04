<?php

namespace JasnaPaka\Citation;

include_once "CitationError.php";
require DIR_ROOT . '/vendor/autoload.php';

use Novak\Service\ISBNService;
use Novak\Utils\XMLUtils;
use Novak\Validator\ISBNValidator;

class CitationController
{

	public function process() {

		if (SERVICE_ENABLED === FALSE) {
			$this->processError(CitationError::ERROR_CODE_1, CitationError::ERROR_CODE_1_MSG);
			return;
		}

		$isbn = filter_input(INPUT_GET, "isbn", FILTER_SANITIZE_STRING);
		if (strlen($isbn) == 0) {
			$this->processError(CitationError::ERROR_CODE_2, CitationError::ERROR_CODE_2_MSG);
			return;
		}

		if (!ISBNValidator::isValid($isbn)) {
			$this->processError(CitationError::ERROR_CODE_3, CitationError::ERROR_CODE_3_MSG);
			return;
		}

		$service = new ISBNService();
		$result = $service->getCitationFromISBN($isbn);
		if ($result === false) {
			//$this->processError(CitationError::ERROR_CODE_4, CitationError::ERROR_CODE_4_MSG);
			return;
		}

		$this->processResult($result);
	}

	/**
	 * Provede zpracování pozitivní odpovědi (něco bylo na základě vstupu nalezeno). Výsledkem je XML.
	 * @param $citation string text citace (bude použit na výstupu)
	 */
	private function processResult($citation)
	{
		$content = file_get_contents(DIR_ROOT."/template/result.xml");
		$content = str_replace("%CITATION%", XMLUtils::removeInvalidXMLChars($citation), $content);

		$this->printOutput(200, $content);
	}

	/**
	 * Provede vygenerování chybového XML.
	 *
	 * @param string $code kód chyby
	 * @param string $msg text chyby
	 * @param int $statusCode stavový http kód (nepovinné)
	 */
	private function processError($code, $msg, $statusCode = 500)
	{
		$content = file_get_contents(DIR_ROOT."/template/error.xml");
		$content = str_replace("%CODE%", XMLUtils::removeInvalidXMLChars($code), $content);
		$content = str_replace("%MSG%", XMLUtils::removeInvalidXMLChars($msg), $content);

		$this->printOutput($statusCode, $content);
	}

	/**
	 * Provede zobrazení vygenerovaného XML na výstup.
	 * @param $statusCode int stavový kód http
	 * @param $content string obsah xml
	 */
	private function printOutput($statusCode, $content)
	{
		http_response_code($statusCode);
		header('Content-Type: application/xml');
		header("Content-Length: " . strlen($content));
		print $content;
	}

}