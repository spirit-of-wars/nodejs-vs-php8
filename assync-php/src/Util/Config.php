<?php

namespace App\Util;

class Config
{
    /**
     * @var int|null
     */
    private $pageSize;

    /**
     * @var string|null
     */
    private $connectionString;

    public function __construct(string $configPath)
    {
        $configArr = require_once $configPath;

        $this->pageSize = $configArr['pageSize'] ?? null;
        $this->connectionString = $configArr['connectionString'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @return string|null
     */
    public function getConnectionString(): string
    {
        return $this->connectionString;
    }

}