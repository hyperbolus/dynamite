<?php

namespace Hyperbolus\Dynamite;

use JetBrains\PhpStorm\ExpectedValues;

class Transform
{
    public array $args = [];

    const array PAIRS = [
        'url64' => ['url64encode', 'url64decode'],
        'xor' => ['xor', 'xor'],
    ];

    /**
     * @param key-of<Transform> $transformation
     * @param array ...$arguments
     */
    public function __construct(
        #[ExpectedValues(['url64', 'xor'])]
        public int|string $transformation,
        mixed      ...$arguments
    ) {
        $this->args = $arguments;
    }

    public function run(mixed $data, bool $deserialize = false): mixed
    {
        return static::{self::PAIRS[$this->transformation][$deserialize ? 1 : 0]}($data, ...$this->args);
    }

    public static function url64encode(string $data): string
    {
        return base64_urlencode($data);
    }

    public static function url64decode(string $data): string
    {
        return base64_urldecode($data);
    }

    public static function xor(string $data, string $key): string
    {
        $out = '';

        for ($i = 0; $i < strlen($data);) {
            for ($j = 0; ($j < strlen($key) && $i < strlen($data)); $j++, $i++) {
                $out .= $data[$i] ^ $key[$j];
            }
        }

        return $out;
    }
}