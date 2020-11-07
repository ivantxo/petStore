<?php


namespace App\Users;


use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;
use function React\Promise\reject;


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
            ->query('
                SELECT 
                    id, username, first_name, last_name, email, password, phone, status, created_at
                FROM
                    users
                WHERE
                    username = ?',
                [$userName]
            )
            ->then(
                function (QueryResult $result) {
                    if (empty($result->resultRows)) {
                        throw new UserNotFound();
                    }
                    return $this->mapUser($result->resultRows[0]);
                }
            );
    }

    public function delete(string $userName): PromiseInterface
    {
        return $this->connection
            ->query('
                DELETE
                FROM
                    users
                WHERE
                    username = ?',
                [$userName]
            )
            ->then(
                function (QueryResult $result) {
                    if ($result->affectedRows === 0) {
                        throw new UserNotFound();
                    }
                }
            );
    }

    public function update(string $userName, string $firstName, string $lastName, string $phone): PromiseInterface
    {
        return $this->getByUserName($userName)
            ->then(
                function (User $user) use ($firstName, $lastName, $phone) {
                    $this->connection
                        ->query('
                            UPDATE
                                users
                            SET
                                first_name = ?,
                                last_name = ?,
                                phone = ?
                            WHERE
                                id = ?
                        ',
                            [$firstName, $lastName, $phone, $user->id]);
                }
            )
            ->otherwise(
                function () {
                    throw new UserNotFound();
                }
            );
    }

    public function create(
        string $userName,
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $phone): PromiseInterface
    {
        return $this->userNameIsNotTaken($userName)
            ->then(
                function () use ($userName, $firstName, $lastName, $email, $password, $phone) {
                    $this->connection
                        ->query('
                            INSERT INTO 
                                users (username, first_name, last_name, email, password, phone)
                            VALUES
                                (?, ?, ?, ?, ?, ?)
                        ',
                        [$userName, $firstName, $lastName, $email, $password, $phone]);
                }
            );
    }

    private function userNameIsNotTaken(string $userName): PromiseInterface
    {
        return $this->connection
            ->query('SELECT 1 FROM users WHERE username = ?', [$userName])
            ->then(
                function (QueryResult $result) {
                    return empty($result->resultRows)
                        ? resolve()
                        : reject(new UserAlreadyExists());
                }
            );
    }

    private function mapUser(array $row): User
    {
        $user = new User(
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
        return $user;
    }
}
