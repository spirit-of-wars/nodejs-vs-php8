<?php

namespace App\Model;

use Amp\Postgres;
use Amp\Postgres\ConnectionConfig;
use Amp\Postgres\Pool;
use Amp\Sql\Statement;
use App\Util\Config;

class DBModel {
    /**
     * @var Pool
     */
    private $pool;

    /**
     * @var Config
     */
    private $config;
    /**
     * @var \Generator|mixed
     */
    private $countRows;

    /**
     * DBModel constructor.
     * @throws \Amp\Sql\ConnectionException
     * @throws \Amp\Sql\FailureException
     * @throws \Throwable
     */
    public function __construct(Config $config)
    {
        $poolConfig = ConnectionConfig::fromString($config->getConnectionString());
        $this->config = $config;
        $this->pool = Postgres\pool($poolConfig);
    }

    /**
     * @return Postgres\Pool
     */
    public function getPool()
    {
        return $this->pool;
    }

    /**
     * @return \Generator|mixed
     */
    public function getCountRows()
    {
        return $this->countRows;
    }

    /**
     * @param int $countRows
     */
    public function setCountRows(int $countRows)
    {
        $this->countRows = $countRows;
    }

    /**
     * @return \Generator|mixed
     * @throws \Amp\Sql\ConnectionException
     * @throws \Amp\Sql\FailureException
     * @throws \Throwable
     */
    public function readCountRows()
    {
        $pool = $this->getPool();

        /** @var Postgres\PooledResultSet $result */
        $result = yield $pool->query("SELECT count(id) FROM common.product");
        $countData = $result->getCurrent();

        if (!isset($countData['count'])) {
            throw new \Exception('Error read count rows');
        }

        return $countData['count'];
    }

    /**
     * @return array|\Generator
     * @throws \Amp\Sql\ConnectionException
     * @throws \Amp\Sql\FailureException
     * @throws \Throwable
     */
    public function readFromTable($offset)
    {
        $pool = $this->getPool();

        $limit = $this->config->getPageSize();
        /** @var Statement $statement */
        $statement = yield $pool->prepare("SELECT * FROM common.product offset :offset limit :limit");
        /** @var Postgres\PooledResultSet $result */
        $result = yield $statement->execute(['offset' => $offset, 'limit' => $limit]);

        while (yield $result->advance()) {
            $rowArr[] = $result->getCurrent();
        }

        return $rowArr;
    }

    /**
     * @param int $offset
     * @return \Generator
     * @throws \Amp\Sql\ConnectionException
     * @throws \Amp\Sql\FailureException
     */
    public function writeToTable(int $offset)
    {
        $pool = $this->getPool();

        $query = "insert into common.test_insert (offset_number, offset_count)
                                    values(:offset, 1)
                                    ON CONFLICT (offset_number)
                                    DO UPDATE SET offset_count = common.test_insert.offset_count + 1;";

        /** @var Statement $statement */
        $statement = yield $pool->prepare($query);
        yield $statement->execute(['offset' => $offset]);;

    }
}