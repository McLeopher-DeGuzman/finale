<div class="app-main__outer">
    <div class="app-main__inner">
        <?php 
            @$examId = $_GET['id'];
            
            if($examId != "") {
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
                    <table id="tableList" class="align-middle mb-0 table table-striped table-bordered dataTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>Answer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i = 1;
                                $maxItems = 81;
                                while ($selQuestRow = $selQuest->fetch(PDO::FETCH_ASSOC)) { 
                                    if ($i >= $maxItems) {
                                        break; // Exit the loop if the maximum number of items is reached
                                    }
                            ?>
                            <tr>
                                <td><?php echo $i++; ?> .) <?php echo $selQuestRow['exam_question']; ?></td>
                                <td>
                                    <?php 
                                        if($selQuestRow['exam_answer'] != $selQuestRow['exans_answer']) {
                                    ?>
                                    <span style="color:red"><?php echo $selQuestRow['exans_answer']; ?></span>
                                    <?php } else { ?>
                                    <span class="text-success"><?php echo $selQuestRow['exans_answer']; ?></span>
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
                <div class="card-header">
                    EXAMINEE LIST
                    <form method="GET" class="float-right">
                        <input type="hidden" name="page" value="result">
                        <input type="text" name="search" placeholder="Search by name" class="form-control" style="width: 200px; display: inline; left: 50vw; position: relative; ">
                        <button type="submit" class="btn btn-primary btn-sm" style=" display: inline; left: 50vw; position: relative; "><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="table-responsive">
                    <table id="tableList" class="align-middle mb-0 table table-striped table-bordered dataTable" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-left pl-4">Full Name</th>
                                <th class="text-left">Strand</th>
                                <th class="text-center" width="8%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                // Default query part
                                $query = "SELECT * FROM examinee_tbl INNER JOIN exam_attempt ON examinee_tbl.exmne_id = exam_attempt.exmne_id ";

                                // Check if there is a search query
                                if(isset($_GET['search']) && !empty($_GET['search'])) {
                                    $search = $_GET['search'];
                                    $query .= "WHERE exmne_fullname LIKE :search ";
                                }

                                // Order by
                                $query .= "ORDER BY exam_attempt.examat_id ";

                                // Prepare and execute the query
                                $stmt = $conn->prepare($query);

                                // Bind the search parameter if exists
                                if(isset($search)) {
                                    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
                                }

                                $stmt->execute();

                                if($stmt->rowCount() > 0) {
                                    while ($selExmneRow = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <tr>
                                           <td><?php echo $selExmneRow['exmne_fullname']; ?></td>
                                           <td>
                                                <?php 
                                                    $exmneCourse = $selExmneRow['exmne_course'];
                                                    $selCourse = $conn->query("SELECT * FROM course_tbl WHERE cou_id='$exmneCourse' ")->fetch(PDO::FETCH_ASSOC);
                                                    echo $selCourse['cou_name'];
                                                ?>
                                            </td>
                                            <td>
                                                <a href="?page=result&id=<?php echo $selExmneRow['exam_id'];?>" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> View</a>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="3"><h3 class="p-3">No Examinee Found</h3></td>
                                    </tr>
                                <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>   
        <?php } ?>     
    </div>
</div>
