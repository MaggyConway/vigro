<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Interfaces\Repositories;

/**
 *
 * @author dimay
 */
interface RepositoryInterface
{
    public function findOrCreated($params);
    
    public function set(&$entry, $data);
}
