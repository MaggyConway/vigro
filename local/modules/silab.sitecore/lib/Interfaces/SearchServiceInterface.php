<?php

/*
 * This file is part of maxonor project
 * Copyright 2022 dimay.
 */

namespace  Silab\SiteCore\Interfaces;

/**
 *
 * @author dimay
 */
interface SearchServiceInterface 
{
    public function search(string $query, array $params = []);
}
