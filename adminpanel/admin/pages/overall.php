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
    <title>Overall Result</title>
    <link rel="stylesheet" type="text/css" href="css/mycss.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div>OVERALL RESULT</div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">OVERALL RESULTS</div>
                    <div class="text-right">
                        <button class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none"
                                onclick="printTable();">
                            <i class="fa fa-print mr-2"></i>Print Entire Table
                        </button>
                    </div>

                    <div class="table-responsive mt-3">
                        <table id="tableList" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Exam Name</th>
                                    <th>Scores</th>
                                    <th>Overall (%)</th>
                                    <th>Course Recommendation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $selExmne = $conn->query("SELECT * FROM examinee_tbl et INNER JOIN exam_attempt ea ON et.exmne_id = ea.exmne_id ORDER BY ea.examat_id DESC ");
                                if($selExmne->rowCount() > 0) {
                                    while ($selExmneRow = $selExmne->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <tr>
                                            <td><?= $selExmneRow['exmne_fullname']; ?></td>
                                            <td>
                                                <?php 
                                                $eid = $selExmneRow['exmne_id'];
                                                $selExName = $conn->query("SELECT * FROM exam_tbl et INNER JOIN exam_attempt ea ON et.ex_id = ea.exam_id WHERE ea.exmne_id = '$eid' ")->fetch(PDO::FETCH_ASSOC);
                                                $exam_id = $selExName['ex_id'];
                                                echo $selExName['ex_title'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $selScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND eqt.exam_answer = ea.exans_answer WHERE ea.axmne_id = '$eid' AND ea.exam_id = '$exam_id' AND ea.exans_status = 'new' ");
                                                ?>
                                                <span>
                                                    <?= $selScore->rowCount(); ?>
                                                    <?php 
                                                        $over  = $selExName['ex_questlimit_display'];
                                                    ?>
                                                </span> / <?= $over; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $score = $selScore->rowCount();
                                                $ans = ($score / $over) * 100;
                                                $formattedAns = number_format($ans, 2);
                                                echo $formattedAns . "%";

                                                // Course recommendation logic
                                                if ($formattedAns >= 90.00) {
                                                    $courseRecommendation = "Architecture, Engineering";
                                                } elseif ($formattedAns >= 80.00) {
                                                    $courseRecommendation = "Tourism, Hospitality Management";
                                                } elseif ($formattedAns >= 70.00) {
                                                    $courseRecommendation = "Nursing, Pharmacy";
                                                } elseif ($formattedAns >= 60.00) {
                                                    $courseRecommendation = "Education (Secondary, Elementary)";
                                                } elseif ($formattedAns >= 40.00) {
                                                    $courseRecommendation = "IT, Computer Science";
                                                } else {
                                                    $courseRecommendation = "Unknown";
                                                }
                                                ?>
                                            </td>
                                            <td><?= $courseRecommendation; ?></td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <h3 class="p-3">No Results Found</h3>
                                        </td>
                                    </tr>
                                <?php } ?>
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
                                    <a class="page-link" href="<?= ($page_no > 1) ? '?page=overall&page_no=' . $previous_page : '#'; ?>">Previous</a>
                                </li>

                                <!-- Page Number Links -->
                                <?php for ($i = 1; $i <= $total_no_of_pages; $i++) { ?>
                                    <li class="page-item <?= ($i == $page_no) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=overall&page_no=<?= $i; ?>"><?= $i; ?></a>
                                    </li>
                                <?php } ?>

                                <!-- Next Page Link -->
                                <li class="page-item <?= ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="<?= ($page_no < $total_no_of_pages) ? '?page=overall&page_no=' . $next_page : '#'; ?>">Next</a>
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

    <script>
        function printTable() {
            var printWindow = window.open('', '_blank');
            var tableContent = document.getElementById("tableList").outerHTML;

            var currentDate = new Date();
            var formattedDate = currentDate.toLocaleDateString();
            var formattedTime = currentDate.toLocaleTimeString();

            var headerContent = `
        <div style="text-align: center;">
            <div style="display: flex; justify-content: center; align-items: center;">
                <div style="flex: 1;">
                    <img src="./login-ui/images/UCS-removebg-preview.png" alt="Left Logo" class="left-logo" style="width:100px;">
                </div>
                <div style="flex: 3;">
                    <div class="title">Archdiocese of Lingayen Dagupan Catholic Schools</div>
                    <div class="title">URBIZTONDO CATHOLIC SCHOOL, INC.</div>
                    <div class="title">Contact No. (075. 540-1712 / 0923-086-2353)</div>
                    <div class="title">Urbiztondo Catholic School-ALDCS @ucsaldcs</div>
                    <div class="title">SENIOR HIGH SCHOOL DEPARTMENT</div>
                    <br>
                    <div class="subtitle">Date: ${formattedDate}        Time: ${formattedTime}</div>
                </div>
                <div style="flex: 1;">
                    <img src="./login-ui/images/al.png" alt="Right Logo" class="right-logo" style="width:100px;">
                </div>
            </div>
        </div>
    `;

            var footerContent = `
                <div style="margin-top: 20px;">
                    <div class="subtitle">Thank you for using our service!</div>
                </div>
            `;

            var printContent = `
            <html>
                <head>
                    <title></title>
                    <link rel = "shortcut icon" href = "../../login-ui/images/UCS-removebg-preview.png">
                    <link rel="stylesheet" type="text/css" href="css/mycss.css">
                    <style>
                        body {
                            text-align: center;
                        }
                        .title {
                            font-size: 15px;
                        }
                        .subtitle {
                            font-size: 15px;
                        }
                        .logo {
                            width: 30px; /* Adjust the width as needed */
                            height: auto;
                            display: block;
                            margin-bottom: 20px;
                        }
                        .table {
                            margin: 20px auto; /* Center the table */
                            border-collapse: collapse;
                            width: 100%; /* Adjust the width as needed */
                        }
                        th, td {
                            border: 2px solid #dddddd;
                            text-align: left;
                            padding: 8px;
                        }
                        th {
                            background-color: #f2f2f2;
                        }
                    </style>
                </head>
                <body>
                    <!-- Header Content -->
                    ${headerContent}
                    
                    <!-- Table Content -->
                    <table>
                        ${tableContent}
                    </table>

                    <!-- Footer Content -->
                    <hr>
                    ${footerContent}
                </body>
            </html>
            `;

            printWindow.document.open();
            printWindow.document.write(printContent);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        }
    </script>
</body>
</html>
