<?php

namespace Server;

use PDO;
use Throwable;

class AbstractModel
{
    protected const host_name = 'short-link-db';
    protected const database_name = 'short_links_db';

    protected string $tableName = 'no_table';

    protected PDO $DBConn;

    public function __construct()
    {
        $this->connect();
    }

    private function connect(): void
    {
        $this->DBConn = new PDO(
            'mysql:host=' . $this::host_name . ';dbname=' . AbstractModel::database_name,
            'server-user',
            '1234');
    }

    protected function executeRequest($query): array
    {
        $response = [];
        $request = $this->DBConn->prepare($query);
        try {
            $request->execute();
            $response = $request->fetchAll(PDO::FETCH_NAMED);
        } catch (Throwable $e) {
            $response['error'] = $e;
        }
        return $response;
    }

    protected function select(array $columns = ['*'], array $whereCondition = []): array
    {
        $selectQueryObject = new SelectQueryBuilder();
        $selectQueryObject->
        select($columns)->
        from($this->tableName);
        if (count($whereCondition) > 0) {
            $selectQueryObject->where($whereCondition);
        }
        return $this->executeRequest($selectQueryObject->getQuery());
    }

    protected function update(array $columns, array $values, array $whereCondition): void
    {
        $updateQueryObject = new UpdateQueryBuilder();
        $updateQueryObject->
        update($this->tableName, $columns, $values);
        if (count($whereCondition) > 0) {
            $updateQueryObject->where($whereCondition);
        }
        $this->executeRequest($updateQueryObject->getQuery());
    }

    protected function delete(array $whereCondition): void
    {
        $deleteQueryObject = new DeleteQueryBuilder();
        $deleteQueryObject->
        delete($this->tableName);
        if (count($whereCondition) > 0) {
            $deleteQueryObject->where($whereCondition);
        }
        $this->executeRequest($deleteQueryObject->getQuery());
    }

    protected function insert(array $columns, array $values)
    {
        $insertQueryObject = new InsertQueryBuilder();
        $insertQueryObject->insert($this->tableName, $columns, $values);
        $this->executeRequest($insertQueryObject->getQuery());
    }
}
