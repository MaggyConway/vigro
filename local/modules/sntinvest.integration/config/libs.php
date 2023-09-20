<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Bitrix\Main\Config\Option;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

return [
    AMQPStreamConnection::class => DI\factory(function() {
        
        $server = Option::get(SI_MODULE_NAME, 'rebbitmq_addres');
        $port = Option::get(SI_MODULE_NAME, 'rebbitmq_port');
        $user = Option::get(SI_MODULE_NAME, 'rebbitmq_user');
        $password = Option::get(SI_MODULE_NAME, 'rebbitmq_password');
        $vhost = Option::get(SI_MODULE_NAME, 'rebbitmq_vhost');
        
        return new AMQPStreamConnection($server, $port, $user, $password, $vhost);
    }),
    Logger::class => DI\factory(function() {
        
        $log = new Logger(SI_MODULE_NAME);
        
        $date = new \DateTime();
        
        $log->pushHandler(
            new StreamHandler($_SERVER["DOCUMENT_ROOT"].'/_code_logs/'.SI_MODULE_NAME.'_'.$date->format('Y_m_d').'.log')
        );

        return $log;
    }),
];