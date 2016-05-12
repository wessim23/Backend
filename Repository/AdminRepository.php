<?php

namespace px\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * AdminRepository.
 *
 * @author Safwen Toukabri <safwen.toukabri@proxym-it.com>
 */
class AdminRepository extends EntityRepository
{
    public function findAllByFiltre($config, $getRequest = array(), $params = null)
    {
        $tab_form_q = array();

        $query = $this->createQueryBuilder($config['main_alias']);

        $this->extendQuery($query, $config, $getRequest, $params);
        //Trie par colonne
        if (isset($getRequest['iSortCol_0'])) {
            $indexsort = $getRequest['iSortCol_0'];
            $sens = $getRequest['sSortDir_0'];
            $col = $config['main_alias'].'.'.$config['fields'][$indexsort]['name'];

            if (isset($config['fields'][$indexsort]['join'])) {
                if ($this->checkAlias($query, $config['fields'][$indexsort]['join']['alias']) == false) {
                    $query = $query->join($col, $config['fields'][$indexsort]['join']['alias']);
                }
                $col = $config['fields'][$indexsort]['join']['alias'].'.'.$config['fields'][$indexsort]['join']['name'];
            }
            $query->orderBy($col, $sens);
            $tab_form_q[$indexsort] = $indexsort;
        }

        //Recherche dans toutes les colonnes
        $this->querySearch($getRequest, $query, $tab_form_q, $config);

        //recherche par colonne
        $this->columnSearch($getRequest, $query, $tab_form_q, $config);

        // First and max result
        if (isset($getRequest['iDisplayStart'])) {
            $query->setFirstResult(($getRequest['iDisplayStart']))
                    ->setMaxResults(($getRequest['iDisplayLength']));
        }

        $results = $query->getQuery()->getResult();

        return $results;
    }

    public function countByFiltre($config, $getRequest = array(), $params = null)
    {
        $tab_form_q = array();
        $query = $this->createQueryBuilder($config['main_alias']);

        $this->extendQuery($query, $config, $getRequest, $params);

        //Recherche dans toutes les colonnes
        $this->querySearch($getRequest, $query, $tab_form_q, $config);

        //recherche par colonne
        $this->columnSearch($getRequest, $query, $tab_form_q, $config);

        $query = $query->getQuery();

        return count($query->getResult());
    }

    public function countByAll($config, $getRequest, $params = null)
    {
        $query = $this->createQueryBuilder($config['main_alias'])
                ->select('count('.$config['main_alias'].'.id)');

        $this->extendQuery($query, $config, $getRequest, $params);
        $query = $query->getQuery();

        return $query->getSingleScalarResult();
    }

    public function extendQuery(&$query, $config, $getRequest, $params = null)
    {
        return;
    }

    protected function checkAlias($queryBuilder, $alias)
    {
        $joinDqlParts = $queryBuilder->getDQLParts()['join'];

        /* @var $join Query\Expr\Join */
        foreach ($joinDqlParts as $joins) {
            foreach ($joins as $join) {
                if ($join->getAlias() === $alias) {
                    return true;
                }
            }
        }

        return false;
    }

    public function querySearch($getRequest, &$query, &$tab_form_q, $config)
    {
        if (isset($getRequest['sSearch']) && $getRequest['sSearch'] != '') {
            $ch = '';
            for ($i = 0; $i < count($config['fields']); ++$i) {
                if (isset($config['fields'][$i]['ignore']) == false) {
                    $col = $config['main_alias'].'.'.$config['fields'][$i]['name'];
                    if ($col != null && $config['fields'][$i]['tabSearchable']) {
                        if (isset($config['fields'][$i]['join'])) {
                            if ($this->checkAlias($query, $config['fields'][$i]['join']['alias']) == false) {
                                $query = $query->join($col, $config['fields'][$i]['join']['alias']);
                            }
                            $col = $config['fields'][$i]['join']['alias'].'.'.$config['fields'][$i]['join']['name'];
                        }

                        $tab_form_q[$i] = $i;
                        $ch .= (($ch != '' ? ' or ' : '').'(LOWER('.$col.') like \'%'.strtolower(utf8_decode($getRequest['sSearch'])).'%\''.')');
                    }
                }
            }

            if ($ch != '') {
                $query->andWhere($ch);
            }
        }
    }

    public function columnSearch($getRequest, &$query, &$tab_form_q, &$config)
    {
        for ($i = 0; $i < count($config['fields']); ++$i) {
            if (!isset($config['fields'][$i]['ignore'])) {
                if (isset($getRequest['sSearch_'.$i]) && $getRequest['sSearch_'.$i] != '') {
                    $col = $config['main_alias'].'.'.$config['fields'][$i]['name'];
                    if (isset($config['fields'][$i]['join'])) {
                        if ($this->checkAlias($query, $config['fields'][$i]['join']['alias']) == false) {
                            $query = $query->join($col, $config['fields'][$i]['join']['alias']);
                        }
                        $joinedCol = $config['fields'][$i]['join']['alias'].'.'.$config['fields'][$i]['join']['name'];
                        $query->andWhere('LOWER('.$joinedCol.') like \'%'.strtolower(utf8_decode($getRequest['sSearch_'.$i])).'%\'');
                    } else {
                        $query->andWhere('LOWER('.$col.') like \'%'.strtolower(utf8_decode($getRequest['sSearch_'.$i])).'%\'');
                    }
                    $tab_form_q[$i] = $i;
                }
            }
        }
    }

}
