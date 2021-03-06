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

use Anfix\Exceptions\AnfixException;

class IssuedInvoice extends BaseModel
{
    protected $applicationId = 'E';
    protected $update = true;
    protected $create = true;
    protected $delete = true;

    /**
     * Duplicación de una factura emitida.
     * @param string $issuedInvoiceIds Identificadores únicos de las facturas emitidas a duplicar
     * @param string $companyId
     * @return Object
     */
    public static function duplicate($issuedInvoiceIds,$companyId){
        $obj = new static([],false,$companyId);
        $result = self::_send(['IssuedInvoiceIds' => $issuedInvoiceIds],$companyId,'duplicate');
        return $result->outputData->{$obj->Model};
    }


    /**
     * Vista previa de una factura emitida.
     * @param $params array con los datos de la factura, IssuedInvoiceTemplateId y IssuedInvoiceTemplateLanguage obligatorios
     * @param string $companyId
     * @return Object
     */
    public static function preview(array $params,$companyId){
        $obj = new static([],false,$companyId);
        $result = self::_send($params,$companyId,'preview');
        return $result->outputData->{$obj->Model};
    }

    /**
     * Consulta de cobros de una factura emitida.
     * Esta función se utiliza como get, normalmente después de ::where para establecer el filtrado
     * @param array $fields Campos a devolver
     * @param int $maxRows = null Máximo de filas a mostrar, si no se indica se devolverán 50
     * @param null $minRowNumber Primera entrada a devolver como resultado del conjunto total de entradas devueltas por la operación
     * @param array $order Lista con los campos por los que se quiere ordenar los resultados
     * @param string $orderTypes ”ASC” o ”DESC”
     * @return array
     */
    public function searchForCharge(array $fields = [],$maxRows = null, $minRowNumber = null, array $order = [], $orderTypes = 'ASC'){
        return parent::get($fields, $maxRows, $minRowNumber, $order, $orderTypes, 'searchForCharge',[],str_replace('servicios/','simple/',$this->apiBaseUrl));
    }

    /**
     * Generación de factura electrónica.
     * @param string $eInvoiceFormat = 'facturae32' Especifica el formato de la factura electrónica
     * @param bool $forced = false Indica si debe forzarse o no la generación de la factura electrónica en caso de que se hubiese almacenado previamente
     * @param bool $temporal = false Indica si la factura electrónica se almacenará temporalmente
     * @param string $EInvoiceCertificateId = "1" Identificador del certificado con el que firmar la factura
     * @param string $EInvoiceCertificateAlias = "AnfixCert" Alias del certificado con el que firmar la factura
     * @throws AnfixException
     * @return Object
     */
    public function generateEInvoice($eInvoiceFormat = 'facturae32', $forced = false, $temporal = false, $EInvoiceCertificateId = "1", $EInvoiceCertificateAlias = "AnfixCert"){

        if(! $this->{$this->primaryKey})
            throw new AnfixException('Para generar una factura electrónica debe partir de una factura ya registrada en anfix');

        $params = [
            'IssuedInvoiceId' => $this->{$this->primaryKey},
            'EInvoiceFormat' => $eInvoiceFormat,
            'Forced' => $forced,
            'Temporal' => $temporal,
            'EInvoiceCertificateId' => $EInvoiceCertificateId,
            'EInvoiceCertificateAlias' => $EInvoiceCertificateAlias
        ];

        $url = $this->config['applicationIdUrl'][$this->applicationId].'report/einvoice';

        $result = Anfix::sendRequest($url,[
            'applicationId' =>  $this->applicationId,
            'companyId' => $this->companyId,
            'inputBusinessData' => [
                $this->Model => $params
            ]
        ] ,$this->config, $this->token);

        return $result->outputData->{$this->Model};
    }

    /**
     * Crea un pago de una factura
     * @param string $date
     * @param float $amount
     * @return Charge
     * @throws Exceptions\AnfixException
     * @throws Exceptions\AnfixResponseException
     */
    public function createPayment($date, $amount){
        $formapago = $this->IssuedInvoicePayChargeMethodId == 'b' ? 'Tarjeta' : 'Transferencia';
        return Charge::create([
            'ChargeSourceId' => $this->{$this->primaryKey},
            'ChargeSourceType' => '2', //2 Fra emitida
            'ChargeDate' => $date,
            'ChargeDescription' => 'Pago de la factura '.$this->IssuedInvoiceSerialNum.'/'.$this->IssuedInvoiceNumber,
            'ChargeAmount' => $amount > 0 ? $amount : $amount * -1,
            'ChargeComments' => 'Pago mediante '.$formapago,
            'ChargeIsRefund' => $amount < 0
        ], $this->companyId);
    }
    
    /**
     * Devuelve el importe total pagado para la factura actual
     * @return float
     * @throws Exceptions\AnfixException
     * @throws Exceptions\AnfixResponseException
     */
    public function getAmountPayed(){
    	$total = 0;
    	foreach(Charge::where(['ChargeSourceId' => $this->{$this->primaryKey}], $this->companyId)->get() as $charge)
    		$total += ($charge->ChargeAmount * ($charge->ChargeIsRefund ? -1 : 1));
    	
    	return $total;
    }

    /**
     * Exporta una serie de facturas a contabilidad
     *
     * @param array $params [AccountingPeriodYear, IssuedInvoiceInitNumber, IssuedInvoiceEndNumber, IssuedInvoiceSerialNum, IssuedInvoiceInitDate, IssuedInvoiceEndDate ]
     * @param bool $ExportCharge
     * @param string $companyId
     * @return object
     */
    public static function exportMultiple(array $params, $ExportCharge, $companyId){
        $obj = new static([],false,$companyId);
        $params['ExportCharge'] =  $ExportCharge;
        $result =  parent::_send($params, $companyId,'synchronization/export');

        return $result->outputData->{$obj->Model};
    }

    /**
     * Exporta la factura a contabilidad
     * @param bool $ExportCharge
     * @throws Exceptions\AnfixException
     * @return object
     */
    public function export($ExportCharge){
        if(!$this->{$this->primaryKey})
            throw new AnfixException('Para exportar una factura debe partir de una factura ya registrada en anfix');

        return self::exportMultiple(['IssuedInvoiceInitNumber' => $this->IssuedInvoiceNumber, 'IssuedInvoiceEndNumber' => $this->IssuedInvoiceNumber, 'IssuedInvoiceSerialNum' => $this->IssuedInvoiceSerialNum],$ExportCharge,$this->companyId);
    }

}
