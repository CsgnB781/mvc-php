<?php
class Post
{
    public $identifier;
    public $title;
    public $frenchCreationDate;
    public $content;
}

class PostRepository
 {
 public $database = null;
 }

function getPosts(PostRepository $repository): array
{
    dbConnect($repository);
    $rows = $repository->database->query(
        "SELECT id, title, content,
               DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date
         FROM posts
         ORDER BY creation_date DESC"
    );

    $posts = [];
    while ($row = $rows->fetch()) {
        $p = new Post();
        $p->identifier = $row['id'];
        $p->title = $row['title'];
        $p->frenchCreationDate = $row['french_creation_date'];
        $p->content = $row['content'];
        $posts[] = $p;
    }
    return $posts;
}



function getPost(PostRepository $repository, string $identifier): Post
{
    dbConnect($repository);
    $statement = $repository->database->prepare(
        "SELECT id, title, content,
               DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date
         FROM posts
         WHERE id = ?"
    );
    $statement->execute([$identifier]);
    $row = $statement->fetch();

    $post = new Post();
    $post->identifier = $row['id'];
    $post->title = $row['title'];
    $post->frenchCreationDate = $row['french_creation_date'];
    $post->content = $row['content'];
    return $post;
}


// Fonction de connexion à la base de données
function dbConnect(PostRepository $repository)
 {
    if ($repository->database === null) {
        $repository->database = new PDO('mysql:host=localhost;
        dbname=blog;charset=utf8', 'root', 'root');
        }
 }