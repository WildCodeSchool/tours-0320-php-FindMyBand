<?php

namespace App\Model;

use App\Model\GroupForm;

class GroupManager extends AbstractManager
{

    const  TABLE = '`group`';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectOneByIdWithCity(int $id)
    {
        //prepare request
        $statement->$this->pdo->prepare("SELECT "city_id" AS )
    }
    public function insert(GroupForm $group): int
    {
        $statement=$this->pdo->prepare(
            "INSERT INTO " . self::TABLE .
            " (`name`, `email`, `city_id`, `description`, `password`)
            VALUES (:name, :email, :city_id, :description, :password)"
        );
        $statement->bindValue('name', $group->getName(), \PDO::PARAM_STR);
        $statement->bindValue('email', $group->getEmail(), \PDO::PARAM_STR);
        $statement->bindValue('description', $group->getDescription(), \PDO::PARAM_STR);
        $statement->bindValue('password', $group->getPassword(), \PDO::PARAM_STR);
        $statement->bindValue('city_id', $group->getCityId(), \PDO::PARAM_INT);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
