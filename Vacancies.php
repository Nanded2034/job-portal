<?php
require_once '../server/DBConnector.php';
require_once '../server/company.php';

use server\DbConnector;

$dbcon = new DbConnector();

session_start();

// Check if the company session variables are set 
if (!isset($_SESSION['companyID']) || !isset($_SESSION['companyname'])) {
    // Redirect to login if not logged in
    header("Location: ../LoginCompany.php");
    exit;
}

$id = $_SESSION['companyID'];
$companyname = $_SESSION['companyname'];

try {
    $con = $dbcon->getConnection();
    $query = "SELECT companyID, companyname, profilePic FROM company WHERE companyID = ?";
    $pstmt = $con->prepare($query);
    $pstmt->bindValue(1, $id);
    $pstmt->execute();

    $comp = $pstmt->fetchAll(PDO::FETCH_OBJ);

    foreach ($comp as $row) {
        $companyID1 = $row->companyID;
        $companyname1 = $row->companyname;
        $profilePic1 = $row->profilePic;
    }

    if (empty($companyID1)) {
        header("Location: ../LoginCompany.php?error=4");
        exit;
    }

    $profil = ($profilePic1 === null) ? '../../img/userDefault.jpg' : $profilePic1;
} catch (PDOException $exc) {
    echo $exc->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../../img/logo only.png" type="image/x-icon">
    <title>HireSpot | Company</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/maincss.css">
    <style>
        body { background-color: #F1F0F0; overflow-x: hidden; }
        .scrallbar:hover { overflow: auto !important; }
        .fs-0 { font-size: 4rem; }
        .fs-7 { font-size: 0.8rem; }
        .active-quicklink:hover { color: blue !important; }
        .bg-darkgray { background-color: #D9D9D9 !important; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white fixed-top">
        <div class="container">
            <a class="navbar-brand" href="../../index.php">Home</a>
            <div class="justify-content-center">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <img src="../../img/logo.png" width="137px" height="43px" alt="HireSpot" />
                    </li>
                </ul>
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <div type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <a class="navbar-brand dropdown-toggle" href="#" data-bs-toggle="tooltip" data-bs-title="Click here to logout">
                            <img src="<?php echo $profil; ?>" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                            <span class="fw-bold fs-6"><?php echo $companyname1; ?></span>
                        </a>
                    </div>
                    <ul class="dropdown-menu border-0 shadow">
                        <li>
                            <a class="dropdown-item" href="../server/companyLogout.php">
                                <div class="d-flex align-items-center me-2">
                                    <i class="fa fa-sign-out justify-content-center fs-5"></i>
                                    <p class="m-0 ms-2">Log out</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar and Main Content -->
    <div class="row">
        <!-- Sidebar -->
        <div class="col-1 col-lg-2 d-block sidebar">
            <div class="h-100 fixed-top overflow-hidden" style="padding-top: 56px; min-width: 10rem; max-width: 12rem; z-index: 4">
                <!-- Large Navbar -->
                <div class="d-flex flex-column flex-shrink-0 p-3 d-none d-lg-block vh-100 bg-white" style="max-width: 20rem">
                    <a href="../../index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                        <img src="../../img/logo.png" height="43px" alt="HireSpot" />
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="./companyProfile.php" class="nav-link link-body-emphasis">
                                <i class="fa-solid fa-user"></i> Profile
                            </a>
                        </li>
                        <li>
                            <div class="nav-link active" aria-current="page" style="cursor: pointer;">
                                <i class="fa-solid fa-building"></i> Posts
                            </div>
                        </li>
                        <li>
                            <a href="./application.php" class="nav-link link-body-emphasis">
                                <i class="fa-solid fa-address-card"></i> Applications
                            </a>
                        </li>
                    </ul>
                    <hr>
                </div>
                <!-- Small Navbar -->
                <div class="d-flex flex-column flex-shrink-0 bg-white d-lg-none d-block vh-100" style="width: 4.5rem;">
                    <a href="../../index.php" class="d-block p-3 link-body-emphasis text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="HireSpot">
                        <img src="../../img/logo only.png" height="43px" alt="HireSpot" />
                    </a>
                    <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
                        <li class="nav-item">
                            <a href="./companyProfile.php" class="nav-link py-3 border-bottom rounded-0" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Profile">
                                <i class="fa-solid fa-user"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <div class="nav-link active py-3 border-bottom rounded-0" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Posts">
                                <i class="fa-solid fa-building"></i>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="./application.php" class="nav-link py-3 border-bottom rounded-0" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Applications">
                                <i class="fa-solid fa-address-card"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-11 ml-sm-auto col-lg-10 px-4" style="padding-top: 70px; z-index: 5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Company</li>
                    <li class="breadcrumb-item active" aria-current="page">Posts</li>
                </ol>
            </nav>

            <h1>Posts</h1>

            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 1) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Error</strong> in deletion!
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                          </div>";
                } elseif ($_GET['error'] == 2) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Error</strong> in data sending!
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                          </div>";
                } elseif ($_GET['error'] == 3) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            You can't leave a <strong>empty</strong> field!
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                          </div>";
                }
            }

            if (isset($_GET['success'])) {
                if ($_GET['success'] == 1) {
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            Post <strong>deleted</strong> successfully.
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                          </div>";
                } elseif ($_GET['success'] == 2) {
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            Post <strong>changed</strong> successfully.
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                          </div>";
                }
            }
            ?>

            <table class="table table-hover bg-white rounded">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Date</th>
                        <th scope="col">Category</th>
                        <th scope="col" class="text-center">Receive Applications</th>
                        <th scope="col" class="text-center">Edit</th>
                        <th scope="col" class="text-center">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM company JOIN job ON company.companyID = job.companyID WHERE company.companyID = ?";
                    $pstmt1 = $con->prepare($query);
                    $pstmt1->bindValue(1, $id);
                    $pstmt1->execute();
                    $rs = $pstmt1->fetchAll(PDO::FETCH_OBJ);

                    if (empty($rs)) {
                        echo "<tr><td colspan='7' class='text-center'>No posts available.</td></tr>";
                    } else {
                        foreach ($rs as $row) {
                            $jobID = $row->jobID;
                            $jobTitle = $row->jobTitle;
                            $jobCategory = $row->jobcateogory;
                            $date = $row->date;
                            $content = l2br(htmlspecialchars($row->content));
                            $imageFilePath = $row->filePath;
                            ?>
                            <tr>
                                <th scope="row"><?php echo $jobID; ?></th>
                                <td><?php echo $jobTitle; ?></td>
                                <td><?php echo $date; ?></td>
                                <td><?php echo $jobCategory; ?></td>
                                <td class="text-center">
                                    <form action="./application.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $jobID; ?>">
                                        <button type="submit" class="btn btn-primary mx-1 p-1">View Applications</button>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-success m-0" data-bs-toggle="modal" data-bs-target="#postModal<?php echo $jobID; ?>">
                                        Edit Post <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <a href="../server/deletepost.php?id=<?php echo $jobID . "&compid=" . $companyID1; ?>">
                                        <button class="btn btn-danger mx-1 p-1">Delete <i class="fa-solid fa-trash ms-1"></i></button>
                                    </a>
                                </td>
                            </tr>

                            <!-- Edit Post Modal -->
                            <!-- Edit Post Modal -->
<form action="../server/editePost.php" method="post" enctype="multipart/form-data">
    <div class="modal fade shadow my-5" id="postModal<?php echo $jobID; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Job Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="jobID" value="<?php echo $jobID; ?>">
                    <input type="hidden" name="companyID" value="<?php echo $companyID1; ?>">
                    <div class="form-floating my-3">
                        <input type="text" name="jobTitle" class="form-control" id="floatingInput" value="<?php echo $jobTitle; ?>">
                        <label for="floatingInput">Job Title</label>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect01">Job Category</label>
                        <select class="form-select" id="inputGroupSelect01" name="jobCategory">
                            <option selected><?php echo $jobCategory; ?></option>
                            <option value="Information Technology (IT)">Information Technology (IT)</option>
                            <option value="Healthcare">Healthcare</option>
                            <option value="Finance">Finance</option>
                            <option value="Education">Education</option>
                            <option value="Marketing and Sales">Marketing and Sales</option>
                            <option value="Engineering">Engineering</option>
                            <option value="Hospitality and Tourism">Hospitality and Tourism</option>
                            <option value="Creative Arts">Creative Arts</option>
                            <option value="Human Resources">Human Resources</option>
                            <option value="Construction and Trades">Construction and Trades</option>
                        </select>
                    </div>
                    <div class="form-floating">
                        <textarea class="form-control" name="description" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"><?php echo nl2br(htmlspecialchars($content)); ?></textarea>
                        <label for="floatingTextarea2">Description about the job</label>
                    </div>
                    <div class="mb-1">
                        <label for="formFile" class="form-label fs-5 my-2">Uploaded Flyer</label>
                        <img id="previewImage" src="<?php echo $imageFilePath; ?>" alt="Selected Image" style="object-fit: cover" class="img-fluid my-2">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100" name="submit">Change</button>
                </div>
            </div>
        </div>
    </div>
</form>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    </script>
</body>
</html>