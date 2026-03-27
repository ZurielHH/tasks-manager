<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Listener;

use App\Shared\Domain\AuditTimestamps;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\{PrePersistEventArgs, PreUpdateEventArgs};

final class AuditTimestampsListener
{
    public function prePersist(object $entity, PrePersistEventArgs $args): void
    {
        $this->setTimestamps($entity, $args->getObjectManager(), true);
    }

    public function preUpdate(object $entity, PreUpdateEventArgs $args): void
    {
        $this->setTimestamps($entity, $args->getObjectManager(), false);
    }

    private function setTimestamps(object $entity, EntityManagerInterface $entityManager, bool $isNew): void
    {
        $metadata = $entityManager->getClassMetadata(get_class($entity));

        if (!$metadata->hasField('auditTimestamps')) {
            return;
        }

        $timestamps = $metadata->getFieldValue($entity, 'auditTimestamps');

        if ($isNew && null === $timestamps) {
            $metadata->setFieldValue($entity, 'auditTimestamps', new AuditTimestamps());
        } elseif (!$isNew && $timestamps instanceof AuditTimestamps) {
            $timestamps->touch();
        }
    }
}
