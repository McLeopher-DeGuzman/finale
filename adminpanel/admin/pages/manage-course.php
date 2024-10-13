<?php
// Set page number or default to 1
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
$stmt = $conn->query("SELECT COUNT(*) as total_records FROM course_tbl");
$records = $stmt->fetch(PDO::FETCH_ASSOC);
$total_records = $records['total_records'];

$total_no_of_pages = ceil($total_records / $total_records_per_page);

// Fetch course data
$sql = "SELECT * FROM course_tbl LIMIT $offset, $total_records_per_page";
$stmt = $conn->query($sql);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Strand with Pagination</title>
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
                        <div>MANAGE STRAND</div>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <button class="btn btn-success" data-toggle="modal" data-target="#modalForAddCourse" style="margin-left: 2%;">
                    <i class="fas fa-plus-circle"></i> Add Strand
                </button>
            </div>
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">Strand List</div>
                    <div class="table-responsive">
                        <table id="tableList" class="align-middle mb-0 table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-left pl-4">Strand Name</th>
                                    <th class="text-center" width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(count($courses) > 0) {
                                    foreach ($courses as $course) { ?>
                                        <tr>
                                            <td class="pl-4">
                                                <?php echo htmlspecialchars($course['cou_name']); ?>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-primary btn-sm" href="facebox_modal/updateCourse.php?id=<?php echo htmlspecialchars($course['cou_id']); ?>">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" data-id="<?php echo htmlspecialchars($course['cou_id']); ?>" id="deleteCourse">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="2">
                                            <h3 class="p-3">No Strand Found</h3>
                                        </td>
                                    </tr>
                                <?php } ?>
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
                                    <a class="page-link" href="<?= ($page_no > 1) ? '?page=manage-course&page_no=' . $previous_page : '#'; ?>">Previous</a>
                                </li>

                                <!-- Page Number Links -->
                                <?php for ($i = 1; $i <= $total_no_of_pages; $i++) { ?>
                                    <li class="page-item <?= ($i == $page_no) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=manage-course&page_no=<?= $i; ?>"><?= $i; ?></a>
                                    </li>
                                <?php } ?>

                                <!-- Next Page Link -->
                                <li class="page-item <?= ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="<?= ($page_no < $total_no_of_pages) ? '?page=manage-course&page_no=' . $next_page : '#'; ?>">Next</a>
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
