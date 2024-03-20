<?php
$examId = $_GET['id'];
$selExam = $conn->query("SELECT * FROM exam_tbl WHERE ex_id='$examId'")->fetch(PDO::FETCH_ASSOC);
?>

<style>
  .chatbot-icon:hover {
    animation: pulse 0.5s ease infinite;
  }

  @keyframes pulse {
    0% {
      transform: scale(1);
      box-shadow: 0 0 10px rgba(255, 115, 119, 0.7);
    }
    50% {
      transform: scale(1.1);
      box-shadow: 0 0 20px rgba(255, 115, 119, 0.7);
    }
    100% {
      transform: scale(1);
      box-shadow: 0 0 10px rgba(255, 115, 119, 0.7);
    }
  }

  @keyframes float {
    0%, 100% {
      transform: translateY(0);
    }
    50% {
      transform: translateY(-10px); /* Adjust the floating distance */
    }
  }

  .chatbot-icon {
    font-family: 'Font Awesome'; /* Use your icon font family */
    content: '\f3e8'; 
    position: fixed;
    bottom: 20px;
    right: 20px;
    display: flex;
    align-items: center;
    transition: background-color 0.3s ease;
    cursor: pointer; /* Add a pointer cursor to indicate interactivity */
    animation: float 3s ease-in-out infinite; /* Apply the floating animation */
  }

  /* Transition for the chatbot icon link */
  .chatbot-icon a {
    transition: color 0.3s ease, background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease, border-radius 0.3s ease, padding 0.3s ease;
  }

  /* Apply styles when hovering over the chatbot icon link */
  .chatbot-icon a:hover {
    color: #2980b9; /* Change color on hover */
    background-color: #fff; /* Change background color on hover */
    transform: scale(1.1); /* Add a slight scale effect on hover */
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.4); /* Add a box shadow on hover */
    border-radius: 5px; /* Add border radius on hover */
    padding: 5px; /* Adjust padding on hover */
  }
</style>


<link rel="stylesheet" type="text/css" href="css/mycss.css">
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <!-- <div>EXAMINEE RESULT</div> -->
                </div>
            </div>
        </div>

        <!-- <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Ratings on the Career Advice Consultation Exam</div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                        <thead>
                            <tr>
                                <th>Scores</th>
                                <th>Ratings</th>
                                <th>Subject</th>
                                <th>Course Recommendation</th>
                            </tr>
                        </thead>
                        <tbody>
                        

                        <?php
$selScore = $conn->query("SELECT *, eqt.category AS category FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND eqt.exam_answer = ea.exans_answer  WHERE ea.axmne_id='$exmneId' AND ea.exam_id='$examId' AND ea.exans_status='new'");

// Initialize an array to hold scores for each category
$categoryScores = array();

// Loop through each row in the result set
while($row = $selScore->fetch(PDO::FETCH_ASSOC)) {
    // Get the category from the current row
    $category = $row['category'];
    
    // Check if the category exists in the $categoryScores array
    if(!isset($categoryScores[$category])) {
        // If not, initialize the score for that category to zero
        $categoryScores[$category] = 0;
    }
    
    // Increment the score for the current category
    $categoryScores[$category]++;
}

$totalPercentage = 0; // Initialize total percentage
$totalQuestionsCount = 0; // Initialize total question count

// Now you have the count of correct answers for each category
// You can proceed to further computations or output as needed
foreach($categoryScores as $category => $score) {
    // Get the total number of questions for the current category
    $totalQuestionsQuery = $conn->query("SELECT COUNT(*) AS total FROM exam_question_tbl WHERE category='$category' AND exam_id='$examId'");

    $totalQuestions = $totalQuestionsQuery->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Increment total question count
    $totalQuestionsCount += $totalQuestions;
    
    // Compute the percentage score for the current category
    $percentage = number_format(($score / $totalQuestions * 100), 2); // Compute percentage

    // Add the percentage to the total
    $totalPercentage += $percentage;
    
    echo "Category: $category, Percentage Score: $percentage%\n";
}

// Multiply total percentage by total question count
$totalScore = ($totalPercentage / 100) * $totalQuestionsCount;

// Check if the total score exceeds a certain threshold
if($totalScore >= 70) {
    echo "Congratulations! You passed the exam. $totalPercentage";
} else {
    echo "Sorry, you did not pass the exam. Your total score is $totalScore out of $totalQuestionsCount.";
}
?>
 






                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Ratings on the Career Advice Consultation Exam</div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="categoryResultsTable">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Percentage Score</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
$totalPercentage = 0; // Initialize total percentage
$totalItemsCount = 0; // Initialize total item count

// Loop through each category
foreach($categoryScores as $category => $score) {
    // Get the total number of questions for the current category
    $totalQuestionsQuery = $conn->query("SELECT COUNT(*) AS total FROM exam_question_tbl WHERE category='$category' AND exam_id='$examId'");

    $totalQuestions = $totalQuestionsQuery->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Increment total item count
    $totalItemsCount += $totalQuestions;
    
    // Compute the percentage score for the current category
    $percentage = number_format(($score / $totalQuestions * 100), 2); // Compute percentage

    // Add the percentage to the total
    $totalPercentage += $percentage * $totalQuestions; // Multiply percentage by total questions
    
    // Output the category and percentage
    ?>
    <tr>
        <th><?php echo $category; ?></th>
        <th><?php echo $percentage . '%'; ?></th>
    </tr>
    <?php
}

// Compute overall percentage
$overallPercentage = number_format(($totalPercentage / $totalItemsCount), 2);


?>


<!-- Display overall percentage -->
<tr>
    <!-- <th></th> -->
    <th colspan="2">Congratulations! For taking the exam with an Overall Score of <?php echo $overallPercentage . '%'; ?></th>
</tr> 
<tr>
<th>Course Recommendation</th>
    <th colspan="2">
    <?php 
if ($overallPercentage >= 90.00 && $overallPercentage <= 100.00 ) {
    echo "1st Choice: Bachelor of Science in Architecture (BSA), ".
    "2nd Choice: Bachelor of Science in Engineering (BSE)";
} 
elseif ($overallPercentage >= 70.00 && $overallPercentage <= 80.00) {
    echo "1st Choice: Bachelor of Science in Nursing (BSN), ".
    "2nd Choice: Bachelor of Science in Pharmacy (BSP)";
}
elseif ($overallPercentage >= 40.00 && $overallPercentage <= 60.00) {
    echo "1st Choice: Bachelor of Science in Computer Science (BSCS), ".
    "2nd Choice: Bachelor of Science in Information Technology (BSIT)";
}
elseif ($overallPercentage >= 60.00 && $overallPercentage <= 70.00) {
  echo "1st Choice: Bachelor of Elementary Education (BEE) , ".
  "2nd Choice: Bachelor of Secondary Education (BSE)";
}
elseif ($overallPercentage >= 80.00 && $overallPercentage <= 90.00) {
  echo "1st Choice: Bachelor of Science in Tourism Management (BSTM) , ".
  "2nd Choice: Bachelor of Science in Hospitality Management (BSHM)";
}


else {
    echo "Please Contact the Administrator/Guidance Counselor for the follow up and for other concerns https://www.facebook.com/ucsaldcs";
}
?>

    </th>
</tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End of Table for Category Results -->
        <div class="chatbot-icon">
            
            <!-- <div class="text-message">The chatbot provides advice after reviewing the results and recommendations.</div> -->
            <a href="./chatbot/index.php">
                <i class='fas fa-comment' style='font-size:30px; color: #FF7377'>Hi, Click here to Chat with Us!</i>
            </a>
        </div>
    </div>
</div>
