<?php
/**
 * Created by PhpStorm.
 * User: Adibas03@gmail.com
 * Date: 9/27/2016
 * Time: 7:26 PM
 */
class CRM_mycampaignpages_DAO_PcpHelper extends CRM_Core_DAO {


        /**
         * Count the number of Contributors to a Pcp
         *
         * @param integer $pcpId
         *   The pcp ID.
         *
         * @return integer
         *   Total contributors
         */
        public static function countContributors($pcpId){
            $query = "
            SELECT count(*) as total
            FROM civicrm_pcp pcp
            LEFT JOIN civicrm_contribution_soft cs ON ( pcp.id = cs.pcp_id )
            LEFT JOIN civicrm_contribution cc ON ( cs.contribution_id = cc.id)
            WHERE pcp.id = %1 AND cc.contribution_status_id =1 AND cc.is_test = 0";

            $params = array(1 => array($pcpId, 'Integer'));
            return CRM_Core_DAO::singleValueQuery($query, $params);
        }
    }