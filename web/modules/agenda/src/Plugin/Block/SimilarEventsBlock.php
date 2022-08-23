<?php

namespace Drupal\agenda\Plugin\Block;

use Drupal\Core\Link;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;
use Drupal\Core\Block\BlockBase;

/**
 * Provides an similar events block.
 *
 * @Block(
 *   id = "similar_events",
 *   admin_label = @Translation("Similar Events"),
 *   category = @Translation("Adimeo")
 * )
 */
class SimilarEventsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $current_nid   = \Drupal::routeMatch()->getParameter('node')->Id();
    $current_event = Node::load($current_nid);

    $query = \Drupal::entityQuery('node')
              ->condition('type', 'event')
              ->condition('field_event_type', $current_event->field_event_type->target_id)
              ->condition('status', NodeInterface::PUBLISHED)
              ->condition('nid', $current_event->id(), '<>')
              ->sort('nid')
              ->range(0, 3);
    $nids  = $query->execute();
    $nodes = Node::loadMultiple($nids);
    
    foreach ($nodes as $node) {
      $options = ['absolute' => true, 'attributes' => ['class' => 'goto-event']];
      $items[] = Link::fromTextAndUrl(
        $node->getTitle(),
        $node->toUrl('canonical', $options)
      );
    }

    $build['content'] = [
      '#theme'      => 'item_list',
      '#list_type'  => 'ol',
      '#items'      => $items,
      '#attributes' => ['class' => 'similar-events'],
    ];
    return $build;
  }

}
