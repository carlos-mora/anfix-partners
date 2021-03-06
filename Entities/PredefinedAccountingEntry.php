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

class PredefinedAccountingEntry extends BaseModel
{
    protected $applicationId = '3';
    protected $apiUrlSufix = 'company/predefinedaccountingentry/';
    protected $update = true;
    protected $create = true;
    protected $delete = true;
	
   /**
	* Duplicación de asientos predefinidos entre empresas.
	* @param array $params Parámetros para el reporte, AccountingPeriodYear, Action, CompanyIdSource y PredefinedEntriesId obligatorios
	* @param string $companyId Identificador de la empresa
	* @return Int Número de elementos afectados
	*/
	public static function copy(array $params,$companyId){
		$obj = new static([],false,$companyId);
        $result = self::_send($params,$companyId,'copy');
		if(empty($result->outputData->{$obj->Model}))
			return 0;

        return $result->outputData->{$obj->Model}->rowcount;
	}
	
   /**
	* Búsqueda de asientos predefinidos por tipo de asiento.
	* Su utilización es similar a ->get, siempre después de ::where()
	* @param string $accountingPeriodYear Año del ejercicio contable en le que se realiza la búsqueda
	* @param $includePredefined true o false indicando si se deben incluir en los resultados los asientos predefinidos estructurales o no, respectivamente
	* @param array $fields = [] Campos a devolver
	* @param string $order Ordenación PredefinedAccountingEntryCode, PredefinedAccountingEntryTypeId
	* @return array BaseModel
	*/
	public function getByEntryType($accountingPeriodYear, $includePredefined, array $fields = [], $order = 'PredefinedAccountingEntryCode'){
        $params = ['AccountingPeriodYear' => $accountingPeriodYear, 'IncludeStructuralPredefinedAccountingEntries' => $includePredefined, 'Order' => $order];
		return $this->get($fields, null, null, [], 'ASC', 'searchbyentrytype', $params);
	}
	
}