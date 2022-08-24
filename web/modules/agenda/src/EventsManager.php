<?php

namespace Drupal\agenda;

use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Do things with the Events
 */
class EventsManager
{
    /**
     * Trouve tous les évenemenets périmés
     *
     * @return string
     */
    public function getOutdated() :array
    {
        $now = new DrupalDateTime('now');

        $expired_events = \Drupal::entityQuery('node')
            ->condition('type', 'event')
            ->condition('field_date_end', $now, '<=')
            ->condition('status', NodeInterface::PUBLISHED);

        $nids  = $expired_events->execute();
        
        return $nids;
    }


    /**
     * The method who marks the node for unpublishing
     *
     * @param array $nids
     * @return boolean
     */
    function unpublishEvents(array $nids) :void
    {
        $nodes = Node::loadMultiple($nids);

        foreach ($nodes as $node) {
            $node->setUnpublished();
            $node->save();

            \Drupal::logger('agenda')->notice(sprintf("L'évènement '%s' a été dépublié.", $node->getTitle()));
        }
    }
}
