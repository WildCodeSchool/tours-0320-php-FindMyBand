<?php
/**
 * Created by VS Code
 * User: kevin
 * Date: 5-05-2020
 */

namespace App\Model;

/**
 *La classe Mastery_levelManager nous permet d'interagir avec la TABLE city.
 */
class AnnonceManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'search';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    public function insert($annonce)
    {
        $statement=$this->pdo->prepare(
            "INSERT INTO" . self::TABLE .
            "( `instrument_id`, `group_id`, `mastery_levels_id`)
            VALUES (:instrument_id, :group_id, :mastery_levels_id)"
        );
        $statement->bindValue('instrument_id', $annonce['instrument_id'], \PDO::PARAM_INT);
        $statement->bindValue('group_id', $annonce['group_id'], \PDO::PARAM_INT);
        $statement->bindValue('mastery_levels_id', $annonce['mastery_levels_id'], \PDO::PARAM_INT);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
