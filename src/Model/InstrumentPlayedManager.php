<?php
/**
 * Created by VScode.
 * User: Ahmad
 * Date: 05/05/2020
 * Time: 09:34
 * PHP version 7
 */

namespace App\Model;

use App\Model\Mastery_levelManager;
use App\Model\InstrumentManager;
use App\Model\MusicianManager;
use App\Model\MusicianForm;

/**
 *
 */
class InstrumentPlayedManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'instrument_played';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    /**
     * @param int $instrument_played
     * @return int
     */
    public function insert(int $masteryId, int $instrumentId, int $musicianId) : int
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " .
             self::TABLE . " (`mastery_levels_id`,`instrument_id`,`musician_id`)
          VALUES (:mastery_levels_id,:instrument_id,:musician_id)"
        );
        $statement->bindValue('mastery_levels_id', $masteryId, \PDO::PARAM_INT);
        $statement->bindValue('instrument_id', $instrumentId, \PDO::PARAM_INT);
        $statement->bindValue('musician_id', $musicianId, \PDO::PARAM_INT);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
