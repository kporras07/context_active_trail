<?php

namespace Drupal\context_active_trail;

use Drupal\context\ContextManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Lock\LockBackendInterface;
use Drupal\Core\Menu\MenuActiveTrail;
use Drupal\Core\Menu\MenuLinkManagerInterface;
use Drupal\Core\Routing\RouteMatchInterface;

/**
 * Allow the active trail to be set manually.
 */
class ContextActiveTrail extends MenuActiveTrail {
  /**
   * The context manager.
   *
   * @var \Drupal\Context\ContextManager
   */
  protected $contextManager;

  /**
   * Constructor.
   *
   * @param \Drupal\Core\Menu\MenuLinkManagerInterface $menu_link_manager
   *   The menu link plugin manager.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   A route match object for finding the active link.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache
   *   The cache backend.
   * @param \Drupal\Core\Lock\LockBackendInterface $lock
   *   The lock backend.
   * @param \Drupal\Context\ContextManager $context_manager
   *   The context manager.
   */
  public function __construct(MenuLinkManagerInterface $menu_link_manager, RouteMatchInterface $route_match, CacheBackendInterface $cache, LockBackendInterface $lock, ContextManager $context_manager) {
    parent::__construct($menu_link_manager, $route_match, $cache, $lock);
    $this->contextManager = $context_manager;
    $this->tags[] = 'context_active_trail';
  }

  /**
   * {@inheritdoc}
   */
  public function getActiveLink($menu_name = NULL) {
    // Try to get the value from context.
    foreach ($this->contextManager->getActiveReactions('active_trail') as $reaction) {
      if ($link_id = $reaction->getLinkId()) {
        return $this->menuLinkManager->getInstance(['id' => $link_id]);
      }
    }

    // Fall back to the default.
    return parent::getActiveLink($menu_name);
  }

}
