<?php

include_once('../core/db.class.php');
include_once('../core/Registry.php');
include_once('../dao/PostDAO.php');
include_once('../model/Post.php');

class PostController {
    
    private $conn;
    public $registry;
            
    function __construct() {
        // Instanciar uma conexão com PDO
        $this->conn = new db();
        $this->conn = $this->conn->connect();
        
        $this->registry = Registry::getInstance();
        $this->registry->set('Connection', $this->conn);

    }
    
    public function index(){
        $postDAO = new PostDAO();
        
        if($_POST){
            // Action de delete dos posts marcados
            foreach($_POST['post_id'] as $post){
                $post_delete = new Post();
                $post_delete->setId($post);
                $postDAO->delete($post_delete);
                $post_delete = null;
            }
        }
        
        $results = $postDAO->getAll();
        $this->registry->set('results',$results);
    }
    
    public function add(){
        
        $postDAO = new PostDAO();

        if($_POST){
            $post = new Post();
            $post->setTitle($_POST['title']);
            $post->setContent($_POST['content']);
            $postDAO->insert($post);
        }
    }
    
    public function edit(){
        $postDAO = new PostDAO();

        if($_POST){
            $post_update = new Post();
            $post_update->setId($_GET['id']);
            $post_update->setTitle($_POST['title']);
            $post_update->setContent($_POST['content']);
            $postDAO->update($post_update);
        }

        $post = new Post();
        $post->setId($_GET['id']);
        $results = $postDAO->getById($post);
        $this->registry->set('results',$results);
    }
}
