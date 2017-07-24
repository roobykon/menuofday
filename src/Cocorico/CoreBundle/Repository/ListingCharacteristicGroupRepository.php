<?php

/*
 * This file is part of the Cocorico package.
 *
 * (c) Cocolabs SAS <contact@cocolabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocorico\CoreBundle\Repository;

use Cocorico\CoreBundle\Entity\ListingCharacteristicGroup;
use Doctrine\ORM\EntityRepository;

class ListingCharacteristicGroupRepository extends EntityRepository
{
    /**
     * @param                           $locale
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllTranslatedQueryBuilder($locale)
    {
        $queryBuilder = $this->createQueryBuilder('lcg')
            ->leftJoin('lcg.translations', 'lcgt')
            ->andWhere('lcgt.locale = :locale')
            ->setParameter('locale', $locale);
//        $queryBuilder->getQuery()->useQueryCache(true);
//        $queryBuilder->getQuery()->useResultCache(true, 3600, 'listing_characteristic_values');
        return $queryBuilder;
    }

    /**
     * @param string $locale
     *
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findAllTranslated($locale)
    {
        $characteristicGroups = $this->findAllTranslatedQueryBuilder($locale)
            ->getQuery()
            ->getResult();
        $result = [];
        /**@var $group ListingCharacteristicGroup */
        foreach ($characteristicGroups as $group){
            $result[$group->getName()] = $group;
        }
        return $result;
    }
}
