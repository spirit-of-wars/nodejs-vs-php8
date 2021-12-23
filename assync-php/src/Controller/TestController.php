<?php

namespace App\Controller;

use Amp\Http\Server\Response;
use Amp\Http\Status;
use App\Model\DBModel;

class TestController
{
    /**
     * @var DBModel
     */
    protected $model;

    /**
     * TestController constructor.
     * @param DBModel $DBModel
     */
    public function __construct(DBModel $DBModel)
    {
        $this->model = $DBModel;
    }

    /**
     * @return Response|\Generator
     */
    public function test()
    {
        try {
            if (!$countRows = $this->model->getCountRows()) {
                $countRows = yield from $this->model->readCountRows();
                $this->model->setCountRows($countRows);
            }

            $offset = $this->calculateOffset($countRows);
            $resultData = yield from $this->model->readFromTable($offset);
            yield from $this->model->writeToTable($offset);

            return new Response(Status::OK, [
                "content-type" => "application/json; charset=utf-8"
            ], json_encode($resultData));

        } catch (\Throwable $e) {

            return new Response(Status::BAD_REQUEST, [
                "content-type" => "text/plain; charset=utf-8"
            ], $e->getTraceAsString() . "\n" . $e->getMessage() . "\n");
        }

    }

    /**
     * @param int $countRows
     * @return int
     */
    private function calculateOffset(int $countRows) :int
    {
        return round(rand(0, $countRows)/100) * 100;
    }
}