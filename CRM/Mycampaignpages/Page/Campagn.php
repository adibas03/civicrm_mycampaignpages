<?php
require_once 'CRM/Mycampaignpages/BAO/PcpHelper.php';
require_once 'CRM/Core/Page.php';

class CRM_Mycampaignpages_Page_Campagn extends CRM_Core_Page {

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(ts('My personal Campaigns'));

    $contact = civicrm_api3('Contact', 'get', array(
        'sequential' => 1,
        'email' => $GLOBALS['user']->mail,
        'return' => 'id'
    ));

    //Confirm that contact info was loaded
    if(is_array($contact) && isset($contact['is_error']) && !$contact['is_error']){

      if( is_array($contact['values']) && count($contact['values']) > 0){
        $contact = $contact['values'][0];

        try {
          $pcp = civicrm_api3('Pcp', 'get', array(
              'sequential' => 1,
              'contact_id' => $contact['contact_id'],
          ));
        }
        catch(Exception $e){
          $pcp = ['values'=>[]];
        }

        if(is_array($pcp) && isset($pcp['is_error']) &&!$pcp['is_error']){
          $pcps = $pcp['values'];

          for($p=0;$p<count($pcps);$p++) {
            $prms = array('id' => $pcps[$p]['id']);
            CRM_Core_DAO::commonRetrieve('CRM_PCP_DAO_PCP', $prms, $pcpInfo);
            $pcps[$p]['goal_amount'] = number_format($pcps[$p]['goal_amount'], 2);
            $pcps[$p]['raised'] = number_format(floatval(CRM_PCP_BAO_PCP::thermoMeter($pcpInfo['id'])), 2);
            $pcps[$p]['contributors'] = CRM_mycampaignpages_BAO_PcpHelper::countContributors($pcps[$p]['id']);

          if ($pcps[$p]['page_type'] == 'contribute') {
            $parent_type = 'contribution_page';
            $pcps[$p]['baseUrl'] = 'civicrm/contribute/transact';
            }
          elseif
            ($pcps[$p]['page_type'] == 'event'){
              $parent_type = 'event';
              $pcps[$p]['baseUrl'] = 'civicrm/event/register';
            }

            try{
            $pcps[$p]['parent'] = civicrm_api3($parent_type, 'get', array(
                'sequential' => 1,
                'id' => $pcps[$p]['page_id'],
            ))['values'][0];
            }
            catch(Exception $e){
              $pcps[$p]['parent']['title'] = 'Not Found';
              continue;
            }

          }
          
        }
 
      }

    }

    $pcpStatus = CRM_Core_OptionGroup::values("pcp_status");

    $this->assign('pcp_st',json_encode($pcpStatus));
    $this->assign('pcp_status',$pcpStatus);

    if(isset($pcps) && count($pcps) > 0) {
      $this->assign('pcpCount', count($pcps));
      $this->assign('personalCampaigns', $pcps);
      }
    else
      $this->assign('pcpCount', 0);

    parent::run();
  }
}
