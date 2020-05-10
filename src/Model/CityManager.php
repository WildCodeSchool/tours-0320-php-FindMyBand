<?php
/**
 * Created by VS Code
 * User: kevin
 * Date: 28-04-2020
 */

namespace App\Model;

/**
 *La classe CityManager nous permet d'interagir avec la TABLE city.
 */
class CityManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'city';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    
}