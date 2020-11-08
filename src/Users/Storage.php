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

    /**
     * Storage constructor.
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * If username is valid, the promise resolves to a User model, otherwise rejects to UserNotFound Exception
     * @param string $userName
     * @return PromiseInterface
     */
    public function getByUserName(string $userName): PromiseInterface
    {
        return $this->connection
            ->query('
                SELECT 
                    id, username, first_name, last_name, email, password, phone, status, created_at
                FROM
                    users
                WHERE
                    username = ?', [$userName]
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

    /**
     * If username is valid, the promise resolves and deletes from the DB, otherwise rejects to UserNotFound Exception
     * @param string $userName
     * @return PromiseInterface
     */
    public function delete(string $userName): PromiseInterface
    {
        return $this->connection
            ->query('
                DELETE
                FROM
                    users
                WHERE
                    username = ?', [$userName]
            )
            ->then(
                function (QueryResult $result) {
                    if ($result->affectedRows === 0) {
                        throw new UserNotFound();
                    }
                }
            );
    }

    /**
     * If id is valid, the promise resolves and updates the user, otherwise rejects to UserNotFound Exception
     * @param string $userName
     * @param string $firstName
     * @param string $lastName
     * @param string $phone
     * @return PromiseInterface
     */
    public function update(string $userName, string $firstName, string $lastName, string $phone): PromiseInterface
    {
        return $this->getByUserName($userName)
            ->then(
                function (User $user) use ($userName, $firstName, $lastName, $phone) {
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
                        ', [$firstName, $lastName, $phone, $user->id]);
                    return $this->getByUserName($userName);
                }
            )
            ->otherwise(
                function () {
                    throw new UserNotFound();
                }
            );
    }

    /**
     * Creates a user into DB
     * @param string $userName
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @param string $phone
     * @return PromiseInterface
     */
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
                    return $this->emailIsNotTaken($email)
                        ->then(
                            function () use ($userName, $firstName, $lastName, $email, $password, $phone) {
                                $this->connection
                                    ->query('
                                      INSERT INTO 
                                        users (username, first_name, last_name, email, password, phone)
                                      VALUES
                                        (?, ?, ?, ?, ?, ?)
                                    ', [$userName, $firstName, $lastName, $email, $password, $phone]);
                            }
                        );
                }
            );
    }

    /**
     * If username already exists the promise rejects with UserAlreadyExists Exception, otherwise just resolves
     * @param string $userName
     * @return PromiseInterface
     */
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

    /**
     * If email already exists the promise rejects with EmailIsAlreadyTaken Exception, otherwise just resolves
     * @param string $email
     * @return PromiseInterface
     */
    private function emailIsNotTaken(string $email): PromiseInterface
    {
        return $this->connection
            ->query('SELECT 1 FROM users WHERE email = ?', [$email])
            ->then(
                function (QueryResult $result) {
                    return empty($result->resultRows)
                        ? resolve()
                        : reject(new EmailIsAlreadyTaken());
                }
            );
    }

    /**
     * Maps a row from the DB to a User Model
     * @param array $row
     * @return User
     */
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
