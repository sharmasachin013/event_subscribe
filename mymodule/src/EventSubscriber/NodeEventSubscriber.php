<?php

namespace Drupal\mymodule\EventSubscriber;



use Drupal\core_event_dispatcher\Event\Entity\EntityInsertEvent;
use Drupal\core_event_dispatcher\EntityHookEvents;
use Drupal\core_event_dispatcher\Event\Entity\EntityUpdateEvent;
use Drupal\core_event_dispatcher\Event\Entity\EntityViewEvent;
use Drupal\node\NodeInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class NodeEventSubscriber.
 *
 * Listens to node insert, update, and delete events.
 */
class NodeEventSubscriber implements EventSubscriberInterface {
/**
   * Reacts when a node is inserted.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Entity\EntityInsertEvent $event
   *   The event object.
   */

      public function entityInsert(EntityInsertEvent $event) {
    $entity = $event->getEntity();

    // Ensure it's a node entity.
    if ($entity instanceof \Drupal\node\NodeInterface) {
      \Drupal::messenger()->addMessage('A node of type ' . $entity->getType() . ' with title "' . $entity->getTitle() . '" has been created.');
      \Drupal::logger('mymodule')->info('Node created: @title', ['@title' => $entity->getTitle()]);
    }
  }


    /**
   * Entity update.
   *
   * @param \Drupal\core_event_dispatcher\Event\Entity\EntityUpdateEvent $event
   *   The event.
   */
  public function entityUpdate(EntityUpdateEvent $event): void {
      $entity = $event->getEntity();
    if ($entity instanceof \Drupal\node\NodeInterface) {
       \Drupal::messenger()->addMessage('A node of type ' . $entity->getType() . ' with title "' . $entity->getTitle() . '" has been updated.....');
     
    }
  }

    /**
   * Alter entity view.
   *
   * @param \Drupal\core_event_dispatcher\Event\Entity\EntityViewEvent $event
   *   The event.
   */
  public function alterEntityView(EntityViewEvent $event): void {
    $entity = $event->getEntity();



    // Only do this for entities of type Node.
    if ($entity instanceof NodeInterface) {
      $build = &$event->getBuild();
      $build['extra_markup'] = [
        '#markup' => 'this is extra markup',
      ];
    }
  }

  /**
   * {@inheritdoc}
   */
public static function getSubscribedEvents(): array {
    return [

      EntityHookEvents::ENTITY_INSERT => 'entityInsert',
      EntityHookEvents::ENTITY_VIEW => 'alterEntityView',
      EntityHookEvents::ENTITY_UPDATE => 'entityUpdate',

    ];
  }
}
