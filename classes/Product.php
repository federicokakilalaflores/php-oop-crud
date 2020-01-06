<?php

class Product{

    private $conn;
    private $table_name = 'products';

    // properties or fields
    public $id;
    public $name;
    public $price;
    public $category_id;
    public $photo;  
    public $description;
    public $created;

    public function __construct($conn = null){
        $this->conn = $conn;
    }

    public function store(){
        $query = "INSERT INTO " . $this->table_name . "(name, description, price, created, photo, category_id)
        VALUES(:name, :description, :price, :created, :photo, :category_id)";
        
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->description = htmlspecialchars(strip_tags($this->description)); 
        $this->photo = htmlspecialchars(strip_tags($this->photo)); 
        $this->created = date('Y-m-d H:i:s');

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category_id', $this->category_id); 
        $stmt->bindParam(':photo', $this->photo); 
        $stmt->bindParam(':created', $this->created); 

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    } // end store

    public function update(){
        $query  = "UPDATE " . $this->table_name . " SET " . 
                "name=:name, 
                price=:price, 
                description=:description,
                category_id=:category_id
                WHERE id=:id ";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));
 
        $stmt->bindParam(":name" , $this->name);        
        $stmt->bindParam(":price" , $this->price);        
        $stmt->bindParam(":description" , $this->description);        
        $stmt->bindParam(":category_id" , $this->category_id);        
        $stmt->bindParam(":id" , $this->id); 
        
        if($stmt->execute()){
            return true;
        }else{
            return false; 
        }
    } // end update

    public function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE id=?";
        $stmt = $this->conn->prepare($query);
        if($stmt->execute([$this->id])){
            return true;
        }else{
            return false;
        }
    }

    public function paginate($page_start_num, $record_per_page){
        $query = "SELECT * FROM " . $this->table_name . 
        ' ORDER BY name ASC LIMIT ' . $page_start_num . ', ' . $record_per_page;
        $stmt = $this->conn->prepare($query);
        $stmt->execute(); 
        return $stmt->fetchAll(); 
    } // end paginate

    public function countAll(){
        $query = "SELECT id FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();
    } //end countAll

    public function readById(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE id=? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_OBJ);

        $this->name = $row->name;
        $this->price = $row->price;
        $this->description = $row->description;
        $this->category_id = $row->category_id;
        $this->photo = $row->photo;
    } // end readById

    public function search($search_text, $page_start_num, $record_per_page){
        $query = "SELECT c.name AS category_name, p.id, p.name, p.description, p.price, p.category_id, p.created  
        FROM " 
        . $this->table_name .  " p 
        LEFT JOIN categories c ON p.category_id=c.id 
        WHERE p.name LIKE ? OR p.description LIKE ? 
        LIMIT ?, ?";
        
        $stmt = $this->conn->prepare($query);
        
        $search_text = "%$search_text%";
        $stmt->bindParam(1, $search_text);
        $stmt->bindParam(2, $search_text);
        $stmt->bindParam(3, $page_start_num, PDO::PARAM_INT);
        $stmt->bindParam(4, $record_per_page, PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt->fetchAll();
    } // end search 

    public function countAllBySearch($search_text){
        $query = "SELECT COUNT(*) as total_rows
        FROM " 
        . $this->table_name .  " p 
        LEFT JOIN categories c ON p.category_id=c.id 
        WHERE p.name LIKE ? OR p.description LIKE ?";

        $stmt = $this->conn->prepare($query); 

        $search_text = "%$search_text%";
        $stmt->bindParam(1, $search_text);
        $stmt->bindParam(2, $search_text); 
        
        $stmt->execute();
        $row = $stmt->fetch();

        return $row["total_rows"];
    } // end countBySearch

    public function uploadPhoto(){
        $err_msg = '';

        if($this->photo && $this->photo !== "noimage.png"){
            $target_directory = "../../uploads/"; 
            $target_file = $target_directory . $this->photo;
            $valid_extensions = ["jpg", "png", "jpeg"];
            $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
            // check if its a real image
            if(getimagesize($_FILES['photo']['tmp_name'])){
                  
                if(!in_array($file_extension, $valid_extensions)){
                    $err_msg .= '<div class="alert alert-danger">Only JPEG, JPG and PNG are allowed!</div>';
                  }

                if(file_exists($target_file)){
                    $err_msg .= '<div class="alert alert-danger">This Photo already exist!</div>';
                } 
                
                if($_FILES['photo']['size'] > 2000000){
                    $err_msg .= '<div class="alert alert-danger">Photo must be less than 2MB!</div>';
                }

                if(!empty($err_msg)){
                    $err_msg .= '<div class="alert alert-danger">Unable to upload try again!</div>';
                }else{
                    if(!move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)){
                        $err_msg .= '<div class="alert alert-danger">Something went wrong while uploading your Photo!</div>';
                    }
                }

            }else{
                $err_msg .= '<div class="alert alert-danger">Submitted file is not an image!</div>';
            }

            return $err_msg;

        }
    }

}