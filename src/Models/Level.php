<?php
namespace Hyperbolus\Dynamite\Models;

use Hyperbolus\Dynamite\Attributes\Serializable;
use Hyperbolus\Dynamite\Traits\GJSerializable;
use Hyperbolus\Dynamite\Transform;

class Level
{
    use GJSerializable;

    #[Serializable(1)]
    public int $id;

    #[Serializable(2)]
    public string $name;

    #[Serializable(3, new Transform('url64'))]
    public string $description;

    #[Serializable(5)]
    public int $version;

    #[Serializable(6)]
    public int $player_id;

    #[Serializable(8)]
    public int $difficultyDenominator;

    #[Serializable(9)]
    public int $difficultyNumerator;

    #[Serializable(10)]
    public int $downloads;

    #[Serializable(11, deprecated: true)]
    public ?int $setCompletes = null;

    #[Serializable(12)]
    public int $officialSong;

    #[Serializable(13)]
    public int $gameVersion;

    #[Serializable(14)]
    public ?int $likes = null;

    #[Serializable(14)]
    public int $length;

    #[Serializable(16)]
    public ?int $dislikes = null;

    #[Serializable(17)]
    public bool $isDemon = false;

    #[Serializable(18)]
    public int $stars;

    #[Serializable(19)]
    public int $featureScore;

    #[Serializable(25)]
    public bool $isAuto = false;

    #[Serializable(26, deprecated: true)]
    public ?string $recordString = null; // appears in code but is unused

    #[Serializable(30)]
    public int $copied_id;

    #[Serializable(36)]
    public ?string $extraString = null;

    #[Serializable(37)]
    public int $coins;

    #[Serializable(38)]
    public bool $verifiedCoins;

    #[Serializable(39)]
    public int $starsRequested;

    #[Serializable(42)]
    public int $epicRating;

    #[Serializable(43)]
    public int $demonDifficulty;

    #[Serializable(44)]
    public ?bool $isGauntlet = false;

    #[Serializable(45)]
    public ?int $objects = null; // caps at 65535

    #[Serializable(46)]
    public int $editorTime;

    #[Serializable(47)]
    public ?int $editorTimeCopies = null;

    // 48 - setting strings
    // 54 - unknown, k106 in save file

    public function __construct()
    {

    }

    public function download(): DownloadedLevel {
        return DownloadedLevel::fromID($this->id);
    }

    /**
     * @param array $levels
     * @return Level[]
     */
    public static function batch(array $levels): array
    {
        $res = gj_request('getGJLevels21', [
            'secret' => 'Wmfd2893gb7',
            'type' => 26,
            'str' => join(',', $levels),
        ]);

        $bits = explode('#', $res);

        $levels = [];
        $users = [];
        $songs = [];

        foreach (explode('|', $bits[1]) as $user) {
            $user = explode(':', $user);

            $users[$user[0]] = [
                'player_id' => $user[0],
                'name' => $user[1],
                'account_id' => $user[2],
            ];
        }

        foreach (explode('~:~', $bits[2]) as $song) $songs[] = gj_map($song, '~|~');

        foreach (explode('|', $bits[0]) as $level) {
            $obj = Level::deserialize(gj_map($level, ':'));

            $obj->uploader = $users[$obj->player_id];
//            $obj->song = null;

            $levels[] = $obj;
        }

        return $levels;
    }
}