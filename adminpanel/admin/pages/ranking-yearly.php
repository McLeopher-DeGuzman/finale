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
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div>RANKING YEARLY</div>
                    </div>
                </div>
            </div>        

            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Ranking Yearly
                    </div>
                    <div style="text-align: right;">
                        <!-- Print Button -->
                        <button style="background-color: #1640D6; border: none; color: white; padding: 5px 10px; text-align: center; text-decoration: none; display: inline-block; font-size: 12px; margin: 1px 2px; cursor: pointer; border-radius: 10px;" onclick="printTable();">
                            <i class="fa fa-print" style="margin-right: 5px;"></i>
                            Print Entire Table
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table id="tableList" class="align-middle mb-0 table table-striped table-bordered dataTable w-full">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Exam Name</th>
                                    <th>Scores</th>
                                    <th>Ratings</th>
                                    <th width="10%">Date and Time</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <!-- PHP code to fetch and display data -->
                                <?php 
                                $selExmne = $conn->query("SELECT * FROM examinee_tbl et INNER JOIN exam_attempt ea ON et.exmne_id = ea.exmne_id ORDER BY ea.examat_id DESC ");
                                if($selExmne->rowCount() > 0)
                                {
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
                                                        // echo "$ans";
                                                        echo "%";
                                                        
                                                     ?>
                                                </span> 
                                           </td>
                                           <td>
                                            <?php
                                            // Fetch date and time from the exam_attempt table
                                            $submissionDate = $selExmneRow['submission_date']; // Change 'exam_date_time' to the actual column name
                                            echo date("Y-m-d", strtotime($submissionDate));
                                            ?>
                                            <!-- h:i:s -->
                                        </td>
                                           <!-- <td>
                                               <a rel="facebox" href="facebox_modal/updateExaminee.php?id=<?php echo $selExmneRow['exmne_id']; ?>" class="btn btn-sm btn-primary">Print Result</a>

                                           </td>  -->
                                        </tr>
                                    <?php }
                                }
                                else
                                { ?>
                                    <tr>
                                      <td colspan="2">
                                        <h3 class="p-3">No Course Found</h3>
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
                            <!-- Mobile view: Previous and Next buttons -->
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
                                    <!-- Page numbers -->
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
                        <link rel="shortcut icon" href="../../login-ui/images/UCS-removebg-preview.png">
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
                                width: 30px;
                                height: auto;
                                display: block;
                                margin-bottom: 20px;
                            }

                            .table {
                                margin: 20px auto;
                                border-collapse: collapse;
                                width: 100%;
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
                        ${headerContent}
                        <table>
                            ${tableContent}
                        </table>
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
