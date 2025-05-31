<?php
chdir('../');
require_once 'autoload.php';
require_once 'config/parameters.php';
require_once 'config/db.php';
require_once './qdrant/QdrantLogic.php';
require_once './qdrant/QdrantClient.php';

$qdrant = new QdrantLogic();

$qdrant->restart();
