<?php

require_once('../db/mongodb.php');

function getlinkScama()
{
    global $database;
    $collection = $database->selectCollection('link_scama');
    $cursor = $collection->find();
    $result = [];
    foreach ($cursor as $document) {
        $result[] = $document;
    }
    return $result;
}

function insertLinkScama($data)
{
    global $database;
    $collection = $database->selectCollection('link_scama');
    $collection->insertOne($data);
}

function deleteLinkScama($id)
{
    global $database;
    $collection = $database->selectCollection('link_scama');
    $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
}

function updateLinkScama($id, $data)
{
    global $database;
    $collection = $database->selectCollection('link_scama');
    $collection->updateOne(['_id' => new MongoDB\BSON\ObjectId($id)], ['$set' => $data]);
}

function getVisitor()
{
    global $database;
    $collection = $database->selectCollection('visitor');
    $cursor = $collection->find();
    $result = [];
    foreach ($cursor as $document) {
        $result[] = $document;
    }
    return $result;
}
function insertVisitor($data)
{
    global $database;
    $collection = $database->selectCollection('visitor');
    $collection->insertOne($data);
}

function deleteVisitor($id)
{
    global $database;
    $collection = $database->selectCollection('visitor');
    $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
}

function insertVisitorScama($data)
{
    global $database;
    $collection = $database->selectCollection('visitor_scama');
    $collection->insertOne($data);
}

function deleteVisitorScama()
{
    global $database;
    $collection = $database->selectCollection('visitor_scama');
    $collection->deleteMany([]);
}

function geUser()
{
    global $database;
    $collection = $database->selectCollection('user');
    $cursor = $collection->find();
    $result = [];
    foreach ($cursor as $document) {
        $result[] = $document;
    }
    return $result;
}

function insertUser($data)
{
    global $database;
    $collection = $database->selectCollection('user');
    $collection->insertOne($data);
}

function deleteUser($id)
{
    global $database;
    $collection = $database->selectCollection('user');
    $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
}

function updateUser($id, $data)
{
    global $database;
    $collection = $database->selectCollection('user');
    $collection->updateOne(['_id' => new MongoDB\BSON\ObjectId($id)], ['$set' => $data]);
}

function insertUserSession($data)
{
    global $database;
    $collection = $database->selectCollection('user_session');
    $collection->insertOne($data);
}

function deleteUserSession($id)
{
    global $database;
    $collection = $database->selectCollection('user_session');
    $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
}

function getDomainShort()
{
    global $database;
    $collection = $database->selectCollection('domain_short');
    $cursor = $collection->find();
    $result = [];
    foreach ($cursor as $document) {
        $result[] = $document;
    }
    return $result;
}

function insertDomainShort($data)
{
    global $database;
    $collection = $database->selectCollection('domain_short');
    $collection->insertOne($data);
}

function deleteDomainShort($id){
    global $database;
    $collection = $database->selectCollection('domain_short');
    $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
}

function getCountryLock()
{
    global $database;
    $collection = $database->selectCollection('country_lock');
    $cursor = $collection->find();
    $result = [];
    foreach ($cursor as $document) {
        $result[] = $document;
    }
    return $result;
}