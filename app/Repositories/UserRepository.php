<?php

namespace App\Repositories;


use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository extends Repository implements UserRepositoryInterface
{
    public function getModelClassName(): string
    {
        return User::class;
    }
    protected array $with = ['calendar'];
    /**
     * @return Collection[]|null
     */
    public function getAllUsers(): ?Collection
    {
        return $this->model()->get();
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        /**
         * @var User|null $result
         */
        $result = $this->model()->where('id', $id)->first();

        return $result;
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        /**
         * @var User|null $result
         */
        $result = $this->model()->where('email', $email)->first();

        return $result;
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function checkUser(string $email, string $password): bool
    {
        /**
         * @var User|null $result
         */
        $result = $this->model()->where('email', $email)->first();
//        if ($result && Hash::check($password, $result->password)) {
            if ($result && $password == Crypt::decrypt($result->password)) {
            return true;
        }

        return false;
    }
}
