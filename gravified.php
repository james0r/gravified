<?php

namespace Grav\Plugin;

use Composer\Autoload\ClassLoader;
use Grav\Common\Uri;
use Grav\Common\Flex;
use Grav\Common\Grav;
use Grav\Common\Utils;
use Grav\Common\Plugin;

use Grav\Plugin\Gravified\Utils as GravifiedUtils;

/**
 * Class GravifiedPlugin
 * @package Grav\Plugin
 */
class GravifiedPlugin extends Plugin {

  public $features = [
    'blueprints' => 2000,
  ];

  /**
   * @return array
   *
   * The getSubscribedEvents() gives the core a list of events
   *     that the plugin wants to listen to. The key of each
   *     array section is the event that the plugin listens to
   *     and the value (in the form of an array) contains the
   *     callable (or function) as well as the priority. The
   *     higher the number the higher the priority.
   */
  public static function getSubscribedEvents(): array {
    return [
      'onPluginsInitialized' => ['onPluginsInitialized', 0],
      'onTwigSiteVariables' => ['onTwigSiteVariables', 0],
    ];
  }

  /**
   * Initialize the plugin
   */
  public function onPluginsInitialized(): void {
    // Don't proceed if we are in the admin plugin
    if ($this->isAdmin()) {
      return;
    }

    // $uri = new Uri($this->grav);

    // dd($uri->base());

    // Enable the main events we are interested in
    $this->enable(
      [
        'onTwigTemplatePaths' => ['onTwigTemplatePaths', 1000],
      ]
    );
  }

  /**
   * @return ClassLoader
   */
  public function autoload(): ClassLoader {
    return require __DIR__ . '/vendor/autoload.php';
  }

  /**
   * Register templates
   *
   * @return void
   */
  public function onTwigTemplatePaths() {
    $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
  }

  /**
   * Adds the 'gravified_utils' variable to the Twig site variables.
   *
   * This method is called when Twig site variables are being set.
   * It adds a new instance of the GravifiedUtils class to the 'gravified_utils' variable in the Twig environment.
   *
   * @return void
   */
  public function onTwigSiteVariables() {
    $twig = $this->grav['twig'];

    $twig->twig_vars['gravified_utils'] = new GravifiedUtils;
  }
}
