<?php


namespace App\Users;


use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;


final class Storage
{
    /**
     * @var ConnectionInterface $connection
     */
    private $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function getByUserName(string $userName): PromiseInterface
    {
        return $this->connection
            ->query(
                'SELECT 
                        id, username, first_name, last_name, email, password, phone, status, created_at
                     FROM
                        users
                     WHERE
                        username = ?',
                [$userName]
            )
            ->then(
                function (QueryResult $result) {
                    return $this->mapUser($result->resultRows[0]);
                }
            );
    }

    private function mapUser(array $row): User
    {
        return new User(
            (int)$row['id'],
            $row['username'],
            $row['first_name'],
            $row['last_name'],
            $row['email'],
            $row['password'],
            (int)$row['phone'],
            $row['status'],
            $row['created_at']
        );
    }
}
