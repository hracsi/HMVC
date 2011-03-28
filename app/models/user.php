<?php

class User extends Model
{
    public $connections = array('users.user_group_id' => 'user_groups.id');
}