<?php

namespace Drupal\agenda\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;

/**
 * Defines 'agenda_events_unpublisher' queue worker.
 *
 * @QueueWorker(
 *   id = "agenda_events_unpublisher",
 *   title = @Translation("Events unpublisher"),
 *   cron = {"time" = 60}
 * )
 */
class EventsUnpublisher extends QueueWorkerBase {

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    // @todo Process data here.
  }

}
