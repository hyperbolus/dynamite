<?php

require_once '../vendor/autoload.php';

use Hyperbolus\Dynamite\Models\AuthenticatedUser;

$user = new AuthenticatedUser('RobTopGames', 'plaintext-password');
dump($user->messages());