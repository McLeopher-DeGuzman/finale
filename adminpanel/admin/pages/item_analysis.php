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
                <div class="table-responsive">
                    <table id="tableList" class="align-middle mb-0 table table-striped table-bordered dataTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>Correct Answers</th>
                                <th>Incorrect Answers</th>
                                <th>Total Answers</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                @$examId = $_GET['id'];
                                $selQuest = $conn->query("SELECT eqt.exam_question, 
                                                                 COUNT(CASE WHEN ea.exans_answer = eqt.exam_answer THEN 1 END) AS correct_answers,
                                                                 COUNT(CASE WHEN ea.exans_answer != eqt.exam_answer THEN 1 END) AS incorrect_answers,
                                                                 COUNT(ea.exans_answer) AS total_answers
                                                           FROM exam_question_tbl eqt 
                                                           LEFT JOIN exam_answers ea 
                                                           ON eqt.eqt_id = ea.quest_id 
                                                           WHERE eqt.exam_id='$examId' 
                                                           GROUP BY eqt.exam_question");

                                if ($selQuest->rowCount() > 0) {
                                    while ($selQuestRow = $selQuest->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <tr>
                                            <td><?php echo $selQuestRow['exam_question']; ?></td>
                                            <td><?php echo $selQuestRow['correct_answers']; ?></td>
                                            <td><?php echo $selQuestRow['incorrect_answers']; ?></td>
                                            <td><?php echo $selQuestRow['total_answers']; ?></td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="4"><h3 class="p-3">No Questions Found</h3></td>
                                    </tr>
                                <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>     
    </div>
</div>
