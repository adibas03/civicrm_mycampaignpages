<?php

require_once 'mycampaignpages.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function mycampaignpages_civicrm_config(&$config) {
  _mycampaignpages_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param array $files
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function mycampaignpages_civicrm_xmlMenu(&$files) {
  _mycampaignpages_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function mycampaignpages_civicrm_install() {
  _mycampaignpages_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function mycampaignpages_civicrm_uninstall() {
  _mycampaignpages_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function mycampaignpages_civicrm_enable() {
  _mycampaignpages_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function mycampaignpages_civicrm_disable() {
  _mycampaignpages_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function mycampaignpages_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _mycampaignpages_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function mycampaignpages_civicrm_managed(&$entities) {
  _mycampaignpages_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * @param array $caseTypes
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function mycampaignpages_civicrm_caseTypes(&$caseTypes) {
  _mycampaignpages_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function mycampaignpages_civicrm_angularModules(&$angularModules) {
_mycampaignpages_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function mycampaignpages_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _mycampaignpages_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function mycampaignpages_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 */
function mycampaignpages_civicrm_navigationMenu(&$params) {

  // get the id of Administer Menu
  $contributionMenuId = CRM_Core_DAO::getFieldValue('CRM_Core_BAO_Navigation', 'Contributions', 'id', 'name');
  //$administerMenuId = $administerMenuId?$administerMenuId:2;
  $eventMenuId = CRM_Core_DAO::getFieldValue('CRM_Core_BAO_Navigation', 'Events', 'id', 'name');
  $campaignMenuId = CRM_Core_DAO::getFieldValue('CRM_Core_BAO_Navigation', 'Campaigns', 'id', 'name');

  // get the maximum key of $params
  $maxKey = ( max( array_keys($params) ) );

  $menu_data = array (
      'attributes' => array (
          'label'      => 'My Personal Campaigns',
          'name'       => 'My Personal Campaigns',
          'url'        => 'civicrm/mycampaignpages?reset=1',
          'permission' => null,
          'operator'   => null,
          'separator'  => true,
          'parentID'   => $params[$contributionMenuId],
          'navID'      => $maxKey+1,
          'active'     => 1
      )
  );

  if($contributionMenuId)$params[$contributionMenuId]['child'][++$maxKey] = $menu_data;

  $menu_data['attributes']['parentID'] = $eventMenuId;
  if($eventMenuId)$params[$eventMenuId]['child'][++$maxKey] = $menu_data;
  
  $menu_data['attributes']['parentID'] = $campaignMenuId;
  if($campaignMenuId)$params[$campaignMenuId]['child'][++$maxKey] = $menu_data;

 // $params[$administerMenuId]['child'][++$maxKey] = $menu_data;

}
// */

