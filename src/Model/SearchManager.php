<?php
/**
 * Created by VsCode.
 * User: Ahmad SAFAR
 * Date: 15/05/20
 * PHP version 7.1
 */

namespace App\Model;

/**
 *
 */
class SearchManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = '`search`';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    /**

     * @return int
     */
    public function insert(int $instrumentId, int $groupId, int $masteryId): int
    {
        // prepared request
        $statement=$this->pdo->prepare("INSERT INTO" .
                                        self::TABLE . "(`instrument_id`,`group_id`,`mastery_levels_id`) 
                                        VALUES (:instrument_id, :group_id, :mastery_levels_id)");
        $statement->bindValue('instrument_id', $instrumentId, \PDO::PARAM_INT);
        $statement->bindValue('group_id', $groupId, \PDO::PARAM_INT);
        $statement->bindValue('mastery_levels_id', $masteryId, \PDO::PARAM_INT);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
    public function allannonce(): array
    {
        $statement = $this->pdo->prepare("SELECT search.id as id , instrument_id, group_id, mastery_levels_id
        FROM  $this->table
        JOIN instrument as i ON i.id= instrument_id JOIN mastery_levels as m ON m.id=mastery_levels_id");
        $statement->execute();
        return $statement->fetchAll();
    }
}
