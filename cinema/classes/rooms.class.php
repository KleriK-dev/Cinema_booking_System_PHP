<?php

class Room
{
    private $room_id;
    private $roomName;
    private $seatCol;
    private $seatRow;
    private $roomDescription;
    private $roomImage;

    function __construct($room_id, $roomName, $seatCol, $seatRow, $roomDescription, $roomImage)
    {
        $this->room_id = $room_id;
        $this->roomName = $roomName;
        $this->seatCol = $seatCol;
        $this->seatRow = $seatRow;
        $this->roomDescription = $roomDescription;
        $this->roomImage = $roomImage;
    }

    public function addRoom()
    {

        include "../includes/connectDB.inc.php";

        $query = "INSERT INTO rooms (room_id, roomName, seat_column, seat_row, roomDescription, room_image) 
                    VALUES (NULL, '$this->roomName', '$this->seatCol', '$this->seatRow', '$this->roomDescription', '$this->roomImage')";

        if ($conn->query($query) == true) {
            header("Location: ../createRoom.php?roomCreated=success");
            exit();
        } else {
            header("Location: ../createRoom.php?roomCreated=failed");
            exit();
        }
    }

    public function deleteRoom()
    {
        include "../includes/connectDB.inc.php";

            $query1 = "DELETE FROM rooms WHERE room_id = $this->room_id ";

            $result = $conn->query($query1);

            if ($result == false) {
                header("Location: ../rooms.php?roomDeleted=failed");
                exit();
            } else {
                header("Location: ../rooms.php?roomDeleted=success");
                exit();
            }
    }

    public function editRoom()
    {
        include "../includes/connectDB.inc.php";

        $query = "UPDATE rooms
                    SET roomName = '$this->roomName',
                        seat_column = '$this->seatCol',
                        seat_row = '$this->seatRow',
                        roomDescription = '$this->roomDescription',
                        room_image = '$this->roomImage'
                    WHERE room_id = $this->room_id
                    ";

        if ($conn->query($query) == true) {
            header("Location: ../rooms.php?roomEdited=success");
            exit();

        } else {
            header("Location: ../rooms.php?roomEdited=failed");
            exit();
        }
    }

}

if (isset($_POST['submit-roomCr'])) { //check if presset submit button

    //we need to prepare the file to a string in correct form so it can be saved correctlly
    $image = addslashes(file_get_contents($_FILES['uploadfile']['tmp_name']));

    $newRoom = new Room(null, $_POST['roomName'], $_POST['columnNr'], $_POST['rowNr'], $_POST['roomDescription'], $image); //we put null to the first parameter as we dont need it in this action

    $newRoom->addRoom();
}

if (isset($_GET['deleteRoom'])) { //check if pressed delete button

    $deleteRoom = new Room($_GET['deleteRoom'], null, null, null, null, null); //we put null to the other parameters as we don't need them

    $deleteRoom->deleteRoom();
}

if (isset($_POST['submit-roomUp'])) { //check if pressed edit button

    //we need to prepare the file to a string in correct form so it can be saved correctlly
    $image = addslashes(file_get_contents($_FILES['uploadfile']['tmp_name']));

    $updateRoom = new Room($_POST['room_idH'], $_POST['roomName'], $_POST['columnNr'], $_POST['rowNr'], $_POST['roomDescription'], $image);

    $updateRoom->editRoom();
}
