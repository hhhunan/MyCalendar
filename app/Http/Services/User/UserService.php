<?php

namespace App\Http\Services\User;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Exceptions\BusinessLogicExceptions\UserNotFoundException;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Collection;


/**
 * Class UserService
 * @package App\Services\User
 */
class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;


    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct
    (
        UserRepositoryInterface $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $relations
     * @return Collection |null
     */
    public function getAllUsers(array $relations = []): ?Collection
    {
        return $this->userRepository->getAllUsers();
    }

    /**
     * @param string $name
     * @param string $password
     * @param string $email
     * @return User|null
     */
    public function create(string $name, string $password, string $email): ?User
    {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($password);
        if($user->save()){
            $user->markEmailAsVerified();
        }
        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function update(User $user, Request $request): User
    {
        if (isset($request['images']) && !is_null($request['images'])) {
            foreach ($user->getMedia('userImages') as $userImages) {
                $userImages->delete();
            }
            $this->addUserImages($user, $request['images']);
        }
        $user->update($request->all());

        return $user;
    }

    public function checkUser(string $email, string $password): bool
    {
        if ($this->userRepository->checkUser($email, $password)) {
            return true;
        }

        throw new InvalidArgumentException('Invalid arguments !');
    }

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function findOrFailById(int $id): User
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

}
