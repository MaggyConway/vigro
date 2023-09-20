<?php

/*
 * This file is part of bus-stage.sntinvest.ru project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Orm\Deal;

use Bitrix\Crm\EO_Deal as BX_EO_Deal;

use Sntinvest\Integration\Orm\Company\CompanyTable;

/**
 * Description of Company
 *
 * @author dimay
 */
class EO_Deal extends BX_EO_Deal
{
    public function setCompany($xml)
    {
        $company = CompanyTable::findOrCreated($xml);
                
        if (intval($company->getId()) > 0)
        {
            $this->setCompanyId($company->getId());
        }
    }
    
    public function getCompany()
    {
        $company = CompanyTable::getByPrimary($this->getCompanyId())
                                        ->fetchObject();
                
        if (intval($company->getId()) > 0)
        {
            return $company;
        }
    }
}
