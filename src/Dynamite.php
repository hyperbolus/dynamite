<?php
namespace Hyperbolus\Dynamite;

class Dynamite
{
    public static string $endpoint = 'https://www.boomlings.com/database/';
    public static array $proxies = [];
    private static int $currentProxy = 0;
}