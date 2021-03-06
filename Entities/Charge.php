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

class Charge extends BaseModel
{
    protected $applicationId = 'E';
    protected $update = true;
    protected $create = true;
    protected $delete = true;

    /**
     * Consulta de cobros a clientes vinculados a facturas emitidas.
     * Esta función se utiliza como get, normalmente después de ::where para establecer el filtrado
     * @param array $fields ChargeCustomerCode, ChargeCustomerName, ChargeIdentificationNumber, ChargeSourceSerialNum, ChargeSourceNumber
     * @param int $maxRows = null Máximo de filas a mostrar, si no se indica se devolverán 50
     * @param null $minRowNumber Primera entrada a devolver como resultado del conjunto total de entradas devueltas por la operación
     * @param array $order Lista con los campos por los que se quiere ordenar los resultados
     * @param string $orderTypes ”ASC” o ”DESC”
     * @return array
     */
    public function searchforissuedinvoice(array $fields = [],$maxRows = null, $minRowNumber = null, array $order = [], $orderTypes = 'ASC'){
        return parent::get($fields, $maxRows, $minRowNumber, $order, $orderTypes, 'searchforissuedinvoice');
    }
}
