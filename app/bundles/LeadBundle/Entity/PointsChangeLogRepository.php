<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\LeadBundle\Entity;

use Mautic\CoreBundle\Entity\CommonRepository;
use Doctrine\ORM\Query;

/**
 * PointsChangeLogRepository
 */
class PointsChangeLogRepository extends CommonRepository
{
    use TimelineTrait;

    /**
     * Get a lead's point log
     *
     * @param integer $leadId
     * @param array   $options
     *
     * @return array
     */
    public function getLeadTimelineEvents($leadId, array $options = array())
    {
        $query = $this->getEntityManager()->getConnection()->createQueryBuilder()
            ->from(MAUTIC_TABLE_PREFIX.'lead_points_change_log', 'lp')
            ->select('lp.event_name as eventName, lp.action_name as actionName, lp.date_added as dateAdded, lp.type, lp.delta, lp.id');

        if (null !== $leadId) {
            $query->where('lp.lead_id = ' . (int) $leadId);
        }

        if (isset($options['search']) && $options['search']) {
            $query->andWhere($query->expr()->orX(
                $query->expr()->like('lp.event_name', $query->expr()->literal('%' . $options['search'] . '%')),
                $query->expr()->like('lp.action_name', $query->expr()->literal('%' . $options['search'] . '%'))
            ));
        }

        return $this->getTimelineResults($query, $options, 'lp.event_name', 'lp.date_added', [], ['dateAdded']);
    }

    /**
     * Get table stat data from point log table
     *
     * @param QueryBuilder $query
     *
     * @return array
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getMostPoints($query, $limit = 10, $offset = 0)
    {
        $query->setMaxResults($limit)
                ->setFirstResult($offset);

        $results = $query->execute()->fetchAll();
        return $results;
    }

    /**
     * Get table stat data from lead table
     *
     * @param QueryBuilder $query
     *
     * @return array
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getMostLeads($query, $limit = 10, $offset = 0)
    {
        $query->setMaxResults($limit)
                ->setFirstResult($offset);

        $results = $query->execute()->fetchAll();
        return $results;
    }

    /**
     * Count a value in a column
     *
     * @param QueryBuilder $query
     *
     * @return array
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countValue($query, $column, $value)
    {
        $query->select('count(' . $column . ') as quantity')
            ->from(MAUTIC_TABLE_PREFIX.'leads', 'l')
            ->leftJoin('l', MAUTIC_TABLE_PREFIX.'lead_points_change_log', 'lp', 'lp.lead_id = l.id')
            ->andwhere($query->expr()->eq($column, ':value'))
            ->setParameter('value', $value);

        $result = $query->execute()->fetch();

        return $result['quantity'];
    }

    /**
     * Updates lead ID (e.g. after a lead merge)
     *
     * @param $fromLeadId
     * @param $toLeadId
     */
    public function updateLead($fromLeadId, $toLeadId)
    {
        $q = $this->_em->getConnection()->createQueryBuilder();
        $q->update(MAUTIC_TABLE_PREFIX . 'lead_points_change_log')
            ->set('lead_id', (int) $toLeadId)
            ->where('lead_id = ' . (int) $fromLeadId)
            ->execute();
    }

    /**
     * @return string
     */
    public function getTableAlias()
    {
        return 'lp';
    }
}
