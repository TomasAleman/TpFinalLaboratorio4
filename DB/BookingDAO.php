<?php

namespace DB;

use Models\Booking as Booking;
use DB\PetDAO as PetDAO;
//use DAOInterfaces\IBookingDao as IBookingDao;
use DB\Connection as Connection;
use \Exception as Exception;

class BookingDAO
{
    private $connection;
    private $tableName = "Bookings";

    function add(Booking $booking)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " 
            (id_status, start_date, end_date, totalAmount, id_guardian) 
            VALUES (:status,:firstDay,:lastDay,:totalAmount,:idGuardian);";

            $parameters["status"] = $booking->getStatus();
            $parameters["firstDay"] = $booking->getStartDate();
            $parameters["lastDay"] = $booking->getEndDate();
            $parameters["totalAmount"] = $booking->getPrice();
            $parameters["idGuardian"] = $booking->getGuardianId();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);

            $idBooking = $this->getMaxIdBooking();
            $this->addOwnerXBooking($booking->getOwnerId(), $idBooking);

            $arraypets = $booking->getPet();
            foreach ($arraypets as $pet) {
                $this->addBookingXPets($pet->getId(), $idBooking);
            }
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    function getMaxIdBooking()
    {
        try {
            $query =  "SELECT max(id) as 'id' FROM " . $this->tableName;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query);

            foreach ($result as $row) {
                $idBooking = $row["id"];
            }

            return $idBooking;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    function addOwnerXBooking($idOwner, $idBooking)
    {
        try {
            $query = "INSERT INTO ownerxbooking  
            (id_owner, id_booking) 
            VALUES (:idOwner, :idBooking);";

            $parameters["idOwner"] = $idOwner;
            $parameters["idBooking"] = $idBooking;

            $this->connection = Connection::GetInstance();

            $this->connection->Execute($query, $parameters);
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    function addBookingXPets($idPet, $idBooking)
    {
        try {
            $query = "INSERT INTO bookingxpet
            (id_booking, id_pet) 
            VALUES (:idBooking, :idPet);";

            $parameters["idPet"] = $idPet;
            $parameters["idBooking"] = $idBooking;

            $this->connection = Connection::GetInstance();

            $this->connection->Execute($query, $parameters);
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    function getByIdGuardian($idGuardian)
    {
        try {
            $bookingList = array();

            $query =
                "SELECT b.id, b.id_status, b.start_date, b.end_date, b.totalAmount, b.id_guardian, ob.id_owner 
            FROM bookings as b 
            JOIN ownerxbooking as ob
            ON b.id = ob.id_booking 
            WHERE b.id_guardian = :idGuardian  AND b.id_status <> '1';";

            $parameters["idGuardian"] = $idGuardian;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $booking = new Booking($this->getPets($row['id']), ($row["start_date"]), ($row["end_date"]), ($row["id_owner"]), ($row["id_guardian"]), ($row["totalAmount"]));

                $booking->setId($row["id"]);
                $booking->setStatus($row["id_status"]);

                array_push($bookingList, $booking);
            }

            return count($bookingList) > 0 ? $bookingList : null;
        } catch (Exception $ex) {
            throw $ex;
            echo "excepcion en getByIdGuardian";
        }
    }

    function getByIdOwner($idOwner)
    {
        try {
            $bookingList = array();

            $query =
                "SELECT b.id, b.id_status, b.start_date, b.end_date, b.totalAmount, b.id_guardian, ob.id_owner 
            FROM bookings as b 
            JOIN ownerxbooking as ob
            ON b.id = ob.id_booking 
            WHERE ob.id_owner = :idOwner AND (b.id_status = '1' OR b.id_status = '2' OR b.id_status = '4');";

            $parameters["idOwner"] = $idOwner;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $booking = new Booking($this->getPets($row['id']), ($row["start_date"]), ($row["end_date"]), ($row["id_owner"]), ($row["id_guardian"]), ($row["totalAmount"]));

                $booking->setId($row["id"]);
                $booking->setStatus($row["id_status"]);

                array_push($bookingList, $booking);
            }

            return count($bookingList) > 0 ? $bookingList : null;
        } catch (Exception $ex) {
            throw $ex;
            echo "excepcion en getByIdOwner";
        }
    }

    function getBookingsBetweenDates($idGuardian, $firstDay, $lastDay)
    {
        try {
            $bookingList = array();

            $query = "SELECT b.id, b.id_status, b.start_date, b.end_date, b.totalAmount, b.id_guardian, ob.id_owner 
            FROM bookings as b 
            JOIN ownerxbooking as ob
            ON b.id = ob.id_booking 
            WHERE (id_status = '2'
            OR id_status = '5') 
            AND (b.id_guardian = :idGuardian)
            AND (((b.start_date between :firstDay and :lastDay) or (b.end_date between :firstDay and :lastDay)) 
            OR ((:firstDay between b.start_date and b.end_date) or (:lastDay between b.start_date and b.end_date)));";

            $parameters["firstDay"] = $firstDay;
            $parameters["lastDay"] = $lastDay;
            $parameters["idGuardian"] = $idGuardian;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $booking = new Booking($this->getPets($row['id']), ($row["start_date"]), ($row["end_date"]), ($row["id_owner"]), ($row["id_guardian"]), ($row["totalAmount"]));
                $booking->setId($row["id"]);
                $booking->setStatus($row["id_status"]);

                array_push($bookingList, $booking);
            }

            return count($bookingList) > 0 ? $bookingList : null;
        } catch (Exception $ex) {
            throw $ex;
            echo "excepcion en getBookingsBetweenDates";
        }
    }

    function getRequests($idGuardian)
    {
        try {
            $requestsList = array();

            $query = "SELECT b.id, b.id_status, b.start_date, b.end_date, b.totalAmount, b.id_guardian, ob.id_owner 
            FROM bookings as b 
            JOIN ownerxbooking as ob 
            ON b.id = ob.id_booking 
            WHERE id_guardian = :idGuardian AND id_status = '1';";

            $parameters["idGuardian"] = $idGuardian;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);
            foreach ($resultSet as $row) {
                $booking = new Booking($this->getPets($row['id']), ($row["start_date"]), ($row["end_date"]), ($row["id_owner"]), ($row["id_guardian"]), ($row["totalAmount"]));

                $booking->setId($row["id"]);
                $booking->setStatus($row["id_status"]);
                array_push($requestsList, $booking);
            }

            return count($requestsList) > 0 ? $requestsList : null;
        } catch (Exception $ex) {
            throw $ex;
            echo "excepcion en getRequests";
        }
    }

    function getPets($idBooking)
    {
        try {
            $query = "SELECT id_pet 
            FROM bookingxpet 
            WHERE id_booking = :idBooking;";

            $parameters["idBooking"] = $idBooking;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $arrayPets = array();
            $petDAO = new PetDAO();

            foreach ($resultSet as $row) {
                array_push($arrayPets, $petDAO->getPetById($row['id_pet']));
            }

            return $arrayPets;
        } catch (Exception $ex) {
            throw $ex;
            echo " excepcion en getPets bookingDAO";
        }
    }

    public function updateStatus($id, $status)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET id_status = :status 
            WHERE id = :id;";

            $parameters['id'] = $id;
            $parameters['status'] = $status;

            $this->connection = Connection::GetInstance();

            $this->connection->Execute($query, $parameters);
        } catch (Exception $ex) {
            // throw $ex;
            echo ' exc en updateStatus() de BookingDAO';
        }
    }

    function getById($id)
    {
        try {
            $bookingList = array();

            $query = "SELECT b.id, b.id_status, b.start_date, b.end_date, b.totalAmount, b.id_guardian, ob.id_owner 
            FROM bookings as b 
            JOIN ownerxbooking as ob 
            ON b.id = ob.id_booking 
            WHERE b.id = :id AND id_status = '1';";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);
            foreach ($resultSet as $row) {
                $booking = new Booking($this->getPets($row['id']), ($row["start_date"]), ($row["end_date"]), ($row["id_owner"]), ($row["id_guardian"]), ($row["totalAmount"]));

                $booking->setId($row["id"]);
                $booking->setStatus($row["id_status"]);
                array_push($bookingList, $booking);
            }

            return count($bookingList) > 0 ? $bookingList[0] : null;
        } catch (Exception $ex) {
            throw $ex;
            echo "excepcion en getById";
        }
    }

    function updatePastConfirmedBookings($idGuardian)
    {

        $query = "UPDATE " . $this->tableName . " SET id_status = 4 WHERE id_status = 5 AND id_guardian = :idGuardian AND (end_date < now());";

        $parameters["idGuardian"] = $idGuardian;

        $this->connection = Connection::GetInstance();

        $resultSet = $this->connection->ExecuteNonQuery($query, $parameters);
    }

    function updatePastAcceptedBookings($idGuardian)
    {

        $query = "UPDATE " . $this->tableName . " SET id_status = 3 WHERE id_status = 2 AND id_guardian = :idGuardian AND (start_date < now());";

        $parameters["idGuardian"] = $idGuardian;

        $this->connection = Connection::GetInstance();

        $resultSet = $this->connection->ExecuteNonQuery($query, $parameters);
    }


    function updatePastWaitingBookings($idGuardian)
    {

        $query = "UPDATE " . $this->tableName . " SET id_status = 3 WHERE id_status = 1 AND id_guardian = :idGuardian AND (start_date < now());";

        $parameters["idGuardian"] = $idGuardian;

        $this->connection = Connection::GetInstance();

        $resultSet = $this->connection->ExecuteNonQuery($query, $parameters);
    }
}