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

// Get total record count using a prepared statement
$stmt = $conn->prepare("SELECT COUNT(*) as total_records FROM exam_tbl");
$stmt->execute();
$records = $stmt->fetch(PDO::FETCH_ASSOC);
$total_records = $records['total_records'];

$total_no_of_pages = ceil($total_records / $total_records_per_page);

// Fetch course data using a prepared statement
$sql = "SELECT * FROM exam_tbl LIMIT :offset, :total_records_per_page";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':total_records_per_page', $total_records_per_page, PDO::PARAM_INT);
$stmt->execute();
$exams = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking Yearly</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" type="text/css" href="css/mycss.css">
</head>
<body>
<div class="app-main__outer">
    <div class="app-main__inner">
        <?php 
        @$exam_id = $_GET['exam_id'];

        if($exam_id != "") {
            $selEx = $conn->query("SELECT * FROM exam_tbl WHERE ex_id='$exam_id'")->fetch(PDO::FETCH_ASSOC);
            $exam_course = $selEx['cou_id'];

            $selExmne = $conn->query("SELECT * FROM examinee_tbl et WHERE exmne_course='$exam_course'");

            ?>
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div><b class="text-primary">RANKING BY EXAM</b><br>
                            Exam Name: <?php echo $selEx['ex_title']; ?><br><br>
                            <span class="border p-2 text-black bg-yellow-400">Excellence</span>
                            <span class="border p-2 text-white bg-green-500">Very Good</span>
                            <span class="border p-2 text-white bg-blue-500">Good</span>
                            <span class="border p-2 text-white bg-red-500">Failed</span>
                            <span class="border p-2 text-black bg-gray-300">Not Answering</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tableList" class="align-middle mb-0 table table-striped table-bordered dataTable">
                    <thead>
                        <tr>
                            <th>Examinee Full Name</th>
                            <th>Score / Over</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    while ($selExmneRow = $selExmne->fetch(PDO::FETCH_ASSOC)) {
                        $exmneId = $selExmneRow['exmne_id'];
                        $selScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND eqt.exam_answer = ea.exans_answer WHERE ea.axmne_id='$exmneId' AND ea.exam_id='$exam_id' AND ea.exans_status='new'");
                        
                        $selAttempt = $conn->query("SELECT * FROM exam_attempt WHERE exmne_id='$exmneId' AND exam_id='$exam_id'");
                        $over = $selEx['ex_questlimit_display'];
                        $score = $selScore->rowCount();
                        $percentage = ($score / $over) * 100;

                        $rowColor = "bg-gray-300 text-black";
                        if ($selAttempt->rowCount() == 0) {
                            $rowColor = "bg-gray-300 text-black";
                        } else if ($percentage >= 90) {
                            $rowColor = "bg-yellow-400 text-black";
                        } else if ($percentage >= 70) {
                            $rowColor = "bg-green-500 text-white";
                        } else if ($percentage >= 40) {
                            $rowColor = "bg-blue-500 text-white";
                        } else {
                            $rowColor = "bg-red-500 text-white";
                        }
                        ?>
                        <tr class="<?php echo $rowColor; ?>">
                            <td><?php echo $selExmneRow['exmne_fullname']; ?></td>
                            <td>
                                <?php 
                                if ($selAttempt->rowCount() == 0) {
                                    echo "Not answered yet";
                                } else {
                                    echo $score . " / " . $over;
                                }
                                ?>
                            </td>
                            <td><?php echo $selAttempt->rowCount() == 0 ? "Not answered yet" : number_format($percentage, 2) . '%'; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php
        } else { ?>
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div><b>RANKING BY EXAM</b></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">Exam List</div>
                    <div class="table-responsive">
                        <table id="tableList" class="align-middle mb-0 table table-striped table-bordered dataTable">
                            <thead>
                                <tr>
                                    <th>Exam Title</th>
                                    <th>Strand</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $selExam = $conn->query("SELECT * FROM exam_tbl ORDER BY ex_id DESC LIMIT $offset, $total_records_per_page");
                            if ($selExam->rowCount() > 0) {
                                while ($selExamRow = $selExam->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <td><?php echo $selExamRow['ex_title']; ?></td>
                                        <td><?php 
                                            $courseId = $selExamRow['cou_id']; 
                                            $selCourse = $conn->query("SELECT * FROM course_tbl WHERE cou_id='$courseId'");
                                            while ($selCourseRow = $selCourse->fetch(PDO::FETCH_ASSOC)) {
                                                echo $selCourseRow['cou_name'];
                                            }
                                        ?></td>
                                        <td><?php echo $selExamRow['ex_description']; ?></td>
                                        <td><a href="?page=ranking-exam&exam_id=<?php echo $selExamRow['ex_id']; ?>" class="btn btn-success btn-sm">View</a></td>
                                        <td><?php echo $selExamRow['ex_created']; ?></td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="5"><h3 class="p-3">No Exam Found</h3></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Pagination and Info Section -->
        <div class="pagination-container">
            <div class="pagination-info">
                <strong>Page <?= $page_no; ?> of <?= $total_no_of_pages; ?></strong>
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <!-- Previous Page Link -->
                    <li class="page-item <?= ($page_no <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?= ($page_no > 1) ? '?page=ranking-exam&page_no=' . $previous_page : '#'; ?>">Previous</a>
                    </li>

                    <!-- Page Number Links -->
                    <?php for ($i = 1; $i <= $total_no_of_pages; $i++) { ?>
                        <li class="page-item <?= ($i == $page_no) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=ranking-exam&page_no=<?= $i; ?>"><?= $i; ?></a>
                        </li>
                    <?php } ?>

                    <!-- Next Page Link -->
                    <li class="page-item <?= ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?= ($page_no < $total_no_of_pages) ? '?page=ranking-exam&page_no=' . $next_page : '#'; ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
</body>
</html>
