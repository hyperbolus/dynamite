<?php
namespace Hyperbolus\Dynamite\Models;

use Hyperbolus\Dynamite\Attributes\Serializable;
use Hyperbolus\Dynamite\Traits\GJSerializable;
use Hyperbolus\Dynamite\Transform;

class Message
{
    use GJSerializable;

    #[Serializable(1)]
    public int $id;

    #[Serializable(2)]
    public int $account_id;

    #[Serializable(3)]
    public int $player_id;

    #[Serializable(6)]
    public string $username;

    #[Serializable(7)]
    public string $age;


    #[Serializable(8)]
    public bool $read;

    #[Serializable(9)]
    public bool $sender;


    #[Serializable(4, [new Transform('deb64')])]
    public string $title;

    #[Serializable(5, [new Transform('xor', GJ_XOR_MESSAGE), new Transform('deb64')])]
    public ?string $message;

    public function __construct()
    {

    }

    public static function delete(int|array $message) {

    }

    public static function send(int|array $message) {

    }

    public static function download(int|array $message) {

    }
}