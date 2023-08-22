<?php

include_once '../db.php';

// insert
if (isset($_POST['insert'])) {
    $ContentSub1NameKH = $_POST['ContentSub1NameKH'];
    $ContentSub1NameEN = $_POST['ContentSub1NameEN'];
    $Sub1CategoryID = $_POST['Sub1CategoryID'];

    $ContentSub1Image = "";
    if (move_uploaded_file($_FILES["ContentSub1Image"]["tmp_name"], "../ContentSub1Image/" . date("Ymdhis") . $_FILES["ContentSub1Image"]["name"])) {
        $ContentSub1Image = date("Ymdhis") . $_FILES["ContentSub1Image"]["name"];
    }

    $sql = "INSERT INTO `tblcontentsub1`(`ContentSub1NameKH`,`ContentSub1NameEN`,`Sub1CategoryID`,`ContentSub1Image`)
     VALUES ('$ContentSub1NameKH','$ContentSub1NameEN','$Sub1CategoryID','$ContentSub1Image')";

    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("New record has been added successfully !")</script>';
    } else {
        echo "Error: " . $sql . ":-" . mysqli_error($conn);
    }
}

// search
if (isset($_POST['search'])) {
    $ContentSub1ID = $_POST['ContentSub1ID'];

    $sql = "select * from tblcontentsub1 Where ContentSub1ID=$ContentSub1ID";

    $query = mysqli_query($conn, $sql);

    while ($data = mysqli_fetch_array($query)) {
        header("location:contentsub1.php?ContentSub1ID=" . $data['ContentSub1ID'] . "&Sub1CategoryID=" . $data['Sub1CategoryID'] . "&ContentSub1Image=" . $data['ContentSub1Image']);
    }
}

// update
if (isset($_POST['update'])) {
    $ContentSub1ID = $_POST['ContentSub1ID'];
    $ContentSub1NameKH = $_POST['ContentSub1NameKH'];
    $ContentSub1NameEN = $_POST['ContentSub1NameEN'];
    $Sub1CategoryID = $_POST['Sub1CategoryID'];

    $txtContentSub1Image = $_POST['txtContentSub1Image'];

    if (move_uploaded_file($_FILES["ContentSub1Image"]["tmp_name"], "../ContentSub1Image/" . date("Ymdhis") . $_FILES["ContentSub1Image"]["name"])) {
        $ContentSub1Image = date("Ymdhis") . $_FILES["ContentSub1Image"]["name"];
    } else {
        $ContentSub1Image = $txtContentSub1Image;
    }

    $sql = "Update tblcontentsub1 SET `ContentSub1NameKH`='$ContentSub1NameKH',`ContentSub1NameEN`='$ContentSub1NameEN',`Sub1CategoryID`='$Sub1CategoryID',`ContentSub1Image`='$ContentSub1Image' Where ContentSub1ID='$ContentSub1ID'";

    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Updated record has been added successfully !")</script>';
    } else {
        echo "Error: " . $sql . ":-" . mysqli_error($conn);
    }
}

//delete
if (isset($_POST['delete'])) {

    $ContentSub1ID = $_POST['ContentSub1ID'];

    $sql = "delete from tblcontentsub1  Where ContentSub1ID='$ContentSub1ID'";

    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Delete record has been added successfully !")</script>';
    } else {
        echo "Error: " . $sql . ":-" . mysqli_error($conn);
    }
}


?>
<!--  form -->
<?php
include("header.php");
?>
<div class="container bg-white">
    <div class="container">
        <div class="row p-3">
            <h1>Sub1 Content Form</h1>
            <form style="width:100%" action="contentsub1.php" method="POST" enctype="multipart/form-data">

                <div class="row my-4">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Enter ContentSub1ID : </label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="" name="ContentSub1ID" value="<?php if (!empty($_GET)) echo $_GET['ContentSub1ID'] ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-success py-2 px-4" name="search">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-6">
                        <label>Sub1 Category</label>
                        <select name='Sub1CategoryID' class="form-control mb-2 p-2">
                            <?php
                            include_once 'option_sub1category.php';
                            foreach ($options as $option) {
                            ?>
                                <option value="<?php echo $option['Sub1CategoryID']; ?>" <?php if (!empty($_GET)) {
                                                                                                if ($_GET['Sub1CategoryID'] == $option['Sub1CategoryID']) echo "selected";
                                                                                            }
                                                                                            ?>>
                                    <?php echo $option['Sub1CategoryNameEN']; ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label>ContentSub1Image</label>
                        <div class="input-group mb-2">
                            <input class="form-control p-2" type="file" placeholder="ContentSub1Image" name="ContentSub1Image" id="img-input">
                            <div class="input-group-append p-2 border">
                                <a href="../ContentSub1Image/<?php if (!empty($_GET)) echo $_GET['ContentSub1Image'] ?>" target="_blank">
                                    <img src="../ContentSub1Image/<?php if (!empty($_GET)) echo $_GET['ContentSub1Image'] ?>" alt="" style="max-height: 100px;" id="img-preview">
                                </a>
                            </div>
                        </div>
                        <input type="text" style="display:none;" value="<?php if (!empty($_GET)) echo $_GET['ContentSub1Image'] ?>" name="txtContentSub1Image">
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <label>ContentSub1NameEN</label>
                        <?php
                        $ContentSub1NameEN = "";
                        if (!empty($_GET)) {
                            $sql = "select * from tblcontentsub1 Where ContentSub1ID='" . $_GET['ContentSub1ID'] . "'";
                            $query = mysqli_query($conn, $sql);
                            while ($data = mysqli_fetch_array($query)) {
                                $ContentSub1NameEN = $data['ContentSub1NameEN'];
                            }
                        }
                        echo '<textarea class="form-control mb-2 p-2" type="text" placeholder="ContentSub1NameEN" rows="4" name="ContentSub1NameEN">' . $ContentSub1NameEN . '</textarea>';
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <label>ContentSub1NameKH</label>
                        <?php
                        $ContentSub1NameKH = "";
                        if (!empty($_GET)) {
                            $sql = "select * from tblcontentsub1 Where ContentSub1ID='" . $_GET['ContentSub1ID'] . "'";
                            $query = mysqli_query($conn, $sql);
                            while ($data = mysqli_fetch_array($query)) {
                                $ContentSub1NameKH = $data['ContentSub1NameKH'];
                            }
                        }
                        echo '<textarea class="form-control mb-2 p-2" type="text" placeholder="ContentSub1NameKH" rows="4" name="ContentSub1NameKH">' . $ContentSub1NameKH . '</textarea>';
                        ?>
                    </div>
                </div>

                <div class="row my-4">
                    <div class="col-lg-12" style="display:flex">
                        <button class="btn btn-primary btn-block p-2 m-1" name="insert">Insert</button>
                        <button class="btn btn-warning btn-block p-2 m-1" name="update">Update</button>
                        <button class="btn btn-danger btn-block p-2 m-1" name="delete">Delete</button>
                    </div>
                </div>

            </form>
        </div>
        <h3 class="pt-3">Content Sub1 Table</h3>
    </div>

    <div class="container" style="overflow: scroll; max-height: 500px">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ContentSub1ID</th>
                    <th>ContentSub1NameKH</th>
                    <th>ContentSub1NameEN</th>
                    <th>Sub1CategoryID</th>
                    <th style="min-width: 100px;">ContentSub1Image</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM tblcontentsub1";
                $query = mysqli_query($conn, $sql);

                while ($data = mysqli_fetch_array($query)) {
                    echo "<tr>";
                    echo "<td>" . $data['ContentSub1ID'] . "</td>";
                    echo "<td>" . $data['ContentSub1NameKH'] . "</td>";
                    echo "<td>" . $data['ContentSub1NameEN'] . "</td>";
                    echo "<td>" . $data['Sub1CategoryID'] . "</td>";
                    echo "<td><a href='../ContentSub1Image/" . $data['ContentSub1Image'] . "' target='_blank'><img src='../ContentSub1Image/" . $data['ContentSub1Image'] . "' style='max-width:100px'></a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Get the input and image elements
    const input = document.getElementById('img-input');
    const img = document.getElementById('img-preview');

    // Add an event listener to the input
    input.addEventListener('change', function() {

        // Get the selected image
        const file = input.files[0];

        // Create a new FileReader object
        const reader = new FileReader();

        // Read the image data from the file
        reader.readAsDataURL(file);

        // When the image data is loaded, set the image src
        reader.onload = function() {
            img.src = reader.result;
        };
    });
</script>
