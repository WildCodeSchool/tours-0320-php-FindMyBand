<?php
/**
 * Created by VS Code
 * User: Ahmad
 * Date: 5-05-2020
 */

namespace App\Model;

/**
 *La classe Mastery_levelManager nous permet d'interagir avec la TABLE city.
 */
class Mastery_levelManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'mastery_levels';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}