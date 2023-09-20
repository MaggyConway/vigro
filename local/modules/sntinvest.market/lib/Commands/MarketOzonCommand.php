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

use Sntinvest\Market\Factory\OzonMarketFactory;
use Sntinvest\Market\Market;

/**
 * Description of ExchangeUserCommand
 *
 * @author dimay
 */

class MarketOzonCommand extends Command
{
    protected static $defaultName = 'market:ozon <exchange>';
    
    protected function configure(): void
    {
        $this
            // configure an argument
            ->addArgument('exchange', InputArgument::REQUIRED, '')
                
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(" [*] Waiting for logs. To exit press CTRL+C");
        
        //Условно в Factory можно задать storge
        $factory = new OzonMarketFactory();

        //Передаем на выгрузку фабрику
        $market = new Market($factory);
        
        //Получаем выгрузку
        $method = $input->getArgument('exchange');

        //выгружаем
        $market->$method();
        
        $output->writeln(" [+] exchange $method finish");

        return Command::SUCCESS;
    }
}