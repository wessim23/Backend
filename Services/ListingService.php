<?php

namespace px\BackendBundle\Services;

use px\BackendBundle\Utils\Functions;

/**
 * Listing Service.
 *
 * @author maroua.mechmech<maroua.mechmech@proxym-it.com>
 */
class ListingService {

    private $em;
    private $templating;

    public function __construct($em, $templating) {
        $this->em = $em;
        $this->templating = $templating;
    }

    public function getLines($config, $getRequest = array(), $fields, $delete_form_template) {
        $list = $this->em->getRepository($config['entity_name'])->findAllByFiltre($config, $getRequest);
        $countEntities = $this->em->getRepository($config['entity_name'])->countByFiltre($config, $getRequest);
        $countAllEntities = $this->em->getRepository($config['entity_name'])->countByAll($config, $getRequest);

        $result = array();
        $result['sEcho'] = intval(array_key_exists('sEcho', $getRequest) ? $getRequest['sEcho'] : 1);
        $result['iTotalRecords'] = $countAllEntities;
        $result['iTotalDisplayRecords'] = $countEntities;
        $result['aaData'] = array();
        $nbFields = count($config['fields']);
        foreach ($list as $key => $entity) {
            $infos = array();
            $infos[$nbFields - 1] = $this->templating->render('pxBackendBundle:Default:_TableActions.html.twig', array('entity' => $entity, 'fields' => $fields, 'delete_form_template' => $delete_form_template));
            unset($config['fields'][$nbFields - 1]);
            foreach ($config['fields'] as $keyField => $field) {
                $method = 'get' . $this->humanize($field['name']);
                $infos[$keyField] = Functions::getDefaultString($entity->$method());
            }
            $result['aaData'][$key] = $infos;
        }

        return $result;
    }

    private function humanize($text) {
        $str = preg_replace('/[_\s]+/', '', ucwords(trim(strtolower(preg_replace('/[_\s]+/', ' ', $text)))));
        $str = strtoupper(substr($str, 0, 1)) . substr($str, 1);
        return $str;
    }

}
