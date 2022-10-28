<?php

namespace Controllers;

//use DAO\GuardianDAO as GuardianDAO;
use JSON\GuardianDAO as GuardianDAO;

//use DAO\OwnerDAO as OwnerDAO;
use JSON\OwnerDAO as OwnerDAO;

//use DAO\PetDAO as PetDAO;
use JSON\PetDAO as PetDAO;

use Models\Guardian as Guardian;
use Models\Owner as Owner;
use Models\Pet as Pet;

use Controllers\AuthController as AuthController;

class UserController
{
    private $guardianDAO;
    private $ownerDAO;

    public function __construct()
    {
        $this->guardianDAO = new GuardianDAO();
        $this->ownerDAO = new OwnerDAO();
    }

    public function Index()
    {
        if (isset($_SESSION["loggeduser"])) {
            $this->showLandingPage($_SESSION["type"]);
        } else {
            require_once(VIEWS_PATH . "login.php");
        }
    }

    function showLandingPage($type)
    {
        if ($type == 'G') {
            require_once(VIEWS_PATH . "landingPageGuardian.php");
        } else {
            require_once(VIEWS_PATH . "landingPageOwner.php");
        }
    }

    function showBookingHistoryPage($type)
    {
        if ($type == 'G') {
            require_once(VIEWS_PATH . "bookingHistoryGuardian.php");
        } else {
            require_once(VIEWS_PATH . "landingPageOwner.php");
        }
    }

    public function add($firstName = "", $lastName = "", $birthDate = "", $email = "", $phoneNumber = "", $nickName = "", $password = "", $type = "")
    {
        if ($firstName != "" || $lastName != "" || $birthdate != "" || $email != "" || $phoneNumber != "" || $nickName != "" || $password != "" || $type != "") {
            $auth = new AuthController();

            if ($this->validateUser($email, $nickName) == true) {
                if ($this->validateAge($birthDate)) {
                    if ($type == 'G') {

                        $guardian = new Guardian($firstName, $lastName ,$email,$phoneNumber,$birthDate,$nickName,$password);

                        $this->guardianDAO->add($guardian);
                        $auth->login($email, $password);
                    } else if ($type == 'O') {

                        $owner = new Owner($firstName, $lastName ,$email ,$phoneNumber ,$birthDate ,$nickName ,$password);

                        $this->ownerDAO->add($owner);
                        $auth->login($email, $password);
                    }
                } else {
                    echo "<script> if(confirm('You must be 16 or older to register'));";
                    echo "window.location = '" . FRONT_ROOT . "User'; </script>";
                }
            } else {
                echo "<script> if(confirm('User is already registered'));";
                echo "window.location = '" . FRONT_ROOT . "User'; </script>";
            }
        } else {
            echo "<script> if(confirm('User is already registered'));";
            echo "window.location = '" . FRONT_ROOT . "User'; </script>";
        }
    }

    public function validateUser($email, $nickName)
    {
        $validation = true;

        $foundGuardianEmail = $this->guardianDAO->GetByEmail($email);
        $foundGuardianNickname = $this->guardianDAO->getByNickname($nickName);

        $foundOwnerEmail = $this->ownerDAO->GetByEmail($email);
        $foundOwnerNickname = $this->ownerDAO->getByNickname($nickName);

        if ($foundGuardianEmail != null || $foundGuardianNickname != null || $foundOwnerEmail != null || $foundOwnerNickname != null) {
            $validation = false;
        }

        return $validation;
    }

    public function validateAge($DOB)
    {
        $validation = true;

        $diff = date_diff(date_create($DOB), date_create(date("Y-m-d")));

        if ($diff->format('%y') < 16) {
            $validation = false;
        }

        return $validation;
    }


    public function showGuardianList()
    {
        if (isset($_SESSION['loggeduser'])) {
            if ($_SESSION['type'] == 'O') {
                $guardianList = array();
                $guardianList = $this->guardianDAO->getAll();
                require_once(VIEWS_PATH . "GuardianList.php");
            } else {
                require_once(VIEWS_PATH . "landingPageGuardian.php");
            }
        } else {
            require_once(VIEWS_PATH . "login.php");
        }
    }

    public function showProfileInfo()
    {
        if (isset($_SESSION['loggeduser'])) {
            if ($_SESSION['type'] == 'O') {
                $user = new Owner();
                $user = $this->ownerDAO->getByEmail($_SESSION['email']);
                require_once(VIEWS_PATH . "profile.php");
            } else if ($_SESSION['type'] == 'G') {
                $user = new Guardian();
                $user = $this->guardianDAO->getByEmail($_SESSION['email']);
                require_once(VIEWS_PATH . "profile.php");
            }
        } else {
            require_once(VIEWS_PATH . "login.php");
        }
    }

    public function updatePetSizePreference($petSize)
    {
        if (isset($_SESSION['loggeduser'])) {
            if ($_SESSION['type'] == 'G') {
                $user = new Guardian();
                $this->guardianDAO->update($_SESSION['email'], $petSize);
                $user = $this->guardianDAO->getByEmail($_SESSION['email']);
                require_once(VIEWS_PATH . "profile.php");
            } else {
                require_once(VIEWS_PATH . "landingPageOwner.php");
            }
        } else {
            require_once(VIEWS_PATH . "login.php");
        }
    }

    public function updateDate($firstDay,$lastDay)
    {
        if (isset($_SESSION['loggeduser'])) {
            if ($_SESSION['type'] == 'G') {

                $user = new Guardian();
                $this->guardianDAO->updateDate($_SESSION['email'], $firstDay, $lastDay);
                $user = $this->guardianDAO->getByEmail($_SESSION['email']);

                require_once(VIEWS_PATH . "profile.php");
            } else {
                require_once(VIEWS_PATH . "landingPageOwner.php");
            }
        } else {
            require_once(VIEWS_PATH . "login.php");
        }
    }

    public function bookDate($email = ' ' , $pets = ' '){
        if(isset ($_SESSION['loggeduser'])){
            
            // Si viene de la guardian list
            if($email != ' ' && $pets == ' '){
                require_once(VIEWS_PATH . "petSelection.php");
            }

            //  Si viene de petSelection
            elseif($email != ' ' && $pets != ' '){
                
                require_once(VIEWS_PATH . "bookingConfirmation.php");
            }

            // Si no tiene ninguno de los datos para hacer la reserva
            elseif($email == ' ' && $pets == ' ')
            {
                $this->showGuardianList();
            }
        }
        else
        {
            require_once(VIEWS_PATH."login.php");
        }
    }
}