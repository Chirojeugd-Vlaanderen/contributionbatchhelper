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

require_once 'contributionbatchhelper.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function contributionbatchhelper_civicrm_config(&$config) {
  _contributionbatchhelper_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param array $files
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function contributionbatchhelper_civicrm_xmlMenu(&$files) {
  _contributionbatchhelper_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function contributionbatchhelper_civicrm_install() {
  _contributionbatchhelper_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function contributionbatchhelper_civicrm_uninstall() {
  _contributionbatchhelper_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function contributionbatchhelper_civicrm_enable() {
  _contributionbatchhelper_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function contributionbatchhelper_civicrm_disable() {
  _contributionbatchhelper_civix_civicrm_disable();
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
function contributionbatchhelper_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _contributionbatchhelper_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function contributionbatchhelper_civicrm_managed(&$entities) {
  _contributionbatchhelper_civix_civicrm_managed($entities);
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
function contributionbatchhelper_civicrm_caseTypes(&$caseTypes) {
  _contributionbatchhelper_civix_civicrm_caseTypes($caseTypes);
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
function contributionbatchhelper_civicrm_angularModules(&$angularModules) {
_contributionbatchhelper_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function contributionbatchhelper_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _contributionbatchhelper_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function contributionbatchhelper_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function contributionbatchhelper_civicrm_navigationMenu(&$menu) {
  _contributionbatchhelper_civix_insert_navigation_menu($menu, NULL, array(
    'label' => ts('The Page', array('domain' => 'be.chiro.civi.contributionbatchhelper')),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _contributionbatchhelper_civix_navigationMenu($menu);
} // */

/**
 * Implements hook_civicrm_searchTasks.
 * 
 * @param string $objectType
 * @param array $tasks
 */
function contributionbatchhelper_civicrm_searchTasks($objectType, &$tasks) {
  $perms = array(
    'create manual batch',
    'edit own manual batches',
  );
  if ($objectType == 'contribution' && CRM_Core_Permission::check($perms)) {
    // Add task for Membership facturatie and lidkaarten
    $tasks['batch'] = array(
      'title' => ts('Add to export batch'),
      'class' => 'CRM_Contributionbatchhelper_Form_Task_AddToBatch',
      'result' => FALSE,
    );
  }
}

/**
 * Implements hook_civicrm_alterAPIPermissions.
 *
 * @param string $entity
 * @param string $action
 * @param array $params
 * @param array $permissions
 */
function contributionbatchhelper_civicrm_alterAPIPermissions($entity, $action, &$params, &$permissions) {
  $permissions['batched_contribution']['get'] = array(
    'access CiviCRM',
    'access CiviContribute',
    'view all manual batches',
    );
}