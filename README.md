# contributionbatchhelper

This CiviCRM extension adds some contribution related functionality that I
find useful for our CiviCRM instance.

* If you search contributions with the contribution search form, and you
  select one or more results, you can add those results to a new or an
  existing financial batch. If you want to use this, you might want to
  patch CiviCRM, so that you can
  [search for contributions that are not yet contained in any batch](https://issues.civicrm.org/jira/browse/CRM-19325).
* It provides an api action @BatchedContribution.get@, that does the same
  as @Contribution.get@, but also returns the ID of the batch the contribution
  is contained in (if any). It allows filtering on batch ID as well.

## dependencies

If you want to use this extension, you need to install
[queryapitools](https://www.civicrm.org/extensions/queryapitools) as well.

## API examples

The example below returns the requested fields for all contributions in
financial batch 22.

    $result = civicrm_api3('BatchedContribution', 'get', array(
      'return' => array("contribution_id", "contact_id", "total_amount", "batch_id"),
      'batch_id' => 22,
    ));
