<?php
namespace Hyperbolus\Dynamite\Models;

use Hyperbolus\Dynamite\Attributes\Serializable;
use Hyperbolus\Dynamite\Transform;

class DownloadedLevel extends Level
{
    #[Serializable(4)]
    public string $levelData;

    #[Serializable(27, [new Transform('xor', GJ_XOR_LEVEL_PASSWORD), new Transform('url64')])]
    public string $password;

    #[Serializable(28)]
    public string $uploadDate;

    #[Serializable(29)]
    public string $updateDate;

    #[Serializable(40)]
    public string $lowDetailMode;

    #[Serializable(41)]
    public string $dailyNumber;

    #[Serializable(52)]
    public string $songIDs;

    #[Serializable(52)] // needs special parsing
    public string $sfxIDs;

    #[Serializable(57)]
    public int $verificationTime;

    #[Serializable(62)]
    public int $exactUploadTime;

    #[Serializable(63)]
    public int $exactUpdateTime;

    public function __construct()
    {

    }

    public static function fromID(int $id)
    {
        $res = gj_request('downloadGJLevel22', [
            'secret' => 'Wmfd2893gb7',
            'levelID' => $id,
        ]);

        $res = explode('#', $res);

        dd(gj_map($res[0], ':'), $res[1], $res[2]);

        return DownloadedLevel::deserialize(gj_map($res, ':'));
    }
}