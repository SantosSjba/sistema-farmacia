<?php

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;

require __DIR__.'/../vendor/autoload.php';
$see = require __DIR__.'/../config.php';

// Cliente
$client = (new Client())
    ->setTipoDoc('6')
    ->setNumDoc('20510134410')
    ->setRznSocial('LABORATORIO POWER DIESEL S.A.C.	');

// Emisor
$address = (new Address())
    ->setUbigueo('120607')
    ->setDepartamento('JUNIN')
    ->setProvincia('SATIPO')
    ->setDistrito('RIO NEGRO')
    ->setUrbanizacion('-')
    ->setDireccion('Alm. Marginal Sur Km. 4.5 Mza. 0743 Lote. 00 H.U. Sin Nombre 024 (Frente a I.e Virgen Guadalupe)')
    ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.

$company = (new Company())
    ->setRuc('10209828354')
    ->setRazonSocial('JUAREZ TORRES BETZABE SALINOVA')
    ->setNombreComercial('BOTICA MULTIPHARMA')
    ->setAddress($address);

// Venta
$invoice = (new Invoice())
    ->setUblVersion('2.1')
    ->setTipoOperacion('0101') // Venta - Catalog. 51
    ->setTipoDoc('01') // Factura - Catalog. 01
    ->setSerie('F001')
    ->setCorrelativo('42')
    ->setFechaEmision(new DateTime('2025-02-09')) // Zona horaria: Lima
    ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado
    ->setTipoMoneda('PEN') // Sol - Catalog. 02
    ->setCompany($company)
    ->setClient($client)
    ->setMtoOperGravadas(1.00)
    ->setMtoIGV(0.18)
    ->setTotalImpuestos(0.18)
    ->setValorVenta(1.00)
    ->setSubTotal(1.18)
    ->setMtoImpVenta(1.18)
    ;

$item = (new SaleDetail())
    ->setCodProducto('P001')
    ->setUnidad('NIU') // Unidad - Catalog. 03
    ->setCantidad(1)
    ->setMtoValorUnitario(1.00)
    ->setDescripcion('PRODUCTO 1')
    ->setMtoBaseIgv(1)
    ->setPorcentajeIgv(18.00) // 18%
    ->setIgv(0.18)
    ->setTipAfeIgv('10') // Gravado Op. Onerosa - Catalog. 07
    ->setTotalImpuestos(0.18) // Suma de impuestos en el detalle
    ->setMtoValorVenta(1.00)
    ->setMtoPrecioUnitario(1.18)
    ;

$legend = (new Legend())
    ->setCode('1000') // Monto en letras - Catalog. 52
    ->setValue('SON UNO Y CERO CON 00/100 SOLES');

$invoice->setDetails([$item])
        ->setLegends([$legend]);

        $result = $see->send($invoice);

        // Guardar XML firmado digitalmente.
        file_put_contents($invoice->getName().'.xml',
                          $see->getFactory()->getLastXml());

        // Verificamos que la conexión con SUNAT fue exitosa.
        if (!$result->isSuccess()) {
            // Mostrar error al conectarse a SUNAT.
            echo 'Codigo Error: '.$result->getError()->getCode();
            echo 'Mensaje Error: '.$result->getError()->getMessage();
            exit();
        }

        // Guardamos el CDR
        file_put_contents('R-'.$invoice->getName().'.zip', $result->getCdrZip());
/*
* file: factura.php
*/

$cdr = $result->getCdrResponse();

$code = (int)$cdr->getCode();

if ($code === 0) {
    echo 'ESTADO: ACEPTADA'.PHP_EOL;
    if (count($cdr->getNotes()) > 0) {
        echo 'OBSERVACIONES:'.PHP_EOL;
        // Corregir estas observaciones en siguientes emisiones.
        var_dump($cdr->getNotes());
    }
} else if ($code >= 2000 && $code <= 3999) {
    echo 'ESTADO: RECHAZADA'.PHP_EOL;
} else {
    /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
    /*code: 0100 a 1999 */
    echo 'Excepción';
}

echo $cdr->getDescription().PHP_EOL;