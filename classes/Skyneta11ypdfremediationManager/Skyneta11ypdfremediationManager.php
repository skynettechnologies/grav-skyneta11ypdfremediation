<?php

namespace Grav\Plugin\Skyneta11ypdfremediation\Classes\Skyneta11ypdfremediationManager;

use Grav\Common\Grav;
use Grav\Common\Utils;
use Grav\Common\Data\Data;
use Grav\Common\Data\Blueprints;
use Grav\Common\File\CompiledYamlFile;

/**
 * SkynetA11y PDF Remediation Plugin Class
 *
 */
class Skyneta11ypdfremediationManager extends Data {

    /**
     * Get the SkynetA11y PDF Remediation data list from user/data/ yaml files
     *
     * @return array
     */
    public static function getSkyneta11ypdfremediationManagerData() {

        $pdfWidgetData = self::getYamlDataObjType(self::getCurrentSkyneta11ypdfremediationManagerPath());

        return $pdfWidgetData;
    }

    /**
     * Get the  skyneta11ypdfremediation manager twig vars
     *
     * @return array
     */
    public static function getSkyneta11ypdfremediationManagerDataTwigVars() {

        $vars = [];

        $blueprints = self::getCurrentSkyneta11ypdfremediationManagerBlueprint();
        $content = self::getSkyneta11ypdfremediationManagerData();

        $pdfWidgetData  = new Data($content, $blueprints);

        $vars['pdfWidgetData'] = $pdfWidgetData;

        return $vars;
    }

    /**
     * get current  skyneta11ypdfremediation manager blueprint
     *
     * @return \Grav\Common\Data\Blueprint
     */
    public static function getCurrentSkyneta11ypdfremediationManagerBlueprint() {

        $blueprints = new Blueprints;
        $currentSkyneta11ypdfremediationManagerBlueprint = $blueprints->get(self::getCurrentSkyneta11ypdfremediationManagerPath());

        return $currentSkyneta11ypdfremediationManagerBlueprint;
    }

    /**
     * get current path of  skyneta11ypdfremediation manager for config info
     *
     * @return string
     */
    public static function getCurrentSkyneta11ypdfremediationManagerPath(): string
    {

        $uri = Grav::instance()['uri'];
        $currentSkyneta11ypdfremediationManagerPath = 'skyneta11ypdfremediation-manager';

        if(isset($uri->paths()[1])){
            $currentSkyneta11ypdfremediationManagerPath = $uri->paths()[1];
        }

        return $currentSkyneta11ypdfremediationManagerPath;
    }

    /**
     * get data object of given type
     *
     * @return array
     */
    public static function getYamlDataObjType($type): array
    {

        //location of yaml files
        $dataStorage = 'user://data';

        return CompiledYamlFile::instance(Grav::instance()['locator']->findResource($dataStorage) . DS . $type . ".yaml")->content();
    }



}
