<?php

namespace Silab\SiteCore\Services;

/**
 * ExportDataService - общий класс для герерации данных из товаров
 */
class ExportDataService
{
    const SERVICE_PATH = "Silab\\SiteCore\\Services\\";
    const REPOSITORY_PATH = "Silab\\SiteCore\\Repositories\\";

    private $service;
    private $repository;

    public function __construct(string $service, string $repository)
    {
        $classService = self::SERVICE_PATH . $service;
        $classRepository = self::REPOSITORY_PATH . $repository;
        $this->service = new $classService;
        $this->repository = new $classRepository;
    }

    /**
     * Генерация данных из товаров
     * 
     * @return string
     */
    public function getFile()
    {
        return $this->service->export($this->repository->getList());
    }
}
