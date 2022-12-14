<?php

namespace DB;

use DAOInterfaces\IGuardianDao as IGuardianDao;
use Models\Guardian as Guardian;
use DB\Connection as Connection;
use \Exception as Exception;

class GuardianDAO implements IGuardianDAO
{
    private $connection;
    private $tableName = "Guardians";

    public function add(Guardian $guardian)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " 
            (email, pass, first_name, last_name, phone, birth_date, nickname) 
            VALUES (:email,:password,:firstName,:lastName,:phoneNumber,:birthDate,:nickName);";

            $parameters["email"] = $guardian->getEmail();
            $parameters["password"] = $guardian->getPassword();
            $parameters["firstName"] = $guardian->getFirstName();
            $parameters["lastName"] = $guardian->getLastName();
            $parameters["phoneNumber"] = $guardian->getPhoneNumber();
            $parameters["birthDate"] = $guardian->getBirthDate();
            $parameters["nickName"] = $guardian->getNickName();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function addScore($idGuardian, $score)
    {
        try {
            $query = "INSERT INTO scores (id_guardian, id_owner, score) VALUES (:idGuardian, :idOwner, :score);";

            $parameters['idGuardian'] = $idGuardian;
            $parameters['idOwner'] = $_SESSION['id'];
            $parameters['score'] = $score;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);

            $this->updateScore($idGuardian);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function newGuardian($row)
    {
        $guardian = new Guardian(
            $row["first_name"],
            $row["last_name"],
            $row["email"],
            $row["phone"],
            $row["birth_date"],
            $row["nickname"],
            $row["pass"],
            $row["score"],
            $row["size"],
            $row["price"],
            $row["first_available_day"],
            $row["last_available_day"]
        );
        $guardian->setId($row["id"]);
        return $guardian;
    }

    public function getAllVisible()
    {
        try {
            $guardianList = array();

            $query = "SELECT g.id, g.email, g.pass, g.first_name, g.last_name, 
            g.phone, g.birth_date, g.nickname, g.score, g.first_available_day, g.last_available_day, g.price, ps.size  
            FROM " . $this->tableName  . " AS g 
            JOIN GuardianXSize AS gxs
            ON g.id = gxs.id_guardian
            JOIN petsizes AS ps
            ON gxs.id_petsize = ps.id
            WHERE (g.first_available_day is not null) and (g.last_available_day is not null) and (g.price is not null);";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $guardian = $this->newGuardian($row);
                array_push($guardianList, $guardian);
            }

            return count($guardianList) > 0 ? $guardianList : null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getGuardiansByDate($firstDay, $lastDay)
    {
        try {
            $guardianList = array();

            $query = "SELECT g.id, g.email, g.pass, g.first_name, g.last_name, g.phone, g.birth_date, g.nickname, g.score, g.first_available_day, g.last_available_day, g.price, ps.size
            FROM " . $this->tableName . " AS g 
            JOIN guardianxsize as gxs 
            ON g.id = gxs.id_guardian 
            LEFT JOIN petsizes AS ps 
            ON gxs.id_petsize = ps.id 
            WHERE (g.first_available_day <= :firstDay AND g.last_available_day >= :lastDay);";

            $parameters['firstDay'] = $firstDay;
            $parameters['lastDay'] = $lastDay;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $guardian = $this->newGuardian($row);
                array_push($guardianList, $guardian);
            }
            return (count($guardianList) > 0) ? $guardianList : null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getById($id)
    {
        try {

            $query = "SELECT g.id, g.email, g.pass, g.first_name, g.last_name, g.phone, g.birth_date, 
            g.nickname, g.score, g.first_available_day, g.last_available_day, g.price, ps.size  
            FROM " . $this->tableName  . " AS g 
            LEFT JOIN GuardianXSize AS gxs
            ON g.id = gxs.id_guardian
            LEFT JOIN petsizes AS ps
            ON gxs.id_petsize = ps.id 
            WHERE g.id = :id;";

            $parameters['id'] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $guardian = null;

            if (!empty($resultSet)) {
                $row = $resultSet[0];
                $guardian = $this->newGuardian($row);
            }

            return $guardian;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getByEmail($email)
    {
        try {

            $query = "SELECT g.id, g.email, g.pass, g.first_name, g.last_name, g.phone, g.birth_date, g.nickname, g.score, g.first_available_day, g.last_available_day, g.price, ps.size  
            FROM " . $this->tableName  . " AS g 
            LEFT JOIN GuardianXSize AS gxs
            ON g.id = gxs.id_guardian
            LEFT JOIN petsizes AS ps
            ON gxs.id_petsize = ps.id 
            WHERE email = :email;";

            $parameters['email'] = $email;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $guardian = null;

            if (!empty($resultSet)) {
                $row = $resultSet[0];
                $guardian = $this->newGuardian($row);
            }

            return $guardian;
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    public function getByNickName($nickname)
    {
        try {

            $query = "SELECT g.id, g.email, g.pass, g.first_name, g.last_name, g.phone, g.birth_date, g.nickname, g.score, g.first_available_day, g.last_available_day, g.price, ps.size  
            FROM " . $this->tableName  . " AS g 
            LEFT JOIN GuardianXSize AS gxs
            ON g.id = gxs.id_guardian
            LEFT JOIN petsizes AS ps
            ON gxs.id_petsize = ps.id 
            WHERE nickname = :nickname;";

            $parameters['nickname'] = $nickname;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $guardian = null;

            if (!empty($resultSet)) {
                $row = $resultSet[0];
                $guardian = $this->newGuardian($row);
            }

            return $guardian;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function validateGuardianxSize($id)
    {
        try {

            $query = "SELECT * FROM GuardianxSize WHERE id_guardian = :id;";

            $parameters['id'] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            if (empty($resultSet)) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function update($id, $petSize)
    {
        try {
            if ($this->validateGuardianxSize($id)) {
                $query = "UPDATE GuardianxSize SET id_petsize = :petSize WHERE id_guardian = :id;";

                $parameters['id'] = $id;
                $parameters['petSize'] = $petSize;

                $this->connection = Connection::GetInstance();

                $this->connection->Execute($query, $parameters);
            } else {
                $query = "INSERT INTO GuardianxSize (id_guardian, id_petsize) VALUES (:id, :petSize);";

                $parameters['id'] = $id;
                $parameters['petSize'] = $petSize;

                $this->connection = Connection::GetInstance();

                $this->connection->Execute($query, $parameters);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function updateDate($id, $firstDay, $lastDay)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET first_available_day = :firstDay, 
            last_available_day = :lastDay WHERE id = :id;";

            $parameters['firstDay'] = $firstDay;
            $parameters['lastDay'] = $lastDay;
            $parameters['id'] = $id;

            $this->connection = Connection::GetInstance();

            $this->connection->Execute($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function updatePrice($id, $price)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET price = :price  WHERE id = :id;";

            $parameters['price'] = $price;
            $parameters['id'] = $id;

            $this->connection = Connection::GetInstance();

            $this->connection->Execute($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function updateScore($idGuardian)
    {
        try {
            $query = "UPDATE "  . $this->tableName . " SET score = (SELECT avg(score)
            FROM scores
            WHERE id_guardian = :idGuardian) 
            WHERE id = :idGuardian;";

            $parameters['idGuardian'] = $idGuardian;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function changePassword($guardian, $newPass)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET pass = :newPass 
            WHERE id = :idGuardian;";

            $parameters['newPass'] = $newPass;
            $parameters['idGuardian'] = $guardian->getId();

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}