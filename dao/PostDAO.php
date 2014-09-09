<?php
include_once('../model/Post.php');

class PostDAO {

    private $conn;

    public function __construct() {
        $registry = Registry::getInstance();
        
        // Recebe a instancia Connection que foi registrada em index.php #14 e a instancia na propriedade $conn
        $this->conn = $registry->get('Connection');
    }

    public function insert(Post $post) {
        $this->conn->beginTransaction();

        try {
            $arrFields = array();
            
            
            if($post->getTitle()){ $arrFields['title'] = $post->getTitle(); }
            if($post->getContent()){ $arrFields['content'] = $post->getContent(); }
            
            $sql = 'INSERT INTO posts(';
            $i=0;
            foreach($arrFields as $k => $v){
                if($i==0){
                    $sql .= $k;
                }else{
                    $sql .= ','.$k;
                }
                $i++;
            }
            $sql .= ') VALUES (';
            $i=0;
            foreach($arrFields as $k => $v){
                if($i==0){
                    $sql .= ':'.$k;
                }else{
                    $sql .= ',:'.$k;
                }
                $i++;
            }
            $sql .= ')';
            
            //$stmt = $this->conn->prepare('INSERT INTO posts (title, content) VALUES (:title, :content)');
            $stmt = $this->conn->prepare($sql);

            foreach($arrFields as $k => $v){
                $stmt->bindValue(':'.$k,$v);
            }
            $stmt->execute();

            $this->conn->commit();
        }
        catch(Exception $e) {
            $this->conn->rollback();
        }
    }
    
    public function update(Post $post){
        $this->conn->beginTransaction();
        
        try {
            
            $stmt = $this->conn->prepare('UPDATE posts SET title = :title WHERE id = :id');
            $stmt->bindValue(':title', $post->getTitle());
            $stmt->bindValue(':id', $post->getId());
            $stmt->execute();
            $this->conn->commit();
            
        } catch (Exception $e) {
            $this->conn->rollback();
        }
    }
    
    public function delete(Post $post){
        $this->conn->beginTransaction();
        
        try{
            $stmt = $this->conn->prepare('DELETE FROM posts WHERE id = :id');
            $stmt->bindValue(':id',$post->getId());
            $stmt->execute();
            $this->conn->commit();
            
        } catch (Exception $e) {
            $this->conn->rollback();
        }
    }

    
    
    // Metodos de busca
     
    public function getAll() {
        $statement = $this->conn->query('SELECT * FROM posts');
        return $this->processResults($statement);
    }
    
    public function getById(Post $post){
        $query = $this->conn->prepare('SELECT * FROM posts WHERE id = :id LIMIT 1');
        $query->execute(array(':id' => $post->getId()));
        return $this->processResults($query);
    }

    private function processResults($statement) {
        $results = array();

        if($statement) {
            while($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $post = new Post();

                $post->setId($row->id);
                $post->setTitle($row->title);
                $post->setContent($row->content);

                $results[] = $post;
            }
        }

        return $results;
    }

}

