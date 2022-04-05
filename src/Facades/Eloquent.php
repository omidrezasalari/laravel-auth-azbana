<?php

namespace Authenticate\Facades;

use Authenticate\User;
use Illuminate\Support\Str;

class Eloquent
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Check if exist mobile number in user table
     *
     * @param string $mobile user mobile number.
     *
     * @return null|User
     */
    public function exist(string $mobile): ?User
    {
        return $this->user->withTrashed()->where('mobile', $mobile)->first();
    }

    /**
     * Create new user
     *
     * @param object|array $mobile user mobile.
     *
     * @return User
     */
    public function create($request)
    {
        $user = $this->user->create([
            'full_name' => $request['full-name'],
            'mobile' => $request['mobile'],
            'username' => str_replace(" ", "_", $request['username']),
            'api_token' => Str::random(100)
        ]);

        return $user->makeVisible('api_token');

    }

    public function isBanned($mobile)
    {
        return $this->user->withTrashed()->IsBanned()->where('mobile', $mobile)->first();
    }

    public function getUserWithMobile($mobile)
    {
        return $this->user->withTrashed()->where('mobile', $mobile)->first();
    }

    public function checkUsernameExist($username, $uid = null)
    {
        $query = is_null($uid) ? $this->user->withTrashed() : $this->user
            ->withTrashed()->where('id', "<>", $uid);

        return (bool)$query->where('username', $username)->first();
    }

    public function UpdateApiToken($user)
    {
        $token = Str::random(100);
        $user->update(['api_token' => $token]);
        return $token;
    }
}
