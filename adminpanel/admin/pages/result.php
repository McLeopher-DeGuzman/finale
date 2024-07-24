<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Examinee with Pagination and Search</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body>
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
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Question</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Answer</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php 
                                    $i = 1;
                                    $maxItems = 81;
                                    while ($selQuestRow = $selQuest->fetch(PDO::FETCH_ASSOC)) { 
                                        if ($i >= $maxItems) {
                                            break;
                                        }
                                ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $i++; ?> .) <?php echo $selQuestRow['exam_question']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php 
                                            if($selQuestRow['exam_answer'] != $selQuestRow['exans_answer']) {
                                        ?>
                                        <span class="text-red-500"><?php echo $selQuestRow['exans_answer']; ?></span>
                                        <?php } else { ?>
                                        <span class="text-green-500"><?php echo $selQuestRow['exans_answer']; ?></span>
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
                    <div class="card-header flex items-center justify-between">
                        EXAMINEE LIST
                        <form method="GET" class="flex items-center space-x-2">
                            <input type="hidden" name="page" value="result">
                            <input type="text" name="search" placeholder="Search by name" class="form-input border-gray-300 rounded-md shadow-sm">
                            <button type="submit" class="btn btn-primary btn-sm px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-md shadow-sm">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Strand</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" width="8%">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
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
                                                <td class="px-6 py-4 whitespace-nowrap"><?php echo $selExmneRow['exmne_fullname']; ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <?php 
                                                        $exmneCourse = $selExmneRow['exmne_course'];
                                                        $selCourse = $conn->query("SELECT * FROM course_tbl WHERE cou_id='$exmneCourse' ")->fetch(PDO::FETCH_ASSOC);
                                                        echo $selCourse['cou_name'];
                                                    ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <a href="?page=result&id=<?php echo $selExmneRow['exam_id'];?>" class="btn btn-success btn-sm px-4 py-2 text-white bg-green-500 hover:bg-green-600 rounded-md shadow-sm">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-center">
                                                <h3 class="text-lg text-gray-700">No Examinee Found</h3>
                                            </td>
                                        </tr>
                                    <?php }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
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
            <?php } ?>     
        </div>
    </div>
</body>
</html>
