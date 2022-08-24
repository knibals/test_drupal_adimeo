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
class SimilarEventsBlock extends BlockBase
{
    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $current_nid   = \Drupal::routeMatch()->getParameter('node')->Id();
        $current_event = Node::load($current_nid);
        $event_type_id = $current_event->field_event_type->target_id;

        $query = \Drupal::entityQuery('node')
            ->condition('type', 'event')
            ->condition('field_event_type', $event_type_id)
            ->condition('status', NodeInterface::PUBLISHED)
            ->condition('nid', $current_event->id(), '<>')
            ->sort('nid')
            ->range(0, 3);
        $nids = $query->execute();

        // si aucun evenement n'a été trouvé
        // on affiche pas le bloc du tout
        if (sizeof($nids) == 0) {
            return false;
        }
        
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
