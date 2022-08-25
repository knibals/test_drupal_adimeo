<?php

namespace Drupal\agenda\Plugin\QueueWorker;

use Drupal\node\Entity\Node;
use Drupal\Core\Queue\QueueWorkerBase;

/**
 * Defines the 'events_unpublisher' queue worker.
 *
 * @QueueWorker(
 *   id = "events_unpublisher",
 *   title = @Translation("Events unpublisher"),
 *   cron = {"time" = 10}
 * )
 */
class EventsUnpublisher extends QueueWorkerBase
{
    /**
     * {@inheritdoc}
     */
    public function processItem($events)
    {
        foreach (Node::loadMultiple($events) as $node) {
            $node->setUnpublished();
            $node->save();
        }
    }
}
