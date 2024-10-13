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
    <title>Examinee Result</title>
    <link rel="stylesheet" type="text/css" href="css/mycss.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div>EXAMINEE RESULT</div>
                    </div>
                </div>
            </div>        

            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">Examinee Result</div>
                    <div class="table-responsive">
                        <table id="tableList" class="align-middle mb-0 table table-striped table-bordered dataTable w-full">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Exam Name</th>
                                    <th>Scores</th>
                                    <th>Ratings</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $selExmne = $conn->query("SELECT * FROM examinee_tbl et INNER JOIN exam_attempt ea ON et.exmne_id = ea.exmne_id ORDER BY ea.examat_id DESC ");
                                if($selExmne->rowCount() > 0) {
                                    while ($selExmneRow = $selExmne->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <tr>
                                           <td><?php echo $selExmneRow['exmne_fullname']; ?></td>
                                           <td>
                                             <?php 
                                                $eid = $selExmneRow['exmne_id'];
                                                $selExName = $conn->query("SELECT * FROM exam_tbl et INNER JOIN exam_attempt ea ON et.ex_id=ea.exam_id WHERE  ea.exmne_id='$eid' ")->fetch(PDO::FETCH_ASSOC);
                                                $exam_id = $selExName['ex_id'];
                                                echo $selExName['ex_title'];
                                              ?>
                                           </td>
                                           <td>
                                                    <?php 
                                                    $selScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND eqt.exam_answer = ea.exans_answer  WHERE ea.axmne_id='$eid' AND ea.exam_id='$exam_id' AND ea.exans_status='new' ");
                                                      ?>
                                                <span>
                                                    <?php echo $selScore->rowCount(); ?>
                                                    <?php 
                                                        $over  = $selExName['ex_questlimit_display'];
                                                     ?>
                                                </span> / <?php echo $over; ?>
                                           </td>
                                           <td>
                                              <?php 
                                                    $selScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND eqt.exam_answer = ea.exans_answer  WHERE ea.axmne_id='$eid' AND ea.exam_id='$exam_id' AND ea.exans_status='new' ");
                                                ?>
                                                <span>
                                                    <?php 
                                                        $score = $selScore->rowCount();
                                                        $ans = $score / $over * 100;
                                                        echo number_format($ans,2);
                                                        echo "%";
                                                        
                                                     ?>
                                                </span> 
                                           </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                      <td colspan="4" class="text-center">
                                        <h3 class="p-3">No Results Found</h3>
                                      </td>
                                    </tr>
                                <?php }
                               ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination and Info Section -->
<div class="d-flex justify-content-between align-items-center mt-4">
    <!-- Page Info Display (Left) -->
    <div class="pagination-info">
        <strong>Page <?= $page_no; ?> of <?= $total_no_of_pages; ?></strong>
    </div>

    <!-- Pagination Links (Right) -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end">
            <!-- Previous Page Link -->
            <li class="page-item <?= ($page_no <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?= ($page_no > 1) ? '?page=examinee-result&page_no=' . $previous_page : '#'; ?>">Previous</a>
            </li>

            <!-- Page Number Links -->
            <?php for ($i = 1; $i <= $total_no_of_pages; $i++) { ?>
                <li class="page-item <?= ($i == $page_no) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=examinee-result&page_no=<?= $i; ?>"><?= $i; ?></a>
                </li>
            <?php } ?>

            <!-- Next Page Link -->
            <li class="page-item <?= ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?= ($page_no < $total_no_of_pages) ? '?page=examinee-result&page_no=' . $next_page : '#'; ?>">Next</a>
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
