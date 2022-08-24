<?php

namespace Drupal\agenda\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;

/**
 * Defines the 'events_unpublisher' queue worker.
 *
 * @QueueWorker(
 *   id = "events_unpublisher",
 *   title = @Translation("Events unpublisher"),
 *   cron = {"time" = 60}
 * )
 */
class EventsUnpublisher extends QueueWorkerBase
{
    /**
     * {@inheritdoc}
     */
    public function processItem($nodes)
    {
        if (!empty($nodes)) {
            \Drupal::service('events.manager')->unpublishEvents($nodes);
        }
    }
}
