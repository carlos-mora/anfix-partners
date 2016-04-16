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
*  Date: 9/2/16 18:57
*  @author Lucid Networks <info@lucidnetworks.es>
*  @copyright  2006-2015 Lucid Networks
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

namespace Anfix;

class DocumentReport extends StaticModel
{
    protected static $applicationId = 'E';
    protected static $apiUrlSufix = 'report/';
	
   /**
	* Exportación de presupuestos a diferentes formatos.
	* @param array $params Parámetros
	* @param string $companyId Identificador de la empresa
	* @return Object
	*/
	public static function customerBudget(array $params,$companyId){
        $result = self::_send($params,$companyId,'customerbudget');
        return $result->outputData->{self::$Model};
	}

	/**
	 * Exportación para impresión de factura emitida.
	 * @param array $params Parámetros
	 * @param string $companyId Identificador de la empresa
	 * @return Object
	 */
	public static function issuedInvoice(array $params,$companyId){
		$result = self::_send($params,$companyId,'issuedinvoice');
		return $result->outputData->{self::$Model};
	}

	/**
	 * Exportación para impresión de factura recibida.
	 * @param array $params Parámetros
	 * @param string $companyId Identificador de la empresa
	 * @return Object
	 */
	public static function receivedInvoice(array $params,$companyId){
		$result = self::_send($params,$companyId,'receivedinvoice');
		return $result->outputData->{self::$Model};
	}

}