<?php

namespace App\Model;

use App\Model\GroupAnnonce;

class GroupManager extends AbstractManager
{

    const  TABLE = 'search';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    public function insert(GroupForm $annonce): int
    {
        $statement=$this->pdo->prepare(
            "INSERT INTO " . self::TABLE .
            " (`instrument_id, `group_id`, `mastery_levels_id`)
            VALUES (:instrument_id, :group_id, :mastery_levels_id)"
        );
        $statement->bindValue('instrument_id', $annonce->getName(), \PDO::PARAM_INT);
        $statement->bindValue('group_id', $annonce->getEmail(), \PDO::PARAM_INT);
        $statement->bindValue('mastery_levels_id', $annonce->getDescription(), \PDO::PARAM_INT);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
