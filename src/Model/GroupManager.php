<?php

namespace App\Model;

class GroupManager extends AbstractManager{

    const  TABLE = 'group';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insert($musician){
        $statement=$this->pdo->prepare("INSERT INTO". self::TABLE . "(`name`,`email`,`city`,desciption`, `password`) VALUES (:name, :email, :city, :description, :password)");
        $statement->bindValue('name', $musician, \PDO::PARAM_STR);
        $statement->bindValue('email', $musician, \PDO::PARAM_STR);
        $statement->bindValue('city', $musician, \PDO::PARAM_STR);
        $statement->bindValue('description', $musician, \PDO::PARAM_STR);
        $statement->bindValue('password', $musician, \PDO::PARAM_STR);
        $statement->execute();
    }
    public function delete($id){
        $statement = $this->pdo->prepare("DELETE FROM" . self::TABLE . "WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    /*public function update($musician){
        $statement = $this->pdo->prepare("UPDATE" . self::TABLE . "SET `ps")
    }*/

}