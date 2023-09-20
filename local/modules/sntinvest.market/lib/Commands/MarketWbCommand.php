<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */
namespace Sntinvest\Market\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use Sntinvest\Market\Factory\WbMarketFactory;
use Sntinvest\Market\Market;

/**
 * Description of ExchangeUserCommand
 *
 * @author dimay
 */

class MarketWbCommand extends Command
{
    protected static $defaultName = 'market:wb <exchange>';
    
    protected function configure(): void
    {
        $this
            // configure an argument
            ->addArgument('exchange', InputArgument::REQUIRED, '')
                
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //Условно в Factory можно задать storge
        $factory = new WbMarketFactory();

        //Передаем на выгрузку фабрику
        $market = new Market($factory);
        
        //Получаем выгрузку
        $method = $input->getArgument('exchange');

        //выгружаем
        $market->$method();

        return Command::SUCCESS;
    }
}