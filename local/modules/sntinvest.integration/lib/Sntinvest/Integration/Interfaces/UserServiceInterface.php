<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Interfaces;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *
 * @author dimay
 */
interface UserServiceInterface extends ServiceInterface 
{
    public function consoleTo(InputInterface $input, OutputInterface $output);
}
