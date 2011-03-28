<?php

class Post extends Model
{
    public $connections = array('posts.cat_id' => 'categories.id','posts.id' => 'tag_connections.post_id', 'posts.user_id' => 'users.id');
}