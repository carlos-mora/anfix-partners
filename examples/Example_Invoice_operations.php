<?php

/*
* 2006-2015 Lucid Networks
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL => 
* http => //opensource.org/licenses/afl-3.0.php
*
* DISCLAIMER
*
*  Date =>  9/2/16 18 => 57
*  @author Lucid Networks <info@lucidnetworks.es>
*  @copyright  2006-2015 Lucid Networks
*  @license    http => //opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

/**
 * Operaciones con presupuestos
 */
  
include 'example_utils.php';  

$companyId = firstCompanyId(); //Obtención del id de la primera empresa disponible (función únicamente válida para ejemplos)


    //Listado de presupuestos
    $invoices = Anfix\IssuedInvoice::all($companyId); //Obtenemos el presupuesto con el id indicado o un error si no existe
    print_result('Listado de id de facturas',array_map(function($e){ return $e->IssuedInvoiceId; },$invoices));


    //Obtención de un presupuesto
    $invoice = Anfix\IssuedInvoice::findOrFail('LQ:,4qF3A',$companyId); //Obtenemos el presupuesto con el id indicado o un error si no existe

    //Cobro de la factura
    $charge = \Anfix\Charge::create([
        "ChargeAmount" => 90.75,
        "ChargeSourceId" => $invoice->IssuedInvoiceId,
        "ChargeSourceType" => "2"
    ],$companyId);
    print_result('Creación de un cargo',$charge);

    //Reporte de la factura
    $report = \Anfix\DocumentReport::issuedInvoice([
        "IssuedInvoiceIds" =>  [$invoice->IssuedInvoiceId],
        "IssuedInvoiceTemplateId" =>  "65",
        "IssuedInvoiceFormat" =>  "PDF",
        "IssuedInvoiceForce" =>  false,
        "IssuedInvoiceTemporal" =>  true
    ],$companyId);
    print_result('Reporte de la factura',$report);

    //Contabilización de la factura
    $export_result = $invoice->export(2016,true);
    print_result('Contabilización de la factura',$export_result);


    //Almacenamiento de la factura en local
    \Anfix\MyDocuments::download($report->MyDocuments->EntryId,'../download/invoice.pdf');