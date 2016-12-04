<?php

namespace JasnaPaka\Citation;

/**
 * Class Error obsahuje definici chybových stavů služby.
 */
class CitationError
{

	const ERROR_CODE_1 = 1;
	const ERROR_CODE_2 = 2;
	const ERROR_CODE_3 = 3;
	const ERROR_CODE_4 = 4;

	const ERROR_CODE_1_MSG = "Služba je vypnuta.";
	const ERROR_CODE_2_MSG = "Chybí vstupní parametr 'isbn'.";
	const ERROR_CODE_3_MSG = "Vstupní parametr 'isbn' je neplatný.";
	const ERROR_CODE_4_MSG = "Dle vstupního parametru 'isbn' nebyla nalezena kniha.";
}