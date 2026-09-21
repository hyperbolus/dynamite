<?php

require_once '../vendor/autoload.php';

use Hyperbolus\Dynamite\Models\Level;

ini_set('display_errors', 1);

dump(Level::batch([10565740, 13519, 4284013, 55520]));

// Paginator<Level> {
//   Level(10565740),
//   Level(13519),
//   Level(4284013),
//   Level(55520),
// }