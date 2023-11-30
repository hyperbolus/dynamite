<?php

use Hyperbolus\Dynamite\Models\AuthenticatedUser;

$user = new AuthenticatedUser('SeeBeyond', 'Majestic12345!');
var_dump($user->messages());