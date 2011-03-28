<?php

class TagConnection extends Model
{
    public $connectorTable = true;
    public $connectedTables = array('Posts' => 'Tags');
}