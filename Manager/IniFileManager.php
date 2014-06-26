<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\CoreBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("claroline.manager.ini_file_manager")
 */
class IniFileManager
{
    /**
     * @param array $parameters
     * @param string $iniFile
     *
     * @throws \Exception
     */
    public function writeIniFile(array $parameters, $iniFile)
    {
        $content = '';

        foreach ($parameters as $key => $value) {
            $content .= "{$key} = {$value}\n";
        }

        if (!file_put_contents($iniFile, $content)) {
            throw new \Exception("The claroline cache couldn't be created");
        }
    }

    public function updateKey($key, $value, $iniFile)
    {
        $values = file_exists($iniFile) ? parse_ini_file($iniFile): [];
        $values[$key] = $value;

        $this->writeIniFile($values, $iniFile);
    }
}