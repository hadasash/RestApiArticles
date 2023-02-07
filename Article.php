<?php
require("DbConnect1.php") ;
class Article extends DbConnect1
{
    public function getArticles()
    {
        return $this->select("SELECT * FROM articles");
    }

    public function getArticle($id)
    {
        return $this->select("SELECT * FROM articles WHERE id = $id");
    }


    public function editArticle($id, $title, $body)
    {
        return $this->select("UPDATE articles SET title='$title', body='$body' WHERE id=$id");
    }

    public function publishArticle($id)
    {
        return $this->select("UPDATE articles SET published=1 WHERE id=$id");
    }

    public function deleteArticle($id)
    {
        return $this->select("DELETE FROM articles WHERE id = $id");
    }

    public function createArticle($title, $body, $published)

    {
        
     return $this->select("INSERT INTO articles (title, body, published) VALUES ('$title', '$body', $published)");

    }

}