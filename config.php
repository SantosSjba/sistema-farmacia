<?php
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\See;

$see = new See();
$see->setCertificate(file_get_contents(__DIR__.'/certificado/foto/certificado.pem'));
//$see->setService(SunatEndpoints::FE_PRODUCCION); // Cambiar la url para cuando sea Percepción/Retención
$see->setService(SunatEndpoints::FE_BETA);
$see->setClaveSOL('20123433213', 'mmdatos', 'mmdatos');

return $see;