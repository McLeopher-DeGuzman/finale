<?php
    $examId = $_GET['id'];
    $selExam = $conn->query("SELECT * FROM exam_tbl WHERE ex_id='$examId'")->fetch(PDO::FETCH_ASSOC);

    // Assume $exmneId is defined before this point in your code
?>

<div class="app-main__outer">
    <div class="app-main__inner">
        <div id="refreshData">
            <div class="col-md-12">
                <div class="app-page-title">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div>
                                <?php echo $selExam['ex_title']; ?>
                                <div class="page-title-subheading">
                                    <!-- <?php echo $selExam['ex_description']; ?> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="row col-md-12  justify-content-center">
                    <h1 class="text-primary">RESULTS</h1>
                </div>

                <div class="col-mod-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header"> ITEM ANALYSIS</div>
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-striped table-hover" id="tableList">
                                <thead>
                                    <tr>
                                        <th>Total Questions</th>
                                        <th>Correct Answers</th>
                                        <th>Incorrect Answers</th>
                                        <th>Percentage Correct</th>
                                        <th>Percentage Incorrect</th>
                                        <th>Difficulty Index</th>
                                        <th>Discrimination Index</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    $selQuest = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id WHERE eqt.exam_id='$examId' AND ea.axmne_id='$exmneId' AND ea.exans_status='new' ");
                                    $totalQuestions = $selQuest->rowCount();
                                    $correctAnswersCount = 0;
                                    $incorrectAnswersCount = 0;
                                    $unansweredCount = $totalQuestions;

                                    while ($selQuestRow = $selQuest->fetch(PDO::FETCH_ASSOC)) {
                                        $isCorrect = $selQuestRow['exam_answer'] == $selQuestRow['exans_answer'];
                                        $correctAnswersCount += $isCorrect ? 1 : 0;
                                        $incorrectAnswersCount += $isCorrect ? 0 : 1;
                                        $unansweredCount -= $isCorrect ? 0 : 1;
                                        ?>
                                        <!-- <tr>
                                            <td>
                                                <label class="pl-4 <?php echo $isCorrect ? 'text-success' : 'text-danger'; ?>">
                                                    Answer: <?php echo $selQuestRow['exans_answer']; ?>
                                                </label>
                                            </td>
                                        </tr> -->
                                    <?php }

                                    // Calculate item analysis metrics
                                    $percentageCorrect = ($correctAnswersCount / $totalQuestions) * 100;
                                    $percentageIncorrect = ($incorrectAnswersCount / $totalQuestions) * 100;
                                    $percentageUnanswered = ($unansweredCount / $totalQuestions) * 100;

                                    // Calculate difficulty index
                                    $difficultyIndex = $percentageCorrect;

                                    // Calculate discrimination index
                                    $discriminationIndex = ($correctAnswersCount - $incorrectAnswersCount) / $totalQuestions;
                                ?>

                                <th><?php echo $totalQuestions; ?></th>
                                <th><?php echo $correctAnswersCount; ?></th>
                                <th><?php echo $incorrectAnswersCount; ?></th>
                                <th><?php echo number_format($percentageCorrect, 2) . '%'; ?></th>
                                <th><?php echo number_format($percentageIncorrect, 2) . '%'; ?></th>
                                <th><?php echo number_format($difficultyIndex, 2) . '%'; ?></th>
                                <th><?php echo number_format($discriminationIndex, 2); ?></th>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
