<?php

namespace Views;

include("navOwner.php");

?>

<!DOCTYPE html>
<html>

<head>
    <title>Pet Hero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH . "list.css" ?>">
</head>

<body>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css"
        integrity="sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=" crossorigin="anonymous" />

    <div class="container">

        <div class="error-msg">
            <?php if ($message != null) { ?>
            <div class="alert alert-danger">
                <?php echo $message; ?>
            </div>
            <?php } ?>
        </div>

        <div class="row">
            <div class="col-lg-10 mx-auto">

                <div class="title-div">
                    <h3 class="list-title">When do you need your pets to be cared for?</h3>
                </div>

                <div class="dates">
                    <form action="<?php echo FRONT_ROOT . "User/filterGuardianList" ?>" method="POST">


                        <div class="dates-box">
                            <label>&nbsp;&nbsp;From:</label>
                            <input type="date" name="firstDay" class="dateSelection" required>
                            <label>To:</label>
                            <input type="date" name="lastDay" class="dateSelection" required>
                        </div>

                        <button type="submit" name="submit" class="btn btn-lg btn-block btn-light btn-custom">Search
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</body>

</html>