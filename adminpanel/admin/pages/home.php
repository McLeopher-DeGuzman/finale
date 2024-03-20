
<div class="app-main__outer">
    <div id="refreshData">
    <div class="app-main__inner">
            
            <h1 class="text-3xl text-black pb-6">Dashboard</h1>
            <div class="row"> 
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-midnight-bloom">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Strand</div>
                                <div class="widget-subheading" style="color:transparent;">.</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white">
                                    <span><?php echo $totalCourse = $selCourse['totCourse']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-arielle-smile">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Exam</div>
                                <div class="widget-subheading" style="color:transparent;">.</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white">
                                    <span><?php echo $totalCourse = $selExam['totExam']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-grow-early">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Examinee Students</div>
                                <div class="widget-subheading" style="color:transparent;">.</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span><?php echo $total = $selExaminee['totExaminee']; ?></span></div>
                            </div>
                        </div>
                    </div>
                </div>
               
          <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Admin Template</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <!-- Tailwind CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

    <!-- Custom CSS -->
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: karla; }
        .bg-sidebar { background: #3d68ff; }
        .cta-btn { color: #3d68ff; }
        .upgrade-btn { background: #1947ee; }
        .upgrade-btn:hover { background: #0038fd; }
        .active-nav-link { background: #1947ee; }
        .nav-item:hover { background: #1947ee; }
        .account-link:hover { background: #3d68ff; }
        /* Add custom CSS styles here */

        /* Adjust the chart size */
        .chart-container {
            width: 100vw;
            height: 80vh;
            max-width: 950px;
            margin: 0;
        }

        /* Style the table */
        .data-table {
            width: 100%;
        }

        .data-table th, .data-table td {
            text-align: left;
            padding: 10px;
        }

        .data-table th {
            /* background-color: #333; */
            background-color: #FF7377; 
            color: white;
        }

        .data-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .data-table a:hover {
            color: #3d68ff;
        }


    </style>
</head>
<body class="bg-gray-100 font-family-karla flex">
    <div class="w-full overflow-x-hidden border-t flex flex-col">
        <main class="w-full flex-grow p-6">
            <!-- <h1 class="text-3xl text-black pb-6">Dashboard</h1> -->

            <!-- <div class="flex flex-wrap mt-6"> -->
                <!-- <div class="w-full lg:w-1/2 pr-0 lg:pr-2">
                    <p class="text-xl pb-3 flex items-center">
                        <i class="fas fa-plus mr-3"></i> Monthly Reports
                    </p>
                    <div class="p-6 bg-white chart-container">
                        <canvas id="chartOne"></canvas>
                    </div>
                </div> -->
                <div class="w-full lg:w-1/2 pl-0 lg:pl-2 mt-12 lg:mt-0">
                    <p class="text-xl pb-3 flex items-center">
                        <i class="fas fa-check mr-3"></i> Resolved Reports
                    </p>
                    <div class="p-6 bg-white chart-container">
                        <canvas id="chartTwo" style="height: 50vh; width: 50vw"></canvas>
                    </div>
                </div>
            

            <div class="w-full mt-12">
                <p class="text-xl pb-3 flex items-center">
                    <i class="fas fa-list mr-3"></i> Latest Reports
                </p>
                <div class="bg-white overflow-auto">
                    <table class="w-full data-table">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="w-1/4">Name</th>
                                <!-- <th class="w-1/3">Last Name</th> -->
                                <th>Score</th>
                                <th>Percentage</th>
                                <th class="w-*">Course Recommendation</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <!-- Add your table data here -->
                            <?php 
                                $selExmne = $conn->query("SELECT * FROM examinee_tbl et INNER JOIN exam_attempt ea ON et.exmne_id = ea.exmne_id ORDER BY ea.examat_id DESC ");
                                if($selExmne->rowCount() > 0)
                                {
                                    while ($selExmneRow = $selExmne->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <tr>
                                           <td><?php echo $selExmneRow['exmne_fullname']; ?></td>
                                           <!-- <td>
                                             <?php 
                                                $eid = $selExmneRow['exmne_id'];
                                                $selExName = $conn->query("SELECT * FROM exam_tbl et INNER JOIN exam_attempt ea ON et.ex_id=ea.exam_id WHERE  ea.exmne_id='$eid' ")->fetch(PDO::FETCH_ASSOC);
                                                $exam_id = $selExName['ex_id'];
                                                echo $selExName['ex_title'];
                                              ?>
                                           </td> -->
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
                                                $formattedAns = number_format($ans, 2);

                                                echo $formattedAns . "%";

                                                // $subject = ""; // Initialize the subject variable

                                                // if ($formattedAns >= 30.00 && $formattedAns <= 40.00) {
                                                //     $subject = "logics"; // Assign the subject they excel in
                                                // } elseif ($formattedAns >= 40.00 && $formattedAns <= 50.00) {
                                                //     echo " ";
                                                //     $subject = "bsba"; // Assign the subject they excel in
                                                // } else {
                                                //     echo ""; // Default case if the percentage doesn't match any subject
                                                //     $subject = "unknown";
                                                // }

                                                // Now you can use the $subject variable to further process or display the subject they excel in
                                                
                                                ?> 
                                    
                                                </span> 
                                           </td>
                                           <td>
                                                    <?php
                                                    if ($formattedAns >= 40.00 && $formattedAns <= 60.00) {
                                                        echo "Bachelor of Science in Computer Science (BSCS), ".
                                                        " Bachelor of Science in Information Technology (BSIT)";
                        
                                                    } elseif ($formattedAns >= 90.00 && $formattedAns <= 100.00) {
                                                        echo "Bachelor of Science in Architecture (BSA), ".
                                                        "Bachelor of Science in Engineering (BSE)";
                        
                                                    } elseif ($formattedAns >= 60.00 && $formattedAns <= 70.00) {
                                                        echo "Bachelor of Elementary Education (BEE), ".
                                                        "Bachelor of Secondary Education (BSE) ";
                        
                                                    } elseif ($formattedAns >= 70.00 && $formattedAns <= 80.00) {
                                                        echo "Bachelor of Science in Nursing (BSN), ".
                                                        " Bachelor of Science in Pharmacy (BSP)";
                        
                                                    } elseif ($formattedAns >= 80.00 && $formattedAns <= 90.00) {
                                                        echo "Bachelor of Science in Tourism Management (BSTM),".
                                                        "Bachelor of Science in Hospitality Management (BSHM)";
                                                    } 
                                                    else {
                                                        echo "Please Contact the Administrator/Guidance Counselor for the follow up and for other concerns https://www.facebook.com/ucsaldcs";
                                                    }
                                                    ?> 
                                           </td>
                                           <!-- <td>
                                               <a rel="facebox" href="facebox_modal/updateExaminee.php?id=<?php echo $selExmneRow['exmne_id']; ?>" class="btn btn-sm btn-primary">Print Result</a>

                                           </td> -->
                                        </tr>
                                    <?php }
                                }
                                else
                                { ?>
                                    <tr>
                                      <td colspan="2">
                                        <h3 class="p-3">no record yet</h3>
                                      </td>
                                    </tr>
                                <?php }
                               ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <footer class="w-full bg-white text-right p-4">
            <!-- Built by <a target="_blank" href="https://davidgrzyb.com" class="underline">David Grzyb</a>. -->
        </footer>
    </div>

   
    <?php
$subjectCounts = [
    "(BSCS), (BSIT)" => 0,
    "(BSA), (BSE)" => 0,
    "(BEE), (BSE)" => 0,
    "(BSN), (BSP)" => 0,
    "(BSTM), (BSHM)" => 0,
];

$selExmne = $conn->query("SELECT * FROM examinee_tbl et INNER JOIN exam_attempt ea ON et.exmne_id = ea.exmne_id ORDER BY ea.examat_id DESC");

if ($selExmne->rowCount() > 0) {
    while ($selExmneRow = $selExmne->fetch(PDO::FETCH_ASSOC)) {
        $eid = $selExmneRow['exmne_id'];
        $selScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND eqt.exam_answer = ea.exans_answer  WHERE ea.axmne_id='$eid' AND ea.exam_id='$exam_id' AND ea.exans_status='new' ");
        $score = $selScore->rowCount();
        $over = $selExName['ex_questlimit_display'];

        $formattedAns = number_format($score / $over * 100, 2);
        // $courseRecommendation = "(Unknown)";

if ($formattedAns >= 40.00 && $formattedAns <= 60.00) {
    $courseRecommendation = "(BSCS), (BSIT)";
} elseif ($formattedAns >= 90.00 && $formattedAns <= 100.00) {
    $courseRecommendation = "(BSA), (BSE)";
} elseif ($formattedAns >= 60.00 && $formattedAns <= 70.00) {
    $courseRecommendation = "(BEE), (BSE)";
} elseif ($formattedAns >= 70.00 && $formattedAns <= 80.00) {
    $courseRecommendation = "(BSN), (BSP)";
} elseif ($formattedAns >= 80.00 && $formattedAns <= 90.00) {
    $courseRecommendation = "(BSTM), (BSHM)";
}

$subjectCounts[$courseRecommendation]++;

    }
   

}
?>

<!-- The rest of your HTML code -->

<script>
    // Sample chart data (you can replace this with your data)
    var chartDataTwo = {
        labels: <?php echo json_encode(array_keys($subjectCounts)); ?>,
        datasets: [{
            label: 'Number of Students',
            data: <?php echo json_encode(array_values($subjectCounts)); ?>,
            borderColor: 'rgba(75, 192, 192, 1)', // Line color
            borderWidth: 5, // Line width
            fill: false, // Don't fill the area under the line
        }]
    };

    document.addEventListener('DOMContentLoaded', function () {
        var chartTwo = new Chart(document.getElementById('chartTwo'), {
            type: 'bar', // Use a bar chart
            data: chartDataTwo,
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Courses',
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Number of Students',
                        },
                    },
                },
                elements: {
                    bar: {
                        borderColor: 'rgba(75, 192, 192, 1)', // Change the bar color
                    },
                },
                plugins: {
                    legend: {
                        display: false, // Hide the legend
                    },
                },
                maintainAspectRatio: true, // Adjust the aspect ratio for a better height
            },
        });
    });
</script>


</body>
</html>
</div>
</div>
</div>
    