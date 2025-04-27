<?php

/*
 * Run with `php simple.php`, don't forget to set SUMUP_API_KEY anv variable with your API key
 */

require __DIR__ . '/../vendor/autoload.php';
$sumup = new \SumUp\SumUp([
    'api_key' => getenv('SUMUP_API_KEY'),
]);

$dba = $sumup->getMerchantService()->getDoingBusinessAs();
print_r($dba->getBody());
