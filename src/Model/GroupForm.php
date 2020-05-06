<?php
/**
 * User: Romain
 * Date: 06/05/20
 */

namespace App\Model;

use App\Model\CityManager;

/**
 * This class can be used to deal with the group creation form.
 * It is used validate all the fields then recover them
 */
class GroupForm
{
    // The group form fields
    private $name;
    private $email;
    private $password;
    private $cityId;
    private $description;
    // An array containing the error messages
    private $errorMessages;


    public function __construct()
    {
        $this->name = "";
        $this->email = "";
        $this->password = "";
        $this->cityId = null;
        $this->description = "";
        $this->errorMessages = [];
    }

    /*
     * Check the presence of all the fields and validate them
     * @return false : if the form is incomplete. I.e. we don't have all the fields we need
     *         true : if the form is complete and the request has been handled. The form may have errors
     */
    public function handleRequest()
    {
        if (\filter_has_var(INPUT_POST, "name") &&
            \filter_has_var(INPUT_POST, "description") &&
            \filter_has_var(INPUT_POST, "city")) {
            $this->complete = true;
            $this->validateName();
            $this->validateDescription();
            $this->validateCity();
            return true;
        }
        return false;
    }

    /*
     * Validation of the name field which is supposed to be in $_POST["name"]
     * Validation is : 
     * size is between 1 and 255 characters
     */
    private function validateName()
    {
        $size = \strlen($_POST["name"]);
        if ($size < 1 || $size > 255) {
            $this->errorMessages["name"] = "Le nom du groupe doit faire entre 1 et 255 caractères";
        } else {
            $this->name = $_POST["name"];
        }
    }

    /*
     * Validation of the description field which is supposed to be in $_POST["description"]
     * Validation is : 
     * size is between 1 and 800 characters
     */
    private function validateDescription()
    {
        $size = \strlen($_POST["description"]);
        if ($size < 1 || $size > 800) {
            $this->errorMessages["description"] = "La description de votre groupe est obligatoire mais ne peut contenir plus de 800 caractères";
        } else {
            $this->description = $_POST["description"];
        }
    }

    /*
     * Validation of the city field which is supposed to be in $_POST["city"]
     * Validation is : 
     * it's a positive integer
     * it exists in the Database
     */
    private function validateCity()
    {
        // Validating that city is a positive number
        if (\filter_input(INPUT_POST, "city", \FILTER_VALIDATE_INT, ["options" => ["min_range" => 0]]) !== false) {
            $cityManager = new CityManager();
            $city = $cityManager->selectOneById($_POST["city"]);
            // Validating if the city exists in the database
            if (!empty($city)) {
                $this->cityId = $_POST["city"];
                return;
            }
        }
        $this->errorMessages["city"] = "Le choix de ville est invalide";
    }

    /*
     * Is there any errors during the form validation ?
     */
    public function hasErrors() : bool
    {
        return !empty($this->errorMessages);
    }

    public function getName() : string 
    {
        return $this->name;
    }

    public function getDescription() : string 
    {
        return $this->description;
    }

    public function getCityId() : ?int 
    {
        return $this->cityId;
    } 

    public function getErrorMessages() : array
    {
        return $this->errorMessages;
    }






}
