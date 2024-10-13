<?php
// Set the page number or default to 1
if (isset($_GET['page_no']) && $_GET['page_no'] !== "") {
    $page_no = (int)$_GET['page_no'];
} else {
    $page_no = 1;
}

$total_records_per_page = 10;
$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;

// Prepare the base query for counting the total records
$baseQuery = "SELECT COUNT(*) as total_records FROM examinee_tbl INNER JOIN exam_attempt ON examinee_tbl.exmne_id = exam_attempt.exmne_id ";

// Check if there is a search query and adjust the query
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $baseQuery .= "WHERE exmne_fullname LIKE :search ";
}

// Prepare and execute the total records query
$stmt = $conn->prepare($baseQuery);
if (isset($search)) {
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
}
$stmt->execute();
$records = $stmt->fetch(PDO::FETCH_ASSOC);
$total_records = $records['total_records'];

// Calculate total pages
$total_no_of_pages = ceil($total_records / $total_records_per_page);

// Now prepare the query to fetch examinee data with pagination
$query = "SELECT * FROM examinee_tbl 
          INNER JOIN exam_attempt ON examinee_tbl.exmne_id = exam_attempt.exmne_id ";

// Add search condition if available
if (isset($search)) {
    $query .= "WHERE exmne_fullname LIKE :search ";
}

$query .= "ORDER BY exam_attempt.examat_id LIMIT :offset, :total_records_per_page";

// Prepare and execute the examinee data query
$stmt = $conn->prepare($query);
if (isset($search)) {
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
}
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':total_records_per_page', $total_records_per_page, PDO::PARAM_INT);
$stmt->execute();
$examinees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Examinee with Pagination and Search</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <?php 
                // Display specific examinee's answers if the exam ID is set
                @$examId = $_GET['id'];
                if ($examId != "") {
                    $selExam = $conn->query("SELECT * FROM exam_tbl WHERE ex_id='$examId' ")->fetch(PDO::FETCH_ASSOC);
                    $exmneId = $_SESSION['examineeSession']['exmne_id'];
                    $selQuest = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id WHERE eqt.exam_id='$examId' AND ea.axmne_id='$exmneId' AND ea.exans_status='new' ");
            ?>
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div><b class="text-primary">ANSWER OF THE STUDENT</b></div>
                    </div>
                </div>
            </div>
            <div class="row col-md-6 float-left">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Your Answers</h5>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Question</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Answer</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php 
                                    $i = 1;
                                    $maxItems = 81;
                                    while ($selQuestRow = $selQuest->fetch(PDO::FETCH_ASSOC)) { 
                                        if ($i >= $maxItems) {
                                            break;
                                        }
                                ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $i++; ?> .) <?php echo $selQuestRow['exam_question']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php 
                                            if ($selQuestRow['exam_answer'] != $selQuestRow['exans_answer']) {
                                        ?>
                                        <span class="text-red-500"><?php echo $selQuestRow['exans_answer']; ?></span>
                                        <?php } else { ?>
                                        <span class="text-green-500"><?php echo $selQuestRow['exans_answer']; ?></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php } else { ?>
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div>EXAMINEE ANALYSIS</div>
                    </div>
                </div>
            </div> 
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header flex items-center justify-between">
                        EXAMINEE LIST
                        <form method="GET" class="flex items-center space-x-2">
                            <input type="hidden" name="page" value="result">
                            <input type="text" name="search" placeholder="Search by name" class="form-input border-gray-300 rounded-md shadow-sm">
                            <button type="submit" class="btn btn-primary btn-sm px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-md shadow-sm">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Strand</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" width="8%">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php 
                                    // Display the examinee records
                                    if ($stmt->rowCount() > 0) {
                                        foreach ($examinees as $examinee) { ?>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap"><?php echo $examinee['exmne_fullname']; ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <?php 
                                                        $exmneCourse = $examinee['exmne_course'];
                                                        $selCourse = $conn->query("SELECT * FROM course_tbl WHERE cou_id='$exmneCourse' ")->fetch(PDO::FETCH_ASSOC);
                                                        echo $selCourse['cou_name'];
                                                    ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <a href="?page=result&id=<?php echo $examinee['exam_id'];?>" class="btn btn-success btn-sm px-4 py-2 text-white bg-green-500 hover:bg-green-600 rounded-md shadow-sm">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-center">
                                                <h3 class="text-lg text-gray-700">No Examinee Found</h3>
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
                                    <a class="page-link" href="<?= ($page_no > 1) ? '?page=result&page_no=' . $previous_page . '&search=' . (isset($search) ? $search : '') : '#'; ?>">Previous</a>
                                </li>

                                <!-- Page Number Links -->
                                <?php for ($i = 1; $i <= $total_no_of_pages; $i++) { ?>
                                    <li class="page-item <?= ($i == $page_no) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=result&page_no=<?= $i; ?>&search=<?= isset($search) ? $search : ''; ?>"><?= $i; ?></a>
                                    </li>
                                <?php } ?>

                                <!-- Next Page Link -->
                                <li class="page-item <?= ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="<?= ($page_no < $total_no_of_pages) ? '?page=result&page_no=' . $next_page . '&search=' . (isset($search) ? $search : '') : '#'; ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <?php } ?>     
        </div>
    </div>
</body>
</html>
