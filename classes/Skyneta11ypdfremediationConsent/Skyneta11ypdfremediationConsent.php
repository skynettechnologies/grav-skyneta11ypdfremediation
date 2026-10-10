<?php

namespace Grav\Plugin\Skyneta11ypdfremediation\Classes\Skyneta11ypdfremediationConsent;

use Grav\Common\Grav;
use Grav\Common\Utils;
use Grav\Common\Data\Data;
use Grav\Common\File\CompiledYamlFile;


/**
 * SkynetA11y PDF Remediation Plugin skyneta11ypdfremediation manager Class
 *
 */
class Skyneta11ypdfremediationConsent extends Data {

    /**
     * get data object of given type
     *
     * @return object
     */
    public static function getYamlDataByType($type) {

        //location of yaml files
        $dataStorage = 'user://data';

        return CompiledYamlFile::instance(Grav::instance()['locator']->findResource($dataStorage) . DS . $type . ".yaml")->content();
    }

}
