<?php
/*
  be.chiro.civi.contributionbatchhelper - easy contribution batch creation.
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
 * @author johanv
 */
class CRM_Contributionbatchhelper_Helper {
  /**
   * Creates a batch and records an activity.
   *
   * @param string $title
   * @param int $userID
   * @returns int ID of created batch
   */
  public static function createBatch($title, $userID) {
    // This is more or less copied from CRM_financial_Form_FinancialBatch::postProcess()
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
}
