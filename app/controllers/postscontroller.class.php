<?php

class PostsController extends Controller
{
    
    public function beforePosts()
    {
        self::importOne('Categories','listCategories',1);
    } 
        
    public function beforeIndex() {}

    public function index()
    {
        $this->set(0,'title','Kezdőlap');
        $posts = $this->Post->prepare()->execute()->fetchAll();
        $this->set(1,'posts',$posts);
    }
    
    public function view($id, $title = '')
    {
        $post = $this->Post->prepare()->where('ID',$id)->execute()->next();
        $this->set(0,'post',$post);
    }

    public function afterIndex() {}

    public function afterPosts() {}
    
}

?>