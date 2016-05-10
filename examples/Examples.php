<?php

/*
* 2006-2015 Lucid Networks
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
*
* DISCLAIMER
*
*  Date: 26/4/16 16:53
*  @author anfix <info@anfix.com>
*  @copyright  anfix
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

/**
 * Catálogo de ejemplos de uso de los endpoints de algunas utilidades de la API de anfix
 * Antes de ejecutar ninguno de estos ejemplso asegúrese que dispone de un token y key válidos previamente generados 
 * según se especifica en la QuickStart de Readme.md
 * Puede ejecutar este fichero como un test general
 */
  
include 'example_utils.php';

$companyId = firstCompanyId(); //Obtención del id de la primera empresa disponible (función únicamente válida para ejemplos)	

//1) Creación de directorio
	//$directoryCreated = Anfix\MyDocuments::createdirectory(['HumanReadableName' => 'temp', 'HumanReadablePath'=> '/', 'OwnerId' => 'L7DZmNGqU','OwnerTypeId' => '2'],$companyId);
	//print_result('Creación de una carpeta en Documentos',$directoryCreated);

//2) Creación de fichero
//Coger del ejemplo base

//3) Descarga de un fichero
//coger del ejemplo base

//4) Enviar mail
//coger del ejemplo base

//5) media download

//6) media upload

//Módulo de Facturación

//7) Creación de cobro
	//$charge = Anfix\Charge::create(['ChargeAmount' => 50.05, 'ChargeCustomerName'=> 'Pepe', 'ChargeDate' => '11/05/2016','ChargeDescription' => 'Pago adelantado factura', 'ChargeIsRefund' => false, 'ChargeSourceId' => 'MkePmY2E;', "ChargeSourceType" => '2'],$companyId);
	//print_result('Creación de un cobro asociado a una factura emitida',$charge->ChargeId);

//8) Actualización de cobro
	//$chargeToUpdate = Anfix\Charge::where(['ChargeId' => $charge->ChargeId],$companyId)->get();
	//print_result('Cobro a actualizar',$chargeToUpdate[$charge->ChargeId]);

	//$chargeToUpdate[$charge->ChargeId]->ChargeDescription = 'Anticipo';
	//$chargeToUpdate[$charge->ChargeId]->ChargeAmount = 35.03;
    //$chargeToUpdate[$charge->ChargeId]->save(); //Actualizo el cobro
	//print_result('Actualización de un cobro asociado a una factura emitida',$chargeToUpdate[$charge->ChargeId]->getArray());

//9) Eliminación de cobro
	//$chargeToDelete = Anfix\Charge::firstOrFail([],$companyId);
	//print_result('Cobro a eliminar',$chargeToDelete);
	//$result = $chargeToDelete-> delete();
	//print_result('Número de cobros eliminados',$result);

//10) Creación de cliente
    $nextNumber = Anfix\NextNumber::compute('1',$companyId);
    //print_result('Siguiente número de cliente libre',$nextNumber);

	$customer = Anfix\Customer::create([
				'CustomerCode' => $nextNumber, 
				'CustomerName'=> 'Alberto', 
				'CustomerIdentificationTypeId' => '1',
				'CustomerIdentificationNumber' => '11111111H', 
				'CustomerFixedDiscount' => 25.0, 
				'CustomerTaxTypeId' => '1', 
				'CustomerIncludeEquivalentCharge' => true,
				'CustomerComments' => 'Este cliente cambia de domicilio a partir de Septiembre.',
				'Action' => 'ADD',
				'FiscalAddress' => ['Action' => 'ADD', 'AddressText' => 'Plaza España, 13, 3',  'AddressCountryId'=> '1'],
				'Contact' => ['Action' => 'ADD', 'ContactPersonName' => 'Alberto'],
				'BankAccount' => ['Action' => 'ADD', 'BankAccountIBAN' => 'ES4801822370420000000011'],
				'CustomerIVATypeId' => '1',
				],$companyId);

	print_result('Cliente creado',$customer->CustomerId);

//11) Modificación de cliente
	/*$customerToUpdate = Anfix\Customer::where(['CustomerId' => $customer->CustomerId],$companyId)->get();
	
	$customerToUpdate[$customer->CustomerId]->CustomerName = 'Miguel';
	$customerToUpdate[$customer->CustomerId]->CustomerFixedDiscount = 50;
    $customerToUpdate[$customer->CustomerId]->save(); //Actualizo el cliente

	print_result('Actualización de un cliente',$customerToUpdate[$customer->CustomerId]->getArray());*/

//12) Eliminación de cliente
	/*$customerToDelete = Anfix\Customer::firstOrFail([],$companyId);
	print_result('Cliente a eliminar',$customerToDelete);
	$result = $customerToDelete-> delete();
	print_result('Número de clientes eliminados',$result);*/

//13) Creación de presupuesto
    /*$customerToUse = Anfix\Customer::firstOrFail([],$companyId)->get();
    $customerToUse = $customerToUse[$customer->CustomerId]->getArray();
    print_result('Código de Cliente al que hacer un presupuesto',$customerToUse['CustomerCode']);    

	$customerBudget = Anfix\CustomerBudget::create([
				'CustomerBudgetCustomerCode' => $customerToUse['CustomerCode'],
				'CustomerBudgetCustomerId' => $customerToUse['CustomerId'],
				'CustomerBudgetCustomerIdentificationNumber' => $customerToUse['CustomerIdentificationNumber'],
				'CustomerBudgetCustomerIdentificationTypeId' => $customerToUse['CustomerIdentificationTypeId'],
				'CustomerBudgetCustomerName'=> $customerToUse['CustomerName'], 
				'CustomerBudgetCustomerTaxTypeId' => $customerToUse['CustomerTaxTypeId'], 				
				'CustomerBudgetCustomerVATTypeId' => $customerToUse['CustomerIVATypeId'],
				'CustomerBudgetDiscountPercentage' => $customerToUse['CustomerFixedDiscount'],				
				'CustomerBudgetDate' => '01/05/2016', 
				'CustomerBudgetSerialNum' => 'P2016',
				'CustomerBudgetStateId' => '1',
				'Action' => 'ADD',
				'CustomerBudgetLine' => array(['Action' => 'ADD', 'CustomerBudgetLineItemRef' => 'MTO', 
											'CustomerBudgetLineItemDescription' => 'Mantenimiento trimestral',
											'CustomerBudgetLineQuantity' => 1,
											'CustomerBudgetLinePrice' => 100,
											'CustomerBudgetLineVAT' => 21,
											'CustomerBudgetLineES' => 5.2]),
				],$companyId);
	
	print_result('Presupuesto creado',$customerBudget->CustomerBudgetId);*/

//14) Modificación de presupuesto
	/*$customerBudgetToUpdate = Anfix\CustomerBudget::where(['CustomerBudgetId' => $customerBudget->CustomerBudgetId],$companyId)->get();
	
	$customerBudgetToUpdate[$customerBudget->CustomerBudgetId]->CustomerBudgetCustomerName = 'Miguel';
	$customerBudgetToUpdate[$customerBudget->CustomerBudgetId]->CustomerBudgetDate = '02/05/2016';
    $customerBudgetToUpdate[$customerBudget->CustomerBudgetId]->save(); //Actualizo el presupuesto

	print_result('Actualización de un presupuesto',$customerBudgetToUpdate[$customerBudget->CustomerBudgetId]->getArray());*/

//15) Eliminación de presupuesto
	/*$customerBudgetToDelete = Anfix\CustomerBudget::firstOrFail([],$companyId);
	print_result('Presupuesto a eliminar',$customerBudgetToDelete);
	$result = $customerBudgetToDelete-> delete();
	print_result('Número de presupuestos eliminados',$result);*/

//16) Creación de factura emitida
	/*$customerToUse = Anfix\Customer::firstOrFail([],$companyId);

    print_result('Código de Cliente al que hacer una factura',$customerToUse->CustomerCode);

	$issuedInvoice = Anfix\IssuedInvoice::create([
				'IssuedInvoiceCustomerCode' => $customerToUse->CustomerCode,
				'IssuedInvoiceCustomerId' => $customerToUse->CustomerId,
				'IssuedInvoiceCustomerIdentificationNumber' => $customerToUse->CustomerIdentificationNumber,
				'IssuedInvoiceCustomerIdentificationTypeId' => $customerToUse->CustomerIdentificationTypeId,
				'IssuedInvoiceCustomerName'=> $customerToUse->CustomerName,
				'IssuedInvoiceCustomerTaxTypeId' => $customerToUse->CustomerTaxTypeId,
				'IssuedInvoiceCustomerVATTypeId' => $customerToUse->CustomerIVATypeId,
				'IssuedInvoiceDiscountPercentage' => 10,
				'IssuedInvoiceDate' => '05/05/2016 13:00:00',
				'IssuedInvoiceSerialNum' => 'F2016',
				'IssuedInvoiceStateId' => '1',
				'Action' => 'ADD',
				'IssuedInvoiceLine' => array(['Action' => 'ADD', 'IssuedInvoiceLineItemRef' => 'MTO', 
											'IssuedInvoiceLineItemDescription' => 'Mantenimiento trimestral',
											'IssuedInvoiceLineQuantity' => 1,
											'IssuedInvoiceLinePrice' => 100,
											'IssuedInvoiceLineVAT' => 21,
											'IssuedInvoiceLineES' => 5.2])
				],$companyId);
	
	print_result('Factura emitida creada',$issuedInvoice->IssuedInvoiceId);

	$customerBudget = Anfix\CustomerBudget::firstOrFail([],$companyId)->get();
	print_result('Presupuesto a facturar',$customerBudget[key($customerBudget)]);

	$customerBudgetToBill = $customerBudget[key($customerBudget)];

	$invoice = $customerBudgetToBill->generateDocuments([$customerBudgetToBill->CustomerBudgetId],3,$companyId);
    print_result('Conversión de presupuesto en factura',$invoice);*/

//17) Modificación de factura emitida

//18) Eliminación de factura emitida

//19) Creación de pago
    //$payment = Anfix\Payment::create(['PaymentAmount' => 50.05, 'PaymentSupplierName'=> 'Pepe', 'PaymentDate' => '11/05/2016','PaymentDescription' => 'Pago adelantado factura', 'PaymentIsRefund' => false, 'PaymentSourceId' => 'MbS010Qe8', "PaymentSourceType" => '1'],$companyId);
	//print_result('Creación de un pago asociado a una factura recibida',$payment->PaymentId);

//20) Modificación de pago
	/*$paymentToUpdate = Anfix\Payment::where(['PaymentId' => $payment->PaymentId],$companyId)->get();
	print_result('Pago a actualizar',$paymentToUpdate[$payment->PaymentId]);	

	$paymentToUpdate[$payment->PaymentId]->PaymentDescription = 'Anticipo';
	$paymentToUpdate[$payment->PaymentId]->PaymentAmount = 35.03;
    $paymentToUpdate[$payment->PaymentId]->save(); //Actualizo el pago
	print_result('Actualización de un pago asociado a una factura recibida',$paymentToUpdate[$payment->PaymentId]->getArray());	*/

//21) Eliminación de pago
	/*$paymentToDelete = Anfix\Payment::firstOrFail([],$companyId);
	print_result('Pago a eliminar',$paymentToDelete);
	$result = $paymentToDelete-> delete();
	print_result('Número de pagos eliminados',$result);	*/

//22) Creación de factura recibida 
    /*$nextNumber = Anfix\NextNumber::compute('2',$companyId);
    print_result('Siguiente número de proveedor libre',$nextNumber);
	
	$receivedInvoice = Anfix\ReceivedInvoice::create([
				'ReceivedInvoiceSupplierCode' => $nextNumber,
				'ReceivedInvoiceSupplierIdentificationNumber' => '11111111H',
				'ReceivedInvoiceSupplierIdentificationTypeId' => '1',
				'ReceivedInvoiceSupplierName'=> 'Proveedor', 
				'ReceivedInvoiceSupplierTaxTypeId' => '1', 				
				'ReceivedInvoiceSupplierVATTypeId' => '1',
				'ReceivedInvoiceDate' => '01/05/2016', 
				'ReceivedInvoiceSerialNum' => 'FR2016',
				'ReceivedInvoiceStateId' => '1',
				'Action' => 'ADD',
				'ReceivednvoiceLine' => array(['Action' => 'ADD', 'ReceivedInvoiceLineItemRef' => 'MTO', 
											'ReceivedInvoiceLineItemDescription' => 'Mantenimiento trimestral',
											'ReceivedInvoiceLineQuantity' => 1,
											'ReceivedInvoiceLinePrice' => 100,
											'ReceivedInvoiceLineVAT' => 21,
											'ReceivedInvoiceLineES' => 5.2]),
				],$companyId);
	
	print_result('Factura recibida creada',$receivedInvoice->ReceivedInvoiceId);*/

//23) Modificación de factura recibida
	/*$receivedInvoiceToUpdate = Anfix\ReceivedInvoice::where(['ReceivedInvoiceId' => $receivedInvoice->ReceivedInvoiceId],$companyId)->get();
	print_result('Factura recibida a actualizar',$receivedInvoiceToUpdate[$receivedInvoice->ReceivedInvoiceId]);	

	$receivedInvoiceToUpdate[$receivedInvoice->ReceivedInvoiceId]->ReceivedInvoiceSupplierName = 'Miguel';
	$receivedInvoiceToUpdate[$receivedInvoice->ReceivedInvoiceId]->ReceivedInvoiceDate = '02/05/2016';
    $receivedInvoiceToUpdate[$receivedInvoice->ReceivedInvoiceId]->save(); //Actualizo la factura recibida
	print_result('Actualización de una factura recibida',$receivedInvoiceToUpdate[$receivedInvoice->ReceivedInvoiceId]->getArray());*/

//24) Eliminación de factura recibida
	/*$receivedInvoiceToDelete = Anfix\ReceivedInvoice::firstOrFail([],$companyId);
	print_result('Factura recibida a eliminar',$receivedInvoiceToDelete);
	$result = $receivedInvoiceToDelete-> delete();
	print_result('Número de facturas recibidas eliminadas',$result);*/

//25) Creación de factura recurrente
	// ****** USO INCORRECTO DE LA LIBRERIA EN ESTE EJEMPLO, NI CUSTOMER NI NINGUNA OTRA ENTIDAD PUEDE SER UTILIZADO COMO UN ARRAY, NUNCA ['XXX']
    /*$customerToUse = Anfix\Customer::firstOrFail([],$companyId)->get();
    $customerToUse = $customerToUse[$customer->CustomerId]->getArray();
    print_result('Código de Cliente al que hacer una factura recurrente',$customerToUse['CustomerCode']);    

	$recurringInvoice = Anfix\RecurringInvoice::create([
				'RecurringInvoiceCustomerCode' => $customerToUse['CustomerCode'],
				'RecurringInvoiceCustomerId' => $customerToUse['CustomerId'],
				'RecurringInvoiceCustomerIdentificationNumber' => $customerToUse['CustomerIdentificationNumber'],
				'RecurringInvoiceCustomerIdentificationTypeId' => $customerToUse['CustomerIdentificationTypeId'],
				'RecurringInvoiceCustomerName'=> $customerToUse['CustomerName'], 
				'RecurringInvoiceCustomerTaxTypeId' => $customerToUse['CustomerTaxTypeId'], 				
				'RecurringInvoiceCustomerVATTypeId' => $customerToUse['CustomerIVATypeId'],
				'RecurringInvoiceDiscountPercentage' => $customerToUse['CustomerFixedDiscount'],				
				'RecurringInvoiceSerialNum' => 'F2016',
				'RecurringInvoiceStateId' => '1',
				'RecurringInvoiceEndDate' => '04/05/2016',
				'RecurringInvoiceFrequencyQuantity' => 1,
				'RecurringInvoiceFrequencyTypeId' => "1",
				'RecurringInvoiceStartDate' => '04/05/2016',
				'Action' => 'ADD',
				'RecurringInvoiceLine' => array(['Action' => 'ADD', 'RecurringInvoiceLineItemRef' => 'MTO', 
											'RecurringInvoiceLineItemDescription' => 'Mantenimiento trimestral',
											'RecurringInvoiceLineQuantity' => 1,
											'RecurringInvoiceLinePrice' => 100,
											'RecurringInvoiceLineVAT' => 21,
											'RecurringInvoiceLineES' => 5.2]),
				],$companyId);
	
	print_result('Factura recurrente creada',$recurringInvoice->RecurringInvoiceId);*/

//26) Modificación de factura recurrente
	/*$recurringInvoiceToUpdate = Anfix\RecurringInvoice::where(['RecurringInvoiceId' => $recurringInvoice->RecurringInvoiceId],$companyId)->get();
	print_result('Factura recurrente a actualizar',$recurringInvoiceToUpdate[$recurringInvoice->RecurringInvoiceId]);	

	$recurringInvoiceToUpdate[$recurringInvoice->RecurringInvoiceId]->RecurringInvoiceEndDate = '04/06/2016';
    $recurringInvoiceToUpdate[$recurringInvoice->RecurringInvoiceId]->save(); //Actualizo la factura recurrente
	print_result('Actualización de una factura recurrente',$recurringInvoiceToUpdate[$recurringInvoice->RecurringInvoiceId]->getArray());*/

//27) Eliminación de factura recurrente
	/*$recurringInvoiceToDelete = Anfix\RecurringInvoice::firstOrFail([],$companyId);
	print_result('Factura recurrente a eliminar',$recurringInvoiceToDelete);
	$result = $recurringInvoiceToDelete-> delete();
	print_result('Número de facturas recurrentes eliminadas',$result);*/

//28) Creación de un proveedor
//    $nextNumber = Anfix\NextNumber::compute('2',$companyId);
//    print_result('Siguiente número de proveedor libre',$nextNumber);
//
//	$supplier = Anfix\Supplier::create([
//				'SupplierCode' => $nextNumber,
//				'SupplierFiscalName'=> 'Mariano',
//				'SupplierIdentificationTypeId' => '1',
//				'SupplierIdentificationNumber' => '11111111H',
//				'SupplierFixedDiscount' => 25.0,
//				'SupplierTaxTypeId' => '1',
//				'SupplierIncludeEquivalentCharge' => true,
//				'SupplierComments' => 'Este proveedor cierra en Agosto',
//				'Action' => 'ADD',
//				'Address' => ['Action' => 'ADD', 'AddressText' => 'Plaza España, 13, 3',  'AddressCountryId'=> '1'],
//				'Contact' => ['Action' => 'ADD', 'ContactPersonName' => 'Alberto'],
//				'BankAccount' => ['Action' => 'ADD', 'BankAccountIBAN' => 'ES4801822370420000000011'],
//				'SupplierIVATypeId' => '1',
//				],$companyId);
//
//	print_result('Proveedor creado',$supplier->SupplierId);

//29) Modificación de un proveedor
	/*$supplierToUpdate = Anfix\Supplier::where(['SupplierId' => $supplier->SupplierId],$companyId)->get();
	
	$supplierToUpdate[$supplier->SupplierId]->CustomerName = 'Miguel';
	$supplierToUpdate[$supplier->SupplierId]->CustomerFixedDiscount = 50;
    $supplierToUpdate[$supplier->SupplierId]->save(); //Actualizo el proveedor

	print_result('Actualización de un proveedor',$supplierToUpdate[$supplier->SupplierId]->getArray());*/

//30) Eliminación de un proveedor
	/*$supplierToDelete = Anfix\Supplier::firstOrFail([],$companyId);
	print_result('Proveedor a eliminar',$supplierToDelete);
	$result = $supplierToDelete-> delete();
	print_result('Número de proveedores eliminados',$result);*/	

//31) Creación de un tipo impositivo
	$vat = Anfix\Vat::create([
				'VatClassId' => '1', 
				'VatEsValue'=> 5.2, 
				'VatInitDate' => '01/05/2016',
				'VatTypeId' => '1', 
				'VatValue' => 22.5,
				'Action' => 'ADD'
				],$companyId);

	print_result('Tipo impositivo creado',$vat->VatId);

//32) Modificación de un tipo impositivo
	/*$vatToUpdate = Anfix\Vat::where(['SupplierId' => $supplier->SupplierId],$companyId)->get();
	
	$vatToUpdate[$vat->VatId]->VatEndDate = '01/05/2016';
    $vatToUpdate[$vat->VatId]->save(); //Actualizo el tipo impositivo

	print_result('Actualización de un tipo impositivo',$vatToUpdate[$vat->VatId]->getArray());*/	

//33) Eliminación de un tipo impositivo
	/*$vatToDelete = Anfix\Vat::firstOrFail(['CompanyId' => $companyId],$companyId);
	print_result('Tipo impositivo a eliminar',$vatToDelete);
	$result = $vatToDelete-> delete();
	print_result('Número de tipos impositivos eliminados',$result);*/

// Módulo de Contabilidad

//34) Creación de un asiento contable
//Cambiar el valor de InvoiceOrder a uno libre, las fechas y el InvoiceCustomerSupplierId

	/*$issuedInvoiceEntryReference = Anfix\CompanyAccountingEntryReference::create([
				'AccountingEntryTypeId' => '2',
				'PredefinedAccountingEntryId' => '1',
				'AccountingEntryDate' => '10/05/2016',
				'FlagCapitalAssets' => false,
				'AccountingEntryPredefinedEntryId'=> '1', 
				'Action' => 'ADD', 				
				'AccountingPeriodYear' => 2016,
				'CompanyAccountingEntryNote' => array(['Action' => 'ADD', 
														'AccountingEntryNoteTypeId' => '1', 
														'AccountingEntryConcept' => 'Fra. de Cliente Pepe',
														'AccountingEntryDocumentDescription' => 'F2016/134',
														'CompanyAccountingAccountNumber' => 4300003,
														'AccountingEntryTypeId' => '2',
														'PredefinedAccountingEntryId' => '1',
														'AccountingEntryAmountDebit' => 1021.34,
														'AccountingEntryIsDebitAmount' => true,
														'AccountingEntryAmount' => 1021.34,
														'AccountingEntryNoteAmountExpression' => '?'],
														['Action' => 'ADD', 
														'AccountingEntryNoteTypeId' => '1', 
														'AccountingEntryConcept' => 'Fra. de Cliente Pepe',
														'AccountingEntryDocumentDescription' => 'F2016/134',
														'CompanyAccountingAccountNumber' => 7000000,
														'AccountingEntryNoteTaxLineNumber' => 1,
														'AccountingEntryTypeId' => '2',
														'AccountingEntryAmountDebit' => 844.08,
														'AccountingEntryIsDebitAmount' => false,
														'AccountingEntryAmount' => 844.08,
														'AccountingEntryNoteAmountExpression' => 'TaxBaseValue1'],
														['Action' => 'ADD', 
														'AccountingEntryNoteTypeId' => '2', 
														'AccountingEntryConcept' => 'Fra. de Cliente Pepe',
														'AccountingEntryDocumentDescription' => 'F2016/134',
														'CompanyAccountingAccountNumber' => 4770000,
														'AccountingEntryNoteTaxLineNumber' => 1,
														'AccountingEntryTypeId' => '2',
														'AccountingEntryAmountDebit' => 177.26,
														'AccountingEntryIsDebitAmount' => false,
														'AccountingEntryAmount' => 177.26,
														'AccountingEntryNoteAmountExpression' => 'TaxBaseValue1 TaxPercentage1 %']),				
				'Invoice' => ['InvoiceOperationKeyId' => '1',
									'InvoiceDate' => '10/05/2016',
									'InvoiceOperationDate' => '10/05/2016',
									'InvoiceCustomerSupplierId' => 'MuuWnXxCo',
									'InvoiceCustomerSupplierIdentificationTypeId' => '1',
									'InvoiceCustomerSupplierIdentificationNumber' => '11111111H',
									'InvoiceOrder' => 21,
									'Action' => 'ADD',
									'InvoiceCustomerSupplierAccountingAccountNumber' => 4300003,
									'Invoice347OperationKeyId' => '2',
									'InvoiceCashAccounting' => false,
									'InvoiceLine' => array(['InvoiceLineOrder' => 1,
															'InvoiceLineOperationTypeId' => '7',
															'InvoiceLineTaxBaseValue' => 844.08,
															'InvoiceLineTaxValueId' => 'g',
															'InvoiceLineTaxPercentage' => 21,
															'InvoiceLineTaxValue' => 177.26,
															'InvoiceLineESPercentage' => 5.2,
															'InvoiceLineIncludeEquivalenceSurcharge' =>  false,
															'InvoiceLineIncludeIn340' => false,
															'InvoiceLineIncludeIn349' => false,
															'Action' => 'ADD'
										])
					]
				],$companyId);
	
	print_result('Asiento de factura emitida creada',$issuedInvoiceEntryReference->AccountingEntryId);*/

//35) Actualización de un asiento contable
    /*$issuedInvoiceEntryReference = Anfix\CompanyAccountingEntryReference::where([],$companyId)->get([],1,1,[],'','search',['AccountingPeriodYear' => 2016]);
    $issuedInvoiceToUpdate = $issuedInvoiceEntryReference[key($issuedInvoiceEntryReference)];

    $issuedInvoiceToUpdate->AccountingEntryDate = '12/05/2016';
    $issuedInvoiceToUpdate->AccountingPeriodYear = 2016;
    $issuedInvoiceToUpdate->save(); //Actualizo el asiento contable

    print_result('Asiento de factura emitida actualizado',$issuedInvoiceToUpdate->AccountingEntryId);*/
	
    // Si creamos un asiento y lo actualizamos posteriormente
    /*$issuedInvoiceEntryReference->AccountingEntryDate = '11/05/2016';
    $issuedInvoiceEntryReference->AccountingPeriodYear = 2016;
    $issuedInvoiceEntryReference->save(); //Actualizo el asiento contable

    print_result('Asiento de factura emitida actualizado',$issuedInvoiceEntryReference->AccountingEntryId);*/

//36) Eliminación de un asiento contable
//TO-DO: Da un error ¿Cómo incluyo AccountingPeriodYear
    /*$issuedInvoiceEntryReference = Anfix\CompanyAccountingEntryReference::where([],$companyId)->get([],1,1,[],'','search',['AccountingPeriodYear' => 2016]);
    $issuedInvoiceToDelete = $issuedInvoiceEntryReference[key($issuedInvoiceEntryReference)];

    $result = $issuedInvoiceToDelete->delete();

    print_result('Número de asientos eliminados',$result);*/

//37) Borrado de ejercicio contable
    /*$result = $accountingPeriodYear = Anfix\CompanyAccountingPeriod::purge(2011, $companyId);
    print_result('Número de ejercicios eliminados',$result);*/

//38) Desactivación de ejercicio contable
    /*$accountingPeriodYear = Anfix\CompanyAccountingPeriod::where(['AccountingPeriodYear' => 2019], $companyId)->get();
    print_result('Ejercicio a eliminar',$accountingPeriodYear[2019]);

    $accountingPeriodYear[2019]->AccountingPeriodYear = 2019;
    $result = $accountingPeriodYear[2019]->delete();
    print_result('Número de ejercicios desactivados',$result);*/

//39) Actualización de ejercicio contable
    /*$accountingPeriodYear = Anfix\CompanyAccountingPeriod::where(['AccountingPeriodYear' => 2012], $companyId)->get();
    print_result('Ejercicio a actualizar',$accountingPeriodYear[2012]);

    $accountingPeriodYear[2012]->CompanyAccountingPeriodInitDate = '02/01/2012 00:00:00';
    $result = $accountingPeriodYear[2012]->save();
    print_result('Número de ejercicios actualizados',$result);*/

//40) Creación de empresa

//41) Parametrización por defecto de una empresa

//42) Actualización de una empresa

//43) Creación de cuenta contable
    //TO-DO: la url usada no es la correcta, debería ser apps.anfix.com//contapro/conta/company/accountingplan/accountingaccountmanager/create
	/*$accountingAccount = Anfix\CompanyAccountingAccount::create([
				'AccountingPeriodYear' => 2016,	
				'CompanyAccountingAccount' => array(['Action' => 'ADD', 
														'CompanyAccountingAccountDescription' => 'Proveedores de inmovilizado a largo plazo', 
														'CompanyAccountingAccountNumber' => 1730],
														['Action' => 'ADD', 
														'CompanyAccountingAccountDescription' => 'Proveedores de inmovilizado a largo plazo', 
														'CompanyAccountingAccountNumber' => 17300],
														['Action' => 'ADD', 
														'CompanyAccountingAccountDescription' => 'Iberdrola', 
														'CompanyAccountingAccountNumber' => 1730001],
														'Supplier' => ['Action' => 'ADD',
																		'SupplierFiscalName' => 'Iberdrola'
														])
				],$companyId);
	
	print_result('Cuenta contable creada',$accountingAccount->CompanyAccountingAccountNumber);*/

//44) Modificación de cuenta contable
	//TO-DO: Está dando un error al llamar al save
    /*$accountingAccount = Anfix\CompanyAccountingAccount::select(2016, 4300000, $companyId);

    $accountingAccount->AccountingPeriodYear = 2016;
    $accountingAccount->CompanyAccountingAccountNumber = 4300000;
    $accountingAccount->CompanyAccountingAccountInitBalance = 200;
    $result = $accountingAccount->save();
    print_result('Número de cuentas contables actualizadas',$result);*/

//45) Eliminación de cuenta contable
    //TO-DO: Está dando un error al llamar al delete
	/*$accountingAccountToDelete = Anfix\CompanyAccountingAccount::select(2016, 4300003, $companyId);
	print_result('Cuenta a eliminar',$accountingAccountToDelete);

	$result = $accountingAccountToDelete->delete();

    print_result('Número de cuentas contables eliminadas',$result);*/

//46) Creación de importación

//47) Creación de retención

//48) Modificación de una retención

//49) Eliminación de una retención

//50) Creación de factura
	/*$invoice = Anfix\Invoice::create([
				'AccountingPeriodYear' => 2016,
				'Action' => 'ADD', 								
				'FromInvoiceManagement' => true,
				'Invoice347OperationKeyId' => '2',
				'InvoiceCashAccounting' => false,
				'InvoiceCustomerSupplierAccountingAccountNumber' => 4300003,
				'InvoiceCustomerSupplierId'=> 'MuuWmORY;',
				'InvoiceDate' => '10/05/2016',
				'InvoiceNumber' => 17,
				'InvoiceOperationKeyId' => '1',
				'InvoiceOrder' => 33,
				'InvoiceSerialNum' => 'FE2016',
				'InvoiceTotalValue' => 100,
				'InvoiceType' => 'R',
				'InvoiceLine' => array(['Action' => 'ADD',
										'InvoiceLineESPercentage' => 5.2,
										'InvoiceLineIncludeEquivalenceSurcharge' => false,
										'InvoiceLineIncludeIn340' => false,
										'InvoiceLineIncludeIn349' => false,
										'InvoiceLineOperationTypeId' => '7',
										'InvoiceLineOrder' => 1,
										'InvoiceLineTaxBaseValue' => 82.64,
										'InvoiceLineTaxPercentage' => 21,
										'InvoiceLineTaxValue' => 17.36,
										'InvoiceLineTaxValueId' => 'g'
					]),
				'Address' => array(['Action' => 'ADD',
										'AddressCityId' => '9;u',
										'AddressCountryId' => '1',
										'AddressPostalCode' => '47001',
										'AddressProvinceId' => 'L',
										'AddressText' => 'Plaza España, 13'
									])
					],$companyId);

    print_result('Factura creada',$invoice->InvoiceId);*/

//51) Modificación de factura
    /*$invoice = Anfix\Invoice::where([],$companyId)->get([],1,1,[],'','search',['AccountingPeriodYear' => 2016]);
    print_result('Factura a modificar',$invoice[key($invoice)]);

    $invoiceToUpdate = $invoice[key($invoice)];
    $invoiceToUpdate->AccountingPeriodYear = 2016;
    $invoiceToUpdate->InvoiceDate = '15/05/2016';
    $result = $invoiceToUpdate->save();

    print_result('Facturas modificadas',$result);*/

//52) Eliminación de factura
    //TO-DO: Da un error, cómo incluyo AccountingPeriodYear en el borrado?
	/*$invoice = Anfix\Invoice::where([],$companyId)->get([],1,1,[],'','search',['AccountingPeriodYear' => 2016]);    
    $invoiceToDelete = $invoice[key($invoice)];

	$invoiceToDelete->AccountingPeriodYear=2016;
	$invoiceToDelete->FromInvoiceManagement=true;
	$result = $invoiceToDelete->delete();

    print_result('Facturas modificadas',$result);	*/

//53) Creación de predefinido
	/*$predefinedAccountingEntry = Anfix\PredefinedAccountingEntry::create([
				'AccountingPeriodYear' => 2016,
				'Action' => 'ADD', 								
				'PredefinedAccountingEntryCode' => '202',
				'PredefinedAccountingEntryDescription' => 'Predefinido personalizado',
				'PredefinedAccountingEntryTypeId' => '1',
				'PredefinedAccountingEntryNote' => array(['Action' => 'ADD',
										'PredefinedAccountingEntryNoteAccountNumber' => '4300?',
										'PredefinedAccountingEntryNoteAccountNumberDescription' => '4300?',
										'PredefinedAccountingEntryNoteConcept' => 'Pago a Proveedor $',
										'PredefinedAccountingEntryNoteDocumentDescription' => 'Factura -'
					])
					],$companyId);

    print_result('Predefindo creado',$predefinedAccountingEntry->PredefinedAccountingEntryId);*/

//54) Modificación de predefinido
    //TO-DO: Está fallando, no reconoce el save?
    /*$predefinedAccountingEntry = Anfix\PredefinedAccountingEntry::where(['EntryTypeToPredefinedEntryEntryTypeId' => '2'],$companyId)->get([],1,1,[],'','searchbyentrytype',['AccountingPeriodYear' => 2016]);
    print_result('Predefinido a actualizar',$predefinedAccountingEntry);

    $predefinedToUpdate = $predefinedAccountingEntry[key($predefinedAccountingEntry)];

   $predefinedToUpdate->PredefinedAccountingEntryDescription = 'Asiento predefinido personalizado';
   $predefinedToUpdate->AccountingPeriodYear=2016;
   $result = $predefinedToUpdate->save();

   print_result('Número de asientos predefinidos actualizados',$result);*/

//55) Eliminación de predefinido
   //TO-DO: Está apareciendo un error al hacer el delete
    /*$predefinedAccountingEntry = Anfix\PredefinedAccountingEntry::where(['EntryTypeToPredefinedEntryEntryTypeId' => '2'],$companyId)->get([],1,1,[],'','searchbyentrytype',['AccountingPeriodYear' => 2016]);
    print_result('Predefinido a eliminar',$predefinedAccountingEntry);

    $predefinedToDelete = $predefinedAccountingEntry[key($predefinedAccountingEntry)];

   $predefinedToDelete->AccountingPeriodYear=2016;
   $result = $predefinedToDelete->delete();

   print_result('Número de asientos predefinidos eliminados',$result);*/

//56) Creación de tipo impositivo
	/*$vat = Anfix\Vat::create([
				'VatClassId' => '1',
				'Action' => 'ADD', 								
				'VatEsValue' => 5.2,
				'VatInitDate' => '10/05/2016',
				'VatTypeId' => '1',
				'VatValue' => 28
					],$companyId);

    print_result('Impuesto creado',$vat->VatId);*/
//57) Modificación de tipo impositivo
    /*$vat -> VatValue= 29.5;
    $result = $vat->save();
    print_result("Impuesto actualizado", $result);*/

//58) Eliminación de tipo impositivo
    /*$result = $vat->delete();
    print_result("Impuesto eliminado", $result);*/

//59) Eliminación de plantilla de Balance/PyG
	/*$templates = Anfix\Template::where([],$companyId)->get([],1,1,[],'','search',['AccountingPeriodYear' => 2016]);

	$templateToDelete = $templates[key($templates)];
	print_result('Plantilla a eliminar', $templateToDelete);

	$result = $templateToDelete->delete();
	print_result('Plantilla eliminada', $result);*/
