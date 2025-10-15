 <?php
 function getPosts() {
 // We connect to the database.
    try {
        $database = new PDO('mysql:host=localhost;dbname=blog;charset=utf8',
        'blog', 'password');
        } catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
        }
    // We retrieve the 5 last blog posts.
    $statement = $database->query(
 "SELECT id, titre, contenu, DATE_FORMAT(date_creation,