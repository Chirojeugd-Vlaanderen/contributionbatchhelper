<?php
/*
  be.chiro.civi.contributionbatchhelper - contribution batch tools.
  Copyright (C) 2016  Chirojeugd-Vlaanderen vzw

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU Affero General Public License as
  published by the Free Software Foundation, either version 3 of the
  License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU Affero General Public License for more details.

  You should have received a copy of the GNU Affero General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Static helper functions.
 *
 * This kind of functions should really be part of CiviCRM core. But they
 * are not. Yet?
 */
class CRM_Contributionbatchhelper_Helper {
  /**
   * Creates a batch and records an activity.
   *
   * This is more or less copied from
   * CRM_financial_Form_FinancialBatch::postProcess(). IMO this kind of
   * functionality should be part of Core.
   *
   * @param string $title
   * @param int $userID
   * @returns int ID of created batch
   */
  public static function createBatch($title, $userID) {
    $batchMode = CRM_Core_PseudoConstant::get('CRM_Batch_DAO_Batch', 'mode_id', array('labelColumn' => 'name'));
    $batchStatus = CRM_Core_PseudoConstant::get('CRM_Batch_DAO_Batch', 'status_id');
    $activityTypes = CRM_Core_PseudoConstant::activityType(TRUE, FALSE, FALSE, 'name');

    $params = array(
      'title' => $title,
      'modified_date' => date('YmdHis'),
      'modified_id' => $userID,
      'mode_id' => CRM_Utils_Array::key('Manual Batch', $batchMode),
      'status_id' => CRM_Utils_Array::key('Open', $batchStatus),
      'created_date' => date('YmdHis'),
      'created_id' => $userID,
    );
    $batch = CRM_Batch_BAO_Batch::create($params);

    // create activity.
    $activityParams = array(
      'activity_type_id' => array_search('Create Batch', $activityTypes),
      'subject' => $batch->title . "- Batch",
      'status_id' => 2,
      'priority_id' => 2,
      'activity_date_time' => date('YmdHis'),
      'source_contact_id' => $userID,
      'source_contact_qid' => $userID,
      'details' => "{$title} batch has been created by this contact.",
    );

    CRM_Activity_BAO_Activity::create($activityParams);

    return $batch->id;
  }

  /**
   * Add contributions with givien IDs to batch with given ID.
   *
   * This is based on the bulkAssignRemove function in
   * CRM/Financial/Page/AJAX.php. In my opinion, this kind of functionality
   * should be part of Core.
   *
   * @param int $batchID
   * @param array $contributionIDs
   * @returns array Information about which contributions are added
   */
  public static function addContributionsToBatch($batchID, array $contributionIDs) {
    $result = array(
      'ok' => array(),
      'error' => array(),
    );

    $api_result = civicrm_api3('BatchedContribution', 'get', array(
      // find contributions with given IDs
      'id' => array('IN' => $contributionIDs),
      // that are not contained in any batch
      'batch_id' => array('IS NULL' => 1),
      'return' => array("id", "financial_trxn_id", "batch_id"),
      'options' => array('limit' => count($contributionIDs)),
      'sequential' => 0,
    ));

    // The contribution ID's that are not contained in the api result, are
    // those that are already contained in some other batch.
    // Because we called the API with sequential => 0, we can use the trick
    // below.
    $result['error'] = array_diff($contributionIDs, array_keys($api_result['values']));

    $batchPID = CRM_Core_DAO::getFieldValue('CRM_Batch_DAO_Batch', $batchID, 'payment_instrument_id');
    foreach ($api_result['values'] as $contribution) {
      $recordPID = CRM_Core_DAO::getFieldValue('CRM_Financial_DAO_FinancialTrxn', $contribution['financial_trxn_id'], 'payment_instrument_id');
      if ($recordPID == $batchPID || !isset($batchPID)) {
        $params = array(
          'entity_id' => $contribution['financial_trxn_id'],
          'entity_table' => 'civicrm_financial_trxn',
          'batch_id' => $batchID,
        );
        // I hope the below does al the necessary permission checks.
        $updated = CRM_Batch_BAO_Batch::addBatchEntity($params);
        if ($updated) {
          $result['ok'][] = $contribution['id'];
        }
        else {
          $result['error'][] = $contribution['id'];
        }
      }
    }
    return $result;
  }
}
