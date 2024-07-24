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

                    <!-- Pagination Controls -->
                    <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 bg-white">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-500 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-100">
                                Previous
                            </a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-500 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-100">
                                Next
                            </a>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">50</span> results
                                </p>
                            </div>
                            <div>
                                <nav class="relative inline-flex items-center space-x-2" aria-label="Pagination">
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-500 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-100">
                                        Previous
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-500 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-100">
                                        1
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-500 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-100">
                                        2
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-500 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-100">
                                        3
                                    </a>
                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm">
                                        ...
                                    </span>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-500 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-100">
                                        10
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-500 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-100">
                                        Next
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
