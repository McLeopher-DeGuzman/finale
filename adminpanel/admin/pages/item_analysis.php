<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Analysis</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
        .table-responsive {
            max-height: 600px;
            overflow-y: auto;
        }
        th, td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div>ITEM ANALYSIS</div>
                    </div>
                </div>
            </div> 
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">ITEM ANALYSIS</div>
                    <div class="card-body">
                        <p>1: Correct - 0: Incorrect</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <?php for ($i = 1; $i <= 80; $i++): ?>
                                        <th>Q<?php echo $i; ?></th>
                                    <?php endfor; ?>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Assuming you have the total number of examinees
                                    $total = $selExaminee['totExaminee'];  // Placeholder, replace with actual data

                                    // Generate random answers for each student
                                    $answers = [];
                                    for ($i = 0; $i < $total; $i++) {
                                        $answers[$i] = array_map(function() {
                                            return rand(0, 1);
                                        }, range(1, 80));
                                    }

                                    // Initialize array to store the count of correct answers for each question
                                    $question_correct_counts = array_fill(0, 80, 0);

                                    // Output the answers in the table
                                    for ($student = 1; $student <= $total; $student++):
                                        $student_answers = $answers[$student - 1];
                                        $total_correct = array_sum($student_answers);

                                        // Update the count of correct answers for each question
                                        foreach ($student_answers as $index => $answer) {
                                            if ($answer == 1) {
                                                $question_correct_counts[$index]++;
                                            }
                                        }
                                ?>
                                    <tr>
                                        <td>Student <?php echo $student; ?></td>
                                        <?php foreach ($student_answers as $answer): ?>
                                            <td><?php echo $answer; ?></td>
                                        <?php endforeach; ?>
                                        <td><?php echo $total_correct; ?></td>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Correct Count</th>
                                    <?php foreach ($question_correct_counts as $count): ?>
                                        <th><?php echo $count; ?></th>
                                    <?php endforeach; ?>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- <div class="col-md-6 col-xl-4">
                        <div class="card mb-3 widget-content bg-grow-early">
                            <div class="widget-content-wrapper text-white">
                                <div class="widget-content-left">
                                    <div class="widget-heading">Total Examinee Students</div>
                                    <div class="widget-subheading" style="color:transparent;">.</div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-white"><span><?php echo $total; ?></span></div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>     
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
