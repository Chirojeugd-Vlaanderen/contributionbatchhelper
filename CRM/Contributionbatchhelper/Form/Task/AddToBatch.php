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

require_once 'CRM/Core/Form.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Contributionbatchhelper_Form_Task_AddToBatch extends CRM_Contribute_Form_Task {
  public function buildQuickForm() {

    $batches = array('' => '- new batch -') + CRM_Contribute_PseudoConstant::batch();
    $this->add(
      'select',
      'contribution_batch_id',
      ts("Add %1 contribution(s) to", array(count($this->_contributionIds))),
      $batches,
      FALSE);

    // add form elements
    $this->add(
      'text', // field type
      'batch_name', // field name
      'New batch name', // field label
      NULL,
      TRUE
    );
    $this->addButtons(array(
      array(
        'type' => 'done',
        'name' => ts('Add to batch'),
        'isDefault' => TRUE,
      ),
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function postProcess() {
    $session = CRM_Core_Session::singleton();
    $values = $this->exportValues();
    if (empty($values['contribution_batch_id'])) {
      $batch_id = CRM_Contributionbatchhelper_Helper::createBatch(
        $values['batch_name'],
        $session->get('userID'));
    }
    else {
      $batch_id = $values['contribution_batch_id'];
    }
    // TODO: add contributions to batch.
    $session->replaceUserContext(CRM_Utils_System::url('civicrm/batchtransaction',
        "reset=1&bid={$batch_id}"));
  }

  public function getColorOptions() {
    $options = array(
      '' => ts('- select -'),
      '#f00' => ts('Red'),
      '#0f0' => ts('Green'),
      '#00f' => ts('Blue'),
      '#f0f' => ts('Purple'),
    );
    foreach (array('1','2','3','4','5','6','7','8','9','a','b','c','d','e') as $f) {
      $options["#{$f}{$f}{$f}"] = ts('Grey (%1)', array(1 => $f));
    }
    return $options;
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }

  public function setDefaultValues() {
    $defaults = parent::setDefaultValues();
    $defaults['batch_name'] = CRM_Batch_BAO_Batch::generateBatchName();
    return $defaults;
  }
}
