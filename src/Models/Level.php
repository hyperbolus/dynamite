<?php
namespace Hyperbolus\Dynamite\Models;

class Level
{

    public int $id;
    public string $name;
    public string $description;

    public function __construct()
    {

    }

    public function download(): DownloadedLevel {
        return new DownloadedLevel();
    }

    /**
     * @param string|array $levels
     * @return Level[]
     */
    public static function batch(string|array $levels): array
    {
        if (is_array($levels)) {
            $levels = join(',', $levels);
        }

        $res = gj_request('getGJLevels21', [
            'secret' => 'Wmfd2893gb7',
            'type' => 26,
            'str' => $levels
        ]);
    }
}