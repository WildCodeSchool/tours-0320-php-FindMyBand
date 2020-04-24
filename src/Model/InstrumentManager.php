<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 24/04/20
 * PHP version 7
 */

namespace App\Model;

/**
 *
 */
class InstrumentManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'instrument';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    /**
     * @param array $instrument
     * @return int
     */
    public function insert(array $instrument): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name`) VALUES (:name)");
        $statement->bindValue('name', $instrument['name'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
