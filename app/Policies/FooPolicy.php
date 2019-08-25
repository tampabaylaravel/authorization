<?php

namespace App\Policies;

use App\User;
use App\Foo;
use Illuminate\Auth\Access\HandlesAuthorization;

class FooPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any foos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the foo.
     *
     * @param  \App\User  $user
     * @param  \App\Foo  $foo
     * @return mixed
     */
    public function view(User $user, Foo $foo)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can create foos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the foo.
     *
     * @param  \App\User  $user
     * @param  \App\Foo  $foo
     * @return mixed
     */
    public function update(User $user, Foo $foo)
    {
        //
    }

    /**
     * Determine whether the user can delete the foo.
     *
     * @param  \App\User  $user
     * @param  \App\Foo  $foo
     * @return mixed
     */
    public function delete(User $user, Foo $foo)
    {
        //
    }

    /**
     * Determine whether the user can restore the foo.
     *
     * @param  \App\User  $user
     * @param  \App\Foo  $foo
     * @return mixed
     */
    public function restore(User $user, Foo $foo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the foo.
     *
     * @param  \App\User  $user
     * @param  \App\Foo  $foo
     * @return mixed
     */
    public function forceDelete(User $user, Foo $foo)
    {
        //
    }
}
