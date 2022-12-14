<?php

namespace Views;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href=<?php echo CSS_PATH . "navGuardian.css" ?>>
</head>

<body>
    <nav>
        <a href="<?php echo FRONT_ROOT . "User/showLandingPage/" . $_SESSION['type']; ?>">Home</a>
        <a href="<?php echo FRONT_ROOT . "User/showProfileInfo" ?>">Profile</a>
        <a href="<?php echo FRONT_ROOT . "Booking/showBookingHistory"; ?>">Booking&nbsp;history</a>
        <a href="<?php echo FRONT_ROOT . "Booking/showGuardianRequests/" ?>">Requests</a>
        <a href="<?php echo FRONT_ROOT . "Auth/logout" ?>">Logout</a>
        <div class="animation start-home"></div>
    </nav>

</body>

</html>