<?php
/*
  be.chiro.civi.contributionbatchhelper - contribution batch tools.
  Copyright (C) 2016, 2017  Chirojeugd-Vlaanderen vzw

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
 * BatchedContribution.Get API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_batched_contribution_Get(array $params) {
  $sql = "SELECT eb.batch_id, eft.financial_trxn_id, cont.*
      FROM civicrm_financial_trxn ft
      JOIN civicrm_entity_financial_trxn eft ON (eft.financial_trxn_id = ft.id AND eft.entity_table = 'civicrm_contribution')
      JOIN civicrm_contribution cont ON cont.id = eft.entity_id
      LEFT OUTER JOIN civicrm_entity_batch eb ON (eb.entity_id = ft.id AND eb.entity_table = 'civicrm_financial_trxn')
  ";

  $extraFields = array(
    'batch_id' => array(
      'name' => 'batch_id',
      'type' => 1,
      'title' => 'Batch ID',
    ),
    'financial_trxn_id' => array(
      'name' => 'financial_trxn_id',
      'type' => 1,
      'title' => 'Financial transaction ID',
    ),
  );

  $result = CRM_Queryapitools_Tools::BasicGet(
    $sql,
    $params,
    'Contribution',
    $extraFields);

  return $result;
}

