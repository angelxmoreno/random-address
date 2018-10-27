<?php

namespace DataNormalizer;

use Cake\Core\BasePlugin;
use Cake\Core\Configure;

/**
 * Plugin for DataNormalizer
 */
class Plugin extends BasePlugin
{
    public const DATA_DIR = OPENADDRESS_DIR;

    public static function dataDir()
    {
        return ROOT . Configure::readOrFail('openaddress.data_dir');
    }
}

define('OPENADDRESS_DIR', Plugin::dataDir());
