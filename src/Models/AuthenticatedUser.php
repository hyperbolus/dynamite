<?php
namespace Hyperbolus\Dynamite\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Hyperbolus\Dynamite\Dynamite;
use Hyperbolus\Dynamite\Paginator;

class AuthenticatedUser extends User
{
    public bool $authenticated = false;

    public string $name;
    public ?string $password;

    /*
     * Account ID is a registration ID when you sign up with an email and password
     */
    public ?string $account_id;

    /**
     * Everyone has a player ID
     */
    public string $player_id;

    public int $stars;
    public int $demons;

    /**
     * User has no ranking if leaderboard banned
     */
    public ?int $ranking;

    public function __construct(string $username, string $password = '')
    {
        $this->name = $username;
        $this->password = gjp2($password);

        $res = gj_request('accounts/loginGJAccount', [
            'udid' => gj_udid(),
            'userName' => $username,
            'gjp2' => $this->password,
            'secret' => 'Wmfv3899gc9',
        ]);

        $matches = [];

        if (preg_match('/(\d+),(\d+)/', $res, $matches, PREG_UNMATCHED_AS_NULL)) {
            $this->account_id = $matches[1];
            $this->player_id = $matches[2];
        } else {
            $j = match ($res) {
                '-1' => 1,
                '-8' => 1,
                '-9' => 1,
                '-11' => 1,
                '-12' => 1,
                '-13' => 1,
            };
        }

        $this->authenticated = true;
    }

    /**
     * @param int $page
     * @return Paginator<Message>
     */
    public function messages(int $page = 0) {
        $res = gj_request('getGJMessages20', [
            'page' => $page,
            'total' => 0,
            'secret' => 'Wmfd2893gb7',
            'accountID' => $this->account_id,
            'gjp2' => $this->password,
        ]);

        return Paginator::parse($res, Message::class);
    }

    public function messagesSent(int $page): array {
        gj_request('getGJMessages20', [
            'page' => 0,
            'total' => 0,
            'secret' => 'Wmfd2893gb7',
            'accountID' => $this->account_id,
            'gjp2' => $this->password,
        ]);

        return [];
    }
}