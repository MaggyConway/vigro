<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Repositories;

use Sntinvest\Integration\Interfaces\Repositories\RepositoryInterface;
use Sntinvest\Integration\Exceptions\InvalidMethodException;

/**
 * Description of Repository
 *
 * @author dimay
 */
abstract class Repository implements RepositoryInterface
{
    public function findOrCreated($params)
    {
        throw new InvalidMethodException('The selected method is not working');
    }
    
    public function set(&$entry, $data) 
    {
        throw new InvalidMethodException('The selected method is not working');
    }
}