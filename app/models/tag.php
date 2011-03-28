<?php

class Tag extends Model
{
    public $connections = array('tags.id' => 'tag_connections.tag_id');
}