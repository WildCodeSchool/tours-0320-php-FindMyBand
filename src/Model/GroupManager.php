<?php

namespace App\Model;

class GroupManager extends AbstractManager
{

    const  TABLE = 'group';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insert($group)
    {
        $statement=$this->pdo->prepare(
            "INSERT INTO". self::TABLE .
            "(`name`,`email`,`city`,desciption`, `password`) VALUES (:name, :email, :city, :description, :password)"
        );
        $statement->bindValue('name', $group, \PDO::PARAM_STR);
        $statement->bindValue('email', $group, \PDO::PARAM_STR);
        $statement->bindValue('description', $group, \PDO::PARAM_STR);
        $statement->bindValue('password', $group, \PDO::PARAM_STR);
        $statement->bindValue('city_id', $group['city_id'], \PDO::PARAM_INT);  
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}