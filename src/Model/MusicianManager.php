<?php
/**
 * Created by VScode.
 * User: Ahmad
 * Date: 05/05/2020
 * Time: 09:34
 * PHP version 7
 */

namespace App\Model;

use App\Model\MusicianForm;

/**
 *
 */
class MusicianManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'musician';

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
    public function insert(MusicianForm $musician): int
    {
        // prepared request
        $statement = $this->pdo->prepare(
            "INSERT INTO " .
            self::TABLE . " (`pseudo`,`password`,`email`,`description`,`city_id`)
        VALUES (:pseudo,:password,:email,:description,:city_id)"
        );
        $statement->bindValue('pseudo', $musician->getPseudo(), \PDO::PARAM_STR);
        $statement->bindValue('password', $musician->getPassword(), \PDO::PARAM_STR);
        $statement->bindValue('email', $musician->getEmail(), \PDO::PARAM_STR);
        $statement->bindValue('description', $musician->getDescription(), \PDO::PARAM_STR);
        $statement->bindValue('city_id', $musician->getCityId(), \PDO::PARAM_INT);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
    public function selectOneByEmail(string $email)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE email=:email");
        $statement->bindValue('email', $email, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }
}
