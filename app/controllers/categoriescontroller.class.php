<?php

class CategoriesController extends Controller
{

    public function beforeCategories()
    {
        self::importOne(null,'listCategories',1);
    }
    
    public function beforeView() {}
    
    public function listCategories()
    {
        $cats = $this->Category->prepare()->execute()->fetchAll();
        $this->set(0,'categories',$cats);
    }
    
    public function view($id, $title)
    {
        $posts = $this->Category->table('posts')->prepare()->where('cat_id',$id)->execute()->fetchAll();
        $this->set(1,'posts',$posts);
    }
    
    public function afterView() {}

    public function afterCategories() {}
    
}