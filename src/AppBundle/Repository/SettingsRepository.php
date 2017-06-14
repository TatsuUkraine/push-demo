<?php

namespace PushDemo\AppBundle\Repository;


use PushDemo\AppBundle\Entity\Settings;
use PushDemo\AppBundle\Repository\Contract\SettingsRepository as SettingsRepositoryContract;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;

class SettingsRepository extends EntityRepository implements SettingsRepositoryContract
{

    /**
     * @param Settings $entity
     * @return Settings
     */
    public function save(Settings $entity): Settings
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
        return $entity;
    }

    /**
     * @param string $token
     * @return Settings|null
     */
    public function findByToken(string $token)
    {
        $criteria = Criteria::create()->where(
            Criteria::expr()->eq('token', $token)
        )->setMaxResults(1);

        return $this
            ->createQueryBuilder($this->getEntityName())
            ->addCriteria($criteria)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return Settings[]
     */
    public function findActive(): array
    {
        $criteria = Criteria::create()->where(
            Criteria::expr()->eq('isDeleted', false)
        );

        return $this
            ->createQueryBuilder($this->getEntityName())
            ->addCriteria($criteria)
            ->getQuery()
            ->getResult();
    }
}