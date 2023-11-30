<?php
const GJ_XOR_SAVE_DATA = 11;
const GJ_XOR_MESSAGE = 14251;
const GJ_XOR_VAULT_CODE = 19283;
const GJ_XOR_LEVEL_PASSWORD = 26364;
const GJ_XOR_LEVEL_SEED2 = 41274;
const GJ_XOR_LEVEL_LEADERBOARD = 39673;
const GJ_XOR_VAULT = 1;
const GJ_XOR_CHK_LIKE = 58281;
const GJ_XOR_CHK_COMMENT = 29481;
const GJ_XOR_GJP = 37526;
const GJ_XOR_DAILY_CHESTS = 59182;

const GJ_ENDPOINTS = [
    "deleteGJLevelUser20",
    "rateGJDemon21",
    "suggestGJStars20",
    "registerGJAccount",
    "loginGJAccount",
    "syncGJAccountNew",
    "backupGJAccountNew",
    "updateGJAccSettings20",
    "getAccountURL",
    "acceptGJFriendRequest20",
    "blockGJUser20",
    "deleteGJAccComment20",
    "deleteGJComment20",
    "deleteGJFriendRequests20",
    "deleteGJMessages20",
    "downloadGJLevel22",
    "downloadGJMessage20",
    "getGJAccountComments20",
    "getGJChallenges",
    "getGJCommentHistory",
    "getGJComments21",
    "getGJDailyLevel",
    "getGJFriendRequests20",
    "getGJGauntlets21",
    "getGJLevelScores211",
    "getGJLevels21",
    "getGJMapPacks21",
    "getGJMessages20",
    "getGJRewards",
    "getGJScores20",
    "getGJSongInfo",
    "getGJTopArtists",
    "getGJUserList20",
    "getGJUsers20",
    "getSaveData",
    "likeGJItem211",
    "rateGJStars211",
    "readGJFriendRequest20",
    "removeGJFriend20",
    "reportGJLevel",
    "requestUserAccess",
    "restoreGJItems",
    "unblockGJUser20",
    "updateGJDesc20",
    "updateGJUserScore22",
    "uploadFriendRequest20",
    "uploadGJAccComment20",
    "uploadGJComment21",
    "uploadGJLevel21",
    "uploadGJMessage20"
];

if (!function_exists('gj_unmap')) {
    function gj_unmap($dict, $separator): string
    {
        $string = '';
        foreach ($dict as $key => $value) {
            $string .= "$separator$key$separator$value";
        }
        return $string;
    }
}

if (!function_exists('gj_map')) {
    function gj_map($list, $separator): array
    {
        $bits = explode($separator, $list);
        $array = [];
        for ($i = 1; $i < count($bits); $i += 2) {
            $array[$bits[$i - 1]] = $bits[$i];
        }
        return $array;
    }
}


if (!function_exists('xor_key')) {
    function xor_key(string $str, string $key): string
    {
        $out = '';

        for ($i = 0; $i < strlen($str);) {
            for ($j = 0; ($j < strlen($key) && $i < strlen($str)); $j++, $i++) {
                $out .= $str[$i] ^ $key[$j];
            }
        }

        return $out;
    }
}

if (!function_exists('gj_request')) {
    function gj_request(string $url, array $parameters): string
    {
        if (!in_array($url, GJ_ENDPOINTS)) throw new Error('Unknown Endpoint');

        $client = new \GuzzleHttp\Client([
            'headers' => [
                'User-Agent' => ''
            ],
            'form_params' => $parameters
        ]);
        return (string)$client->post(\Hyperbolus\Dynamite\Dynamite::$endpoint . $url . '.php')->getBody();
    }
}

if (!function_exists('gjp')) {
    function gjp(string $password): string
    {
        return base64_urlencode(xor_key('', GJ_XOR_GJP));
    }
}


if (!function_exists('base64_urlencode')) {
    function base64_urlencode($string): string
    {
        return base64_encode(strtr($string, '+/', '-_'));
    }
}

if (!function_exists('base64_urldecode')) {
    function base64_urldecode($string): bool|string
    {
        return base64_decode(strtr($string, '-_', '+/'), true);
    }
}
