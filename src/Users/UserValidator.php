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

    public function validate(string $type): void
    {
        if ($type === 'signup') {
            $userNameValidator = Validator::key(
                'userName',
                Validator::allOf(
                    Validator::notBlank(),
                    validator::stringType()
                )
            )->setName('userName');

            $emailValidator  = Validator::key(
                'email',
                Validator::allOf(
                    Validator::notBlank(),
                    validator::stringType(),
                    Validator::email()
                )
            )->setName('email');

            $passwordValidator  = Validator::key(
                'password',
                Validator::allOf(
                    Validator::notBlank(),
                    Validator::stringType()
                )
            )->setName('password');
        }
        $firstNameValidator  = Validator::key(
            'firstName',
            Validator::allOf(
                Validator::notBlank(),
                validator::stringType()
            )
        )->setName('firstName');

        $lastNameValidator  = Validator::key(
            'lastName',
            Validator::allOf(
                Validator::notBlank(),
                validator::stringType()
            )
        )->setName('lastName');

        $phoneValidator  = Validator::key(
            'phone',
            Validator::allOf(
                Validator::number(),
                Validator::positive(),
                Validator::notBlank()
            )
        )->setName('phone');
        if ($type === 'signup') {
            $validator = Validator::allOf(
                $userNameValidator,
                $firstNameValidator,
                $lastNameValidator,
                $emailValidator,
                $passwordValidator,
                $phoneValidator
            );
        } else {
            $validator = Validator::allOf(
                $firstNameValidator,
                $lastNameValidator,
                $phoneValidator
            );
        }
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

    public function hashedPassword(): string
    {
        return password_hash($this->password(), PASSWORD_BCRYPT);
    }

    public function password(): string
    {
        return $this->request->getParsedBody()['password'];
    }

    public function phone(): string
    {
        return $this->request->getParsedBody()['phone'];
    }
}
