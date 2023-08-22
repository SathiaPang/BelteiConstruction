<?php
include_once 'db.php';
session_start();

$sql = "SELECT * FROM tblviewer";
$query = mysqli_query($conn, $sql);
$data = mysqli_fetch_array($query);

$total = $data['total'];

if (!isset($_SESSION['viewer'])) {
    $total++;
    $sql = "UPDATE `tblviewer` SET `total`=" . $total . " WHERE 1";
    $query = mysqli_query($conn, $sql);

    $_SESSION['viewer'] = 1;
}



if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $searchtxt = $_POST['searchtxt'];
    $lang = $_POST['lang'];

    if ($searchtxt != "") {
        header("location:index.php?lang=$lang&searchtxt=$searchtxt");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='bootstrap/bootstrap.min.css'>
    <script src='bootstrap/jquery-3.2.1.slim.min.js'></script>
    <script src='bootstrap/popper.min.js'></script>
    <script src='bootstrap/bootstrap.min.js'></script>
    <script src="https://kit.fontawesome.com/e9df768d2a.js" crossorigin="anonymous"></script>
    <title>BELTEI TOUR</title>
    <style>
        body {
            background-color: #7BA46A;
        }

        .category {
            box-shadow: inset 0 0 20px blue;
            background-color: rgb(214, 227, 207);
            padding: 10px;
        }

        .main-category {
            background-color: darkgreen;
            color: yellow;
            padding: 5px 10px;
            font-size: 14px;
            font-family: 'Khmer OS', 'Times New Roman', Times, serif;
        }

        .sub1 {
            padding: 10px;
            color: blue;
            font-size: 14px;
            font-family: 'Khmer OS', 'Times New Roman', Times, serif;
            box-shadow: 0 0 5px blue;
            font-weight: bold;
        }

        .sub2 {
            padding: 10px;
            padding-left: 40px;
            color: blue;
            font-size: 12px;
            font-family: 'Khmer OS', 'Times New Roman', Times, serif;
            box-shadow: 0 0 5px blue;
            font-weight: bold;
        }

        .sub-topdes {
            font-size: 20px;
            border-radius: 10px;
            border: 5px solid red;
            color: blue;
            font-weight: bold;
            margin: 5px 0;
            padding: 5px 60px;
            text-align: center;
            font-family: 'Khmer OS', 'Times New Roman', Times, serif;
            position: relative;
        }

        .num-sub-topdes {
            position: absolute;
            top: 0;
            transform: translateY(50%);
            left: 0;
            z-index: 1;
            color: white;
        }

        .sub-topdes::after {
            content: '';
            position: absolute;
            top: 50%;
            left: -10px;
            height: 100%;
            transform: translateY(-50%);
            width: 0px;
            border-top: 40px solid transparent;
            border-bottom: 40px solid transparent;
            border-left: 40px solid darkgreen;
        }

        #navbar {
            display: none;
        }

        @media only screen and (max-width: 600px) {
            #navbar {
                display: block;
            }

            .leftmenu {
                display: none;
            }

            .rightmenu {
                display: none;
            }

            .maincontent {
                padding: 0 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container p-0 bg-white" id="container">
        <a href="index.php<?php if (!isset($_GET['lang']) || $_GET['lang'] == "EN") echo "";
                            else echo "?lang=KH"; ?>">
            <div>
                <?php
                $sql = "SELECT * FROM tblimage WHERE PositionID='5' ORDER BY ImageID DESC";
                $query = mysqli_query($conn, $sql);
                $data = mysqli_fetch_array($query);
                echo '<img src="images/' . $data["ImageNameKH"] . '" alt="banner" style="width: 100%;">';
                ?>

            </div>
        </a>


        <!-- navbar -->
        <div class="row" id="navbar">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="#">BELTEI TOUR</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">

                            <?php

                            if (!isset($_GET['lang']) || $_GET['lang'] == "EN") {

                                $sqlmain = "SELECT * FROM tblmaincategory";
                                $querymain = mysqli_query($conn, $sqlmain);

                                $letters = range('A', 'Z');
                                $l = 0;
                                while ($main = mysqli_fetch_array($querymain)) {
                                    echo '<li class="nav-item dropdown">';
                                    echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $letters[$l] . '. ' . $main["MainCategoryTitleEN"] . '</a>';
                                    echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';

                                    $sqlsub1 = 'SELECT * FROM tblsub1category WHERE MainCategoryID="' . $main["MainCategoryID"] . '"';
                                    $querysub1 = mysqli_query($conn, $sqlsub1);
                                    $l++;

                                    $i = 1;
                                    while ($sub1 = mysqli_fetch_array($querysub1)) {
                                        $sqlsub2 = 'SELECT * FROM tblsub2category WHERE Sub1CategoryID="' . $sub1["Sub1CategoryID"] . '"';
                                        $querysub2 = mysqli_query($conn, $sqlsub2);
                                        $sub2 = mysqli_fetch_array($querysub2);

                                        if (empty($sub2)) {
                                            echo '<a class="dropdown-item" href="?Sub1CategoryID=' . $sub1["Sub1CategoryID"] . '">' . $i . '. ' . $sub1["Sub1CategoryNameEN"] . '</a>';
                                        } else {

                                            mysqli_data_seek($querysub2, 0);
                                            echo '<a class="dropdown-item dropdown">';
                                            echo '<a class="nav-link dropdown-toggle px-4" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            ' . $i . '. ' . $sub1["Sub1CategoryNameEN"] . '</a>';
                                            echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                                            while ($sub2 = mysqli_fetch_array($querysub2)) {
                                                echo '<a class="dropdown-item" href="?Sub2CategoryID=' . $sub2["Sub2CategoryID"] . '">- ' . $sub2["Sub2CategoryNameEN"] . '</a>';
                                            }
                                            echo '</div>';
                                            echo '</a>';
                                        }

                                        $i++;
                                    }

                                    echo '</div>';
                                    echo '</li>';
                                }
                                echo '<li class="nav-item"> <a class="nav-link active" aria-current="page" href="index.php?lang=KH">Change Language</a></li>';
                            } else {
                                $sqlmain = "SELECT * FROM tblmaincategory";
                                $querymain = mysqli_query($conn, $sqlmain);

                                $letters = range('A', 'Z');
                                $l = 0;
                                while ($main = mysqli_fetch_array($querymain)) {
                                    echo '<li class="nav-item dropdown">';
                                    echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $letters[$l] . '. ' . $main["MainCategoryTitleKH"] . '</a>';
                                    echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';

                                    $sqlsub1 = 'SELECT * FROM tblsub1category WHERE MainCategoryID="' . $main["MainCategoryID"] . '"';
                                    $querysub1 = mysqli_query($conn, $sqlsub1);
                                    $l++;

                                    $i = 1;
                                    while ($sub1 = mysqli_fetch_array($querysub1)) {
                                        $sqlsub2 = 'SELECT * FROM tblsub2category WHERE Sub1CategoryID="' . $sub1["Sub1CategoryID"] . '"';
                                        $querysub2 = mysqli_query($conn, $sqlsub2);
                                        $sub2 = mysqli_fetch_array($querysub2);

                                        if (empty($sub2)) {
                                            echo '<a class="dropdown-item" href="?Sub1CategoryID=' . $sub1["Sub1CategoryID"] . '">' . $i . '. ' . $sub1["Sub1CategoryNameKH"] . '</a>';
                                        } else {

                                            mysqli_data_seek($querysub2, 0);
                                            echo '<a class="dropdown-item dropdown">';
                                            echo '<a class="nav-link dropdown-toggle px-4" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            ' . $i . '. ' . $sub1["Sub1CategoryNameKH"] . '</a>';
                                            echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                                            while ($sub2 = mysqli_fetch_array($querysub2)) {
                                                echo '<a class="dropdown-item" href="?Sub2CategoryID=' . $sub2["Sub2CategoryID"] . '">- ' . $sub2["Sub2CategoryNameKH"] . '</a>';
                                            }
                                            echo '</div>';
                                            echo '</a>';
                                        }

                                        $i++;
                                    }
                                    echo '</div>';
                                    echo '</li>';
                                }
                                echo '<li class="nav-item"> <a class="nav-link active" aria-current="page" href="index.php?lang=EN">ប្តូរភាសា</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <div class="row">

            <!-- left -->
            <div class="col-lg-3 leftmenu">

                <?php

                if (!isset($_GET['lang']) || $_GET['lang'] == "EN") {

                    $sqlmain = "SELECT * FROM tblmaincategory";
                    $querymain = mysqli_query($conn, $sqlmain);

                    $letters = range('A', 'Z');
                    $l = 0;
                    while ($main = mysqli_fetch_array($querymain)) {
                        echo '<div class="category">';
                        echo '<div class="main-category"><b>' . $letters[$l] . '. ' . $main["MainCategoryTitleEN"] . '</b></div>';
                        $sqlsub1 = 'SELECT * FROM tblsub1category WHERE MainCategoryID="' . $main["MainCategoryID"] . '"';
                        $querysub1 = mysqli_query($conn, $sqlsub1);
                        $l++;

                        $i = 1;
                        while ($sub1 = mysqli_fetch_array($querysub1)) {

                            if ($main["MainCategoryID"] == 3) {
                                echo '<a href="?Sub1CategoryID=' . $sub1["Sub1CategoryID"] . '"><div class="sub-topdes">';
                                echo '<span class="num-sub-topdes">' . $i . '</span>';
                                echo $sub1["Sub1CategoryNameEN"];
                                echo '</div></a>';
                            } else {
                                $sqlsub2 = 'SELECT * FROM tblsub2category WHERE Sub1CategoryID="' . $sub1["Sub1CategoryID"] . '"';
                                $querysub2 = mysqli_query($conn, $sqlsub2);
                                $sub2 = mysqli_fetch_array($querysub2);

                                if (empty($sub2)) {
                                    echo '<a href="?Sub1CategoryID=' . $sub1["Sub1CategoryID"] . '"><div class="sub1">' . $i . '. ' . $sub1["Sub1CategoryNameEN"] . '</div></a>';
                                } else {
                                    mysqli_data_seek($querysub2, 0);
                                    echo '<div class="sub1">' . $i . '. ' . $sub1["Sub1CategoryNameEN"] . '</div>';
                                    while ($sub2 = mysqli_fetch_array($querysub2)) {
                                        echo '<a href="?Sub2CategoryID=' . $sub2["Sub2CategoryID"] . '"><div class="sub2">- ' . $sub2["Sub2CategoryNameEN"] . '</div></a>';
                                    }
                                }

                                $i++;
                            }
                        }
                        echo '</div>';
                    }
                } else {

                    $sqlmain = "SELECT * FROM tblmaincategory";
                    $querymain = mysqli_query($conn, $sqlmain);

                    $letters = range('A', 'Z');
                    $l = 0;
                    while ($main = mysqli_fetch_array($querymain)) {
                        if ($main["MainCategoryID"] == 3) continue;

                        echo '<div class="category">';
                        echo '<div class="main-category"><b>' . $letters[$l] . '. ' . $main["MainCategoryTitleKH"] . '</b></div>';
                        $sqlsub1 = 'SELECT * FROM tblsub1category WHERE MainCategoryID="' . $main["MainCategoryID"] . '"';
                        $querysub1 = mysqli_query($conn, $sqlsub1);
                        $l++;

                        $i = 1;
                        while ($sub1 = mysqli_fetch_array($querysub1)) {

                            $sqlsub2 = 'SELECT * FROM tblsub2category WHERE Sub1CategoryID="' . $sub1["Sub1CategoryID"] . '"';
                            $querysub2 = mysqli_query($conn, $sqlsub2);
                            $sub2 = mysqli_fetch_array($querysub2);

                            if (empty($sub2)) {
                                echo '<a href="?lang=KH&Sub1CategoryID=' . $sub1["Sub1CategoryID"] . '"><div class="sub1">' . $i . '. ' . $sub1["Sub1CategoryNameKH"] . '</div></a>';
                            } else {
                                mysqli_data_seek($querysub2, 0);
                                echo '<div class="sub1">' . $i . '. ' . $sub1["Sub1CategoryNameKH"] . '</div>';
                                while ($sub2 = mysqli_fetch_array($querysub2)) {
                                    echo '<a href="?lang=KH&Sub2CategoryID=' . $sub2["Sub2CategoryID"] . '"><div class="sub2">- ' . $sub2["Sub2CategoryNameKH"] . '</div></a>';
                                }
                            }

                            $i++;
                        }
                        echo '</div>';
                    }
                }


                echo '<div class="category">';

                $sqlleft = "SELECT * FROM tblimage WHERE PositionID=3";
                $queryleft = mysqli_query($conn, $sqlleft);
                while ($left = mysqli_fetch_array($queryleft)) {
                    echo '<a href="' . $left["ImageURL"] . '"><img src="images/' . $left["ImageNameEN"] . '" style="width: 100%;" alt=""></a>';
                }

                echo '</div>';

                ?>


            </div>

            <!-- content -->
            <div class="col-lg-6 bg-white">
                <div class="maincontent">

                    <form action="index.php" method="post">
                        <div class="input-group py-3">
                            <input type="text" class="form-control" placeholder="Search articles ..." name="searchtxt" value="<?php if (isset($_GET['search'])) echo $_GET['search'] ?>">
                            <div class="input-group-append">
                                <button class="btn btn-success py-2 px-4" name="search">Search</button>
                            </div>
                            <input type="hidden" name="lang" value="<?php
                                                                    if (!isset($_GET['lang']) || $_GET['lang'] == "EN") echo "EN";
                                                                    else echo "KH";
                                                                    ?>">
                        </div>
                    </form>


                    <?php
                    if (isset($_GET['searchtxt'])) {
                        include_once 'page/searchpage.php';
                    } else if (isset($_GET['ContentDetailSub1ID'])) {
                        include_once 'page/detailsub1page.php';
                    } else if (isset($_GET['ContentDetailSub2ID'])) {
                        include_once 'page/detailsub2page.php';
                    } else if (isset($_GET['Sub2CategoryID'])) {
                        $sql = 'SELECT * FROM tblpagetype INNER JOIN tblsub2category ON tblsub2category.PageTypeID = tblpagetype.PageTypeID WHERE tblsub2category.Sub2CategoryID = ' . $_GET['Sub2CategoryID'];
                        $query = mysqli_query($conn, $sql);
                        $data = mysqli_fetch_array($query);
                        include_once 'page/' . $data["PageType"] . '.php';
                    } else if (isset($_GET['Sub1CategoryID'])) {
                        $sql = 'SELECT * FROM tblpagetype INNER JOIN tblsub1category ON tblsub1category.PageTypeID = tblpagetype.PageTypeID WHERE tblsub1category.Sub1CategoryID = ' . $_GET['Sub1CategoryID'];
                        $query = mysqli_query($conn, $sql);
                        $data = mysqli_fetch_array($query);
                        include_once 'page/' . $data["PageType"] . '.php';
                    } else {
                        include_once 'page/welcome.php';
                    }
                    ?>

                </div>

            </div>

            <!-- right -->
            <div class="col-lg-3 rightmenu">
                <div class="p-2" style="background-color: rgb(223,233,206);">
                    <?php
                    if (!isset($_GET['lang']) || $_GET['lang'] == "EN") {
                        echo '<a href="index.php?lang=KH">';
                    } else {
                        echo '<a href="index.php?lang=EN">';
                    }
                    ?>
                    <img src="images/change_languages.gif" style="width: 100%;" alt="">
                    </a>
                    <a href="https://belteigroup.com.kh/index2.htm">
                        <img src="images/belgroupkh.png" style="width: 100%;" alt="">
                    </a>


                    <?php
                    echo '<div class="category">';

                    $sqlleft = "SELECT * FROM tblimage WHERE PositionID=4";
                    $queryleft = mysqli_query($conn, $sqlleft);
                    while ($left = mysqli_fetch_array($queryleft)) {
                        echo '<a href="' . $left["ImageURL"] . '"><img src="images/' . $left["ImageNameEN"] . '" style="width: 100%;" alt=""></a>';
                    }

                    echo '</div>';
                    ?>

                    <div class="p-3">
                        <?php
                        if (!isset($_GET['lang']) || $_GET['lang'] == "EN") {
                            echo 'Total Viewers: ' . $total;
                        } else {
                            echo 'ចំនួនអ្នកបានចូលមើល: ' . $total;
                        }
                        ?>
                    </div>


                </div>


            </div>
        </div>
    </div>

    <div class="container bg-white py-2" style="border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
        <p style="padding: 10px; background-color: darkgreen; color:white; border-bottom: 5px solid white; margin:0;"><i class="fa-solid fa-forward"></i> BELTEI TOUR & OTHER SERVICES</p>
        <div style="height: 5px; background-color: darkgreen;"></div>

        <div class="row m-1">

            <?php
            $sql = "SELECT * FROM tblimage WHERE PositionID='6'";
            $query = mysqli_query($conn, $sql);
            while ($data = mysqli_fetch_array($query)) {
                echo '<div class="col-lg-6">
                        <img src="images/' . $data["ImageNameKH"] . '" style="width: 100%;" alt="">
                    </div>';
            }
            ?>
        </div>
        <div style="height: 5px; background-color: darkgreen;"></div>
        <div style="height: 20px; background-color: darkgreen; border-top: 5px solid white;"></div>
    </div>
    <div style="height: 100px;"></div>
</body>
