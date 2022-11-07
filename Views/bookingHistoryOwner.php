<?php

namespace Views;

include("navGuardian.php");

?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH . "list.css" ?>">
</head>

<body>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" integrity="sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=" crossorigin="anonymous" />

    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto mb-4">
                <div class="section-title text-center ">
                    <h3 class="top-c-sep"><br>Booking History</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="career-search mb-60">

                    <form action="#" class="career-form mb-60">
                        <div class="row">

                            <div class="col-md-6 col-lg-3 my-3">
                                <div class="input-group position-relative">
                                    <input type="text" class="form-control" placeholder="Enter a Pet's Name" id="keywords">
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3 my-3">
                                <div class="select-container">
                                    <select class="custom-select">
                                        <option value="" disabled selected hidden>Pet Type</option>
                                        <option value="1">Dog</option>
                                        <option value="2">Cat</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3 my-3">
                                <input type="date" name="bookingDate" class="form-control">
                            </div>

                            <div class="col-md-6 col-lg-3 my-3">
                                <button type="button" class="btn btn-lg btn-block btn-light btn-custom" id="search-btn">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="filter-result">

                        <div class="job-box d-md-flex align-items-center justify-content-between mb-30">
                            <div class="job-left my-4 d-md-flex align-items-center flex-wrap">
                                <div class="img-holder mr-md-4 mb-md-0 mb-4 mx-auto mx-md-0 d-md-none d-lg-flex">
                                    B1
                                </div>
                                <div class="job-content">
                                    <h5 class="text-md-left">Booking 1</h5>
                                    <ul class="d-md-flex flex-wrap ff-open-sans">
                                        <li class="mr-md-4">
                                            <i class="zmdi zmdi-pin mr-2"></i> Los Angeles
                                        </li>
                                        <li class="mr-md-4">
                                            <i class="zmdi zmdi-money mr-2"></i> 2500-3500/pm
                                        </li>
                                        <li class="mr-md-4">
                                            <i class="zmdi zmdi-time mr-2"></i> Full Time
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="job-right my-4 flex-shrink-0">
                                <a href="#" class="btn d-block w-100 d-sm-inline-block btn-light">More details</a>
                            </div>
                        </div>

                        <div class="job-box d-md-flex align-items-center justify-content-between mb-30">
                            <div class="job-left my-4 d-md-flex align-items-center flex-wrap">
                                <div class="img-holder mr-md-4 mb-md-0 mb-4 mx-auto mx-md-0 d-md-none d-lg-flex">
                                    B2
                                </div>
                                <div class="job-content">
                                    <h5 class="text-md-left">Booking 2</h5>
                                    <ul class="d-md-flex flex-wrap ff-open-sans">
                                        <li class="mr-md-4">
                                            <i class="zmdi zmdi-pin mr-2"></i> Los Angeles
                                        </li>
                                        <li class="mr-md-4">
                                            <i class="zmdi zmdi-money mr-2"></i> 2500-3500/pm
                                        </li>
                                        <li class="mr-md-4">
                                            <i class="zmdi zmdi-time mr-2"></i> Full Time
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="job-right my-4 flex-shrink-0">
                                <a href="#" class="btn d-block w-100 d-sm-inline-block btn-light">More details</a>
                            </div>
                        </div>

                        <div class="job-box d-md-flex align-items-center justify-content-between mb-30">
                            <div class="job-left my-4 d-md-flex align-items-center flex-wrap">
                                <div class="img-holder mr-md-4 mb-md-0 mb-4 mx-auto mx-md-0 d-md-none d-lg-flex">
                                    B3
                                </div>
                                <div class="job-content">
                                    <h5 class="text-md-left">Booking 3</h5>
                                    <ul class="d-md-flex flex-wrap ff-open-sans">
                                        <li class="mr-md-4">
                                            <i class="zmdi zmdi-pin mr-2"></i> Los Angeles
                                        </li>
                                        <li class="mr-md-4">
                                            <i class="zmdi zmdi-money mr-2"></i> 2500-3500/pm
                                        </li>
                                        <li class="mr-md-4">
                                            <i class="zmdi zmdi-time mr-2"></i> Full Time
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="job-right my-4 flex-shrink-0">
                                <a href="#" class="btn d-block w-100 d-sm-inline-block btn-light">More details</a>
                            </div>
                        </div>

                        <div class="job-box d-md-flex align-items-center justify-content-between mb-30">
                            <div class="job-left my-4 d-md-flex align-items-center flex-wrap">
                                <div class="img-holder mr-md-4 mb-md-0 mb-4 mx-auto mx-md-0 d-md-none d-lg-flex">
                                    B4
                                </div>
                                <div class="job-content">
                                    <h5 class="text-md-left">Booking 4</h5>
                                    <ul class="d-md-flex flex-wrap ff-open-sans">
                                        <li class="mr-md-4">
                                            <i class="zmdi zmdi-pin mr-2"></i> Los Angeles
                                        </li>
                                        <li class="mr-md-4">
                                            <i class="zmdi zmdi-money mr-2"></i> 2500-3500/pm
                                        </li>
                                        <li class="mr-md-4">
                                            <i class="zmdi zmdi-time mr-2"></i> Full Time
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="job-right my-4 flex-shrink-0">
                                <a href="#" class="btn d-block w-100 d-sm-inline-block btn-light">More details</a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- START Pagination -->

                <ul class="pagination pagination-reset justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                            <i class="zmdi zmdi-long-arrow-left"></i>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item d-none d-md-inline-block"><a class="page-link" href="#">2</a></li>
                    <li class="page-item d-none d-md-inline-block"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">...</a></li>
                    <li class="page-item"><a class="page-link" href="#">8</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <i class="zmdi zmdi-long-arrow-right"></i>
                        </a>
                    </li>
                </ul>
                </nav>
                <!-- END Pagination -->
            </div>
        </div>

    </div>
</body>

</html>