<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface UserRepositoryInterface
 * @package App\Contracts\Repositories
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * @return Collection[]|null
     */
    public function getAllUsers(): ?Collection;

    /**
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User;

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function checkUser(string $email, string $password): bool;
}
