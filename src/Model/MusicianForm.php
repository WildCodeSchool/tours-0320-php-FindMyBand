<?php
/**
 * User: Ahmad
 * Date: 06/05/20
 */

namespace App\Model;

use App\Model\CityManager;

/**
 * This class can be used to deal with the musician creation form.
 * It is used validate all the fields then recover them
 */
class MusicianForm
{
    // The musician form fields
    private $pseudo;
    private $email;
    private $password;
    private $cityId;
    private $description;
    // An array containing the error messages
    private $errorMessages;


    public function __construct()
    {
        $this->pseudo = "";
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
        if (\filter_has_var(INPUT_POST, "pseudo") &&
            \filter_has_var(INPUT_POST, "city") &&
            \filter_has_var(INPUT_POST, "email") &&
            \filter_has_var(INPUT_POST, "password")) {
            $this->validatePseudo();
            $this->validateCity();
            $this->validateEmail();
            $this->validatePassword();
            $this->validateDescription();
            return true;
        }
        return false;
    }

    /*
     * Validation of the pseudo field which is supposed to be in $_POST["pseudo"]
     * Validation is :
     * size is between 1 and 255 characters
     */
    private function validatePseudo()
    {
        $size = \strlen($_POST["pseudo"]);
        if ($size < 1 || $size > 255) {
            $this->errorMessages["pseudo"] = "Le nom du musician doit faire entre 1 et 255 caractères";
        } else {
            $this->pseudo = $_POST["pseudo"];
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
     * Validation of the email field which is supposed to be in $_POST["email"]
     * Validation is :
     * email valide
     */
    private function validateEmail()
    {
        //je valide le champ email
        if (filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL) === false) {
            $this->errorMessages["email"] = "Le email est invalide";
        } else {
            $this->email= $_POST["email"];
        }
    }

      /*
     * Validation of the password field which is supposed to be in $_POST["password"]
     * Validation is :
     * size is between 1 and 255 characters
     */
    private function validatePassword()
    {
        //je valide le champ password
        $size = \strlen($_POST["password"]);
        if ($size < 1 || $size > 255) {
            $this->errorMessages["password"] = "Le mot de passe doit faire entre 1 et 255 caractères";
        } else {
            $this->password = $_POST["password"];
        }
    }

    /*
     * Validation of the description field which is supposed to be in $_POST["description"]
     */
    private function validateDescription()
    {
        
        $this->description = $_POST["description"];
    }

 

    /*
     * Is there any errors during the form validation ?
     */
    public function hasErrors() : bool
    {
        return !empty($this->errorMessages);
    }

    public function getPseudo() : string
    {
        return $this->pseudo;
    }

    public function getCityId() : ?int
    {
        return $this->cityId;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function getErrorMessages() : array
    {
        return $this->errorMessages;
    }
}
