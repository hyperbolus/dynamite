<?php
namespace Hyperbolus\Dynamite\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Hyperbolus\Dynamite\Dynamite;

class UserProfile extends User
{
    public bool $authenticated = false;

    public string $name;

    /*
     * Account ID is a registration ID when you sign up with an email and password
     */
    public ?string $account_id;

    /**
     * Everyone has a player ID
     */
    public string $player_id;

    public function __construct(string $username, ?string $password)
    {

    }

    /**
     * @throws GuzzleException
     */
    public function login(): bool {
        gj_request('loginGJAccount', [

        ]);
        return false;
    }
}