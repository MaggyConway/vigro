<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */
namespace Sntinvest\Integration\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Sntinvest\Integration\Container;
use Sntinvest\Integration\Services\MutualSettlementsService;

/**
 * Description of ExchangeUserCommand
 *
 * @author dimay
 */

class ExchangeMutualSettlementsCommand extends Command
{
    protected static $defaultName = 'exchange:mutualsettlements';
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $service = Container::getInstance()->get(MutualSettlementsService::class);
        
        $service->consoleTo($input, $output);

        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}