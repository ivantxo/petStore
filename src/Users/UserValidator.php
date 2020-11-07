<?php


namespace App\Users;


use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator;


final class UserValidator
{
    /**
     * @var ServerRequestInterface $request
     */
    private $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function validate(): void
    {
        $userNameValidator = Validator::key(
            'userName',
            Validator::allOf(
                Validator::notBlank(),
                validator::stringType()
            )
        )->setName('userName');

        $firstNameValidator = Validator::key(
            'firstName',
            Validator::allOf(
                Validator::notBlank(),
                validator::stringType()
            )
        )->setName('firstName');

        $lastNameValidator = Validator::key(
            'lastName',
            Validator::allOf(
                Validator::notBlank(),
                validator::stringType()
            )
        )->setName('lastName');

        $emailValidator = Validator::key(
            'email',
            Validator::allOf(
                Validator::notBlank(),
                validator::stringType(),
                Validator::email()
            )
        )->setName('email');

        $phoneValidator = Validator::key(
            'phone',
            Validator::allOf(
                Validator::number(),
                Validator::positive(),
                Validator::notBlank()
            )
        )->setName('phone');
        $validator = Validator::allOf(
            $userNameValidator,
            $firstNameValidator,
            $lastNameValidator,
            $emailValidator,
            $phoneValidator
        );
        $validator->assert($this->request->getParsedBody());
    }

    public function userName(): string
    {
        return $this->request->getParsedBody()['userName'];
    }

    public function firstName(): string
    {
        return $this->request->getParsedBody()['firstName'];
    }

    public function lastName(): string
    {
        return $this->request->getParsedBody()['lastName'];
    }

    public function email(): string
    {
        return $this->request->getParsedBody()['email'];
    }

    public function phone(): string
    {
        return $this->request->getParsedBody()['phone'];
    }
}
