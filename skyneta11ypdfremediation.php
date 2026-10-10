<?php
/**
 * @package    Grav\Plugin\Skyneta11ypdfremediation
 *
 * @copyright  Copyright (C) 2023 Skynet Technologies USA LLC
 * @license    MIT License; see LICENSE file for details.
 */
namespace Grav\Plugin;

use Grav\Common\Grav;
use Grav\Common\Utils;
use Grav\Common\Plugin;
use Grav\Common\Data\Data;
use Grav\Common\Data\Blueprints;
use Grav\Common\File\CompiledYamlFile;

use RocketTheme\Toolbox\Event\Event;

use Grav\Plugin\Skyneta11ypdfremediation\Classes\Skyneta11ypdfremediationManager\Skyneta11ypdfremediationManager;
use Grav\Plugin\Skyneta11ypdfremediation\Classes\Skyneta11ypdfremediationConsent\Skyneta11ypdfremediationConsent;

require_once __DIR__ . '/classes/Skyneta11ypdfremediationManager/Skyneta11ypdfremediationManager.php';
require_once __DIR__ . '/classes/Skyneta11ypdfremediationConsent/Skyneta11ypdfremediationConsent.php';

/**
 * Class Skyneta11ypdfremediationPlugin
 * @package Grav\Plugin
 */
class Skyneta11ypdfremediationPlugin extends Plugin {

    protected $routes = [
        'skyneta11ypdfremediation-manager'
    ];

    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to.
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
            'onApiSidebarItems'    => ['onApiSidebarItems', 0],
            'onApiPluginPageInfo'  => ['onApiPluginPageInfo', 0],
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        if (!$this->isAdmin()) {
            $this->enable([
                'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            ]);
        }
    }

    /**
     * Add Routes to the custom data pages when the admin menu is being loaded
     */
    public function onApiSidebarItems(Event $event): void
    {
        $items = $event['items'] ?? [];

        $items[] = [
            'id'        => 'skyneta11ypdfremediation',
            'plugin'    => 'skyneta11ypdfremediation',
            'label'     => 'SkynetA11y PDF Remediation',
            'icon'      => 'fa-file-pdf',
            'route'     => '/plugin/skyneta11ypdfremediation',
            'priority'  => 20,
            'authorize' => 'admin.super',
        ];

        $event['items'] = $items;
    }

    public function onApiPluginPageInfo(Event $event): void
    {
        if (($event['plugin'] ?? '') !== 'skyneta11ypdfremediation') {
            return;
        }

        $event['definition'] = [
            'id'        => 'skyneta11ypdfremediation',
            'plugin'    => 'skyneta11ypdfremediation',
            'title'     => 'SkynetA11y PDF Remediation',
            'icon'      => 'fa-file-pdf',
            'page_type' => 'component',
            'component' => 'skyneta11ypdfremediation',
        ];
    }

    /**
     * Push plugin templates to twig paths array.
     * FRONTEND
     */
    public function onTwigTemplatePaths() {
        array_push($this->grav['twig']->twig_paths, __DIR__ . '/templates');
    }
}
