<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

include_once 'Model/Base.php';
include_once 'Model/Person.php';
include_once 'Model/Mandate.php';
include_once 'Model/Doc.php';

const MY_ACCESS_RIGHTS = [
    Person::class => [
        'c' => false,
        'r' => true,
        'u' => false,
        'd' => false
    ],
    Mandate::class => [
        'c' => false,
        'r' => false,
        'u' => false,
        'd' => false
    ],
    Doc::class => [
        'c' => true,
        'r' => true,
        'u' => true,
        'd' => true
    ]
];

$person = new Person();
$mandate = new Mandate();
$doc = new Doc();

echo 'person: c => ' . (hasAccessRights($person, 'c') ? 'ja' : 'nein') . '<br />';
echo 'person: r => ' . (hasAccessRights($person, 'r') ? 'ja' : 'nein') . '<br />';
echo 'person: d => ' . (hasAccessRights($person, 'd') ? 'ja' : 'nein') . '<br />';
echo 'person: u => ' . (hasAccessRights($person, 'u') ? 'ja' : 'nein') . '<br />';
echo '<br />';

echo 'mandate: c => ' . (hasAccessRights($mandate, 'c') ? 'ja' : 'nein') . '<br />';
echo 'mandate: r => ' . (hasAccessRights($mandate, 'r') ? 'ja' : 'nein') . '<br />';
echo 'mandate: d => ' . (hasAccessRights($mandate, 'd') ? 'ja' : 'nein') . '<br />';
echo 'mandate: u => ' . (hasAccessRights($mandate, 'u') ? 'ja' : 'nein') . '<br />';
echo '<br />';

echo 'doc: c => ' . (hasAccessRights($doc, 'c') ? 'ja' : 'nein') . '<br />';
echo 'doc: r => ' . (hasAccessRights($doc, 'r') ? 'ja' : 'nein') . '<br />';
echo 'doc: d => ' . (hasAccessRights($doc, 'd') ? 'ja' : 'nein') . '<br />';
echo 'doc: u => ' . (hasAccessRights($doc, 'u') ? 'ja' : 'nein') . '<br />';
echo '<br />';

die('Done');

/**
 * @param Base $object
 * @param string $accessRight
 * @return bool
 */
function hasAccessRights(Base $object, string $accessRight) : bool
{
    return MY_ACCESS_RIGHTS[get_class($object)][$accessRight];
}