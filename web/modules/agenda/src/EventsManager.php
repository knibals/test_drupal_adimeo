<?php

namespace Drupal\agenda;

use Drupal\node\NodeInterface;
use Drupal\Core\CronInterface;
use Drupal\Core\Queue\QueueFactory;
use Drupal\Core\Queue\QueueInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;

/**
 * Do things with the Events
 *
 * @see \Drupal\agenda\Plugin\QueueWorker\EventsUnpublisher
 */
class EventsManager implements CronInterface
{
    /**
     * The node storage.
     *
     * @var EntityStorageInterface
     */
    protected $nodeStorage;

    /**
     * The events_unpublisher queue.
     *
     * @var QueueInterface
     */
    protected $queue;

    /**
     * The logger channel.
     *
     * @var LoggerChannelInterface
     */
    protected $logger;

    /**
     * Constructs a new Cron object.
     *
     * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
     *   The entity type manager.
     * @param \Drupal\Core\Queue\QueueFactory $queue_factory
     *   The queue factory.
     * @param LoggerChannelFactoryInterface $logger_factory
     *   The logger channel factory.
     */
    public function __construct(EntityTypeManagerInterface $entity_type_manager, QueueFactory $queue_factory, $logger_factory = null)
    {
        $this->logger      = $logger_factory->get('adimeo');
        $this->queue       = $queue_factory->get('events_unpublisher');
        $this->nodeStorage = $entity_type_manager->getStorage('node');
    }

    /**
     * Trouve tous les évenements périmés
     *
     * @return array
     *  Un tableaux d'ID des évènements à dépublier.
     */
    public function getOutdatedEvents() :array
    {
        $now = new DrupalDateTime('now');

        $outdated_events = $this->nodeStorage->getQuery()
            ->condition('type', 'event')
            ->condition('field_date_end', $now, '<=')
            ->condition('status', NodeInterface::PUBLISHED)
            ->execute();
    
        return $outdated_events;
    }

    /**
     * Find and unpublish outdated Events
     *
     * @return void
     */
    public function run()
    {
        $outdated_events_nids = $this->getOutdatedEvents();
        // peut être vide (si les évènements expirés ont déjà été dépubliés)
        if (sizeof($outdated_events_nids) == 0) {
            $this->logger->info("Il n'y aucun évènement expiré, il n'y a rien à faire!");
            return; // partir loin!!
        }

        foreach (array_chunk($outdated_events_nids, 20) as $event_ids) {
            $this->queue->createItem($event_ids);
        }
    }
}
