<?php
if (isset($_GET['page_no']) && $_GET['page_no'] !== "") {
    $page_no = (int)$_GET['page_no'];
} else {
    $page_no = 1;
}

$total_records_per_page = 10;
$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;

// Get total record count using PDO
$stmt = $conn->query("SELECT COUNT(*) as total_records FROM examinee_tbl");
$records = $stmt->fetch(PDO::FETCH_ASSOC);
$total_records = $records['total_records'];

$total_no_of_pages = ceil($total_records / $total_records_per_page);

// Fetch examinee data
$sql = "SELECT * FROM examinee_tbl LIMIT $offset, $total_records_per_page";
$stmt = $conn->query($sql);
$examinees = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Examinee with Pagination</title>
    <link rel="stylesheet" type="text/css" href="css/mycss.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .pagination-info {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div>MANAGE EXAMINEE</div>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <button class="btn btn-success" data-toggle="modal" data-target="#modalForAddExaminee" style="margin-left: 2%;">
                    <i class="fas fa-plus-circle"></i> Add Examinee
                </button>
            </div>
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">Examinee List</div>
                    <div class="table-responsive">
                        <table id="tableList" class="align-middle mb-0 table table-striped table-bordered dataTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>Birthdate</th>
                                    <th>Strand</th>
                                    <th>Year level</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if (count($examinees) > 0) {
                                    foreach ($examinees as $selExmneRow) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($selExmneRow['exmne_fullname']); ?></td>
                                            <td><?php echo htmlspecialchars($selExmneRow['exmne_gender']); ?></td>
                                            <td><?php echo htmlspecialchars($selExmneRow['exmne_birthdate']); ?></td>
                                            <td>
                                                <?php
                                                    $exmneCourse = $selExmneRow['exmne_course'];
                                                    $selCourse = $conn->query("SELECT * FROM course_tbl WHERE cou_id='$exmneCourse'")->fetch(PDO::FETCH_ASSOC);
                                                    echo htmlspecialchars($selCourse['cou_name']);
                                                ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($selExmneRow['exmne_year_level']); ?></td>
                                            <td><?php echo htmlspecialchars($selExmneRow['exmne_email']); ?></td>
                                            <td><?php echo htmlspecialchars(md5($selExmneRow['exmne_password'])); ?></td>
                                            <td><?php echo htmlspecialchars($selExmneRow['exmne_status']); ?></td>
                                            <td>
                                                <a rel="facebox" href="facebox_modal/updateExaminee.php?id=<?php echo htmlspecialchars($selExmneRow['exmne_id']); ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> 
                                                </a>
                                                <button type="button" id="deleteExaminee" data-id='<?php echo htmlspecialchars($selExmneRow['exmne_id']); ?>' class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> 
                                                </button>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="9">
                                            <h3 class="p-3">No Examinee Found</h3>
                                        </td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination and Info Section -->
                    <div class="pagination-container">
                        <!-- Page Info Display (Left) -->
                        <div class="pagination-info">
                            <strong>Page <?= $page_no; ?> of <?= $total_no_of_pages; ?></strong>
                        </div>

                        <!-- Pagination Links (Right) -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end">
                                <!-- Previous Page Link -->
                                <li class="page-item <?= ($page_no <= 1) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="<?= ($page_no > 1) ? '?page=manage-examinee&page_no=' . $previous_page : '#'; ?>">Previous</a>
                                </li>

                                <!-- Page Number Links -->
                                <?php for ($i = 1; $i <= $total_no_of_pages; $i++) { ?>
                                    <li class="page-item <?= ($i == $page_no) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=manage-examinee&page_no=<?= $i; ?>"><?= $i; ?></a>
                                    </li>
                                <?php } ?>

                                <!-- Next Page Link -->
                                <li class="page-item <?= ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="<?= ($page_no < $total_no_of_pages) ? '?page=manage-examinee&page_no=' . $next_page : '#'; ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
