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

        <div class="col-md-12">
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
// Assuming you have established a database connection and have $conn available

$selScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND eqt.exam_answer = ea.exans_answer  WHERE ea.axmne_id='$exmneId' AND ea.exam_id='$examId' AND ea.exans_status='new'");
$score = $selScore->rowCount();
$over = $selExam['ex_questlimit_display'];
$formattedAns = number_format(($score / $over * 100), 2);

$subject = ""; // Subject initialization
$courseRecommendation = "Please Contact"; // Default course recommendation

if ($formattedAns >= 1.00 && $formattedAns <= 20.00) {
    $subject = "Logic";
    $courseRecommendation = "Bachelor of Science in Computer Science (BSCS), Bachelor of Science in Information Technology (BSIT)";
} elseif ($formattedAns > 20.00 && $formattedAns <= 40.00) {
    $subject = "Analytical";
    $courseRecommendation = "Bachelor of Science in Architecture (BSA), Bachelor of Science in Engineering (BSE)";
} elseif ($formattedAns > 40.00 && $formattedAns <= 60.00) {
    $subject = "Grammar and Vocabulary";
    $courseRecommendation = "Bachelor of Elementary Education (BEE), Bachelor of Secondary Education (BSE)";
} elseif ($formattedAns > 60.00 && $formattedAns <= 80.00) {
    $subject = "Science";
    $courseRecommendation = "Bachelor of Science in Nursing (BSN), Bachelor of Science in Pharmacy (BSP)";
} elseif ($formattedAns > 80.00 && $formattedAns <= 100.00) {
    $subject = "Abstract Thinking";
    $courseRecommendation = "Bachelor of Science in Tourism Management (BSTM), Bachelor of Science in Hospitality Management (BSHM)";
}

// Simulating predefined scores based on dynamic score percentage
$logicScore = ceil($score * 0.15); // 20% of total score
$numericalScore = ceil($score * 0.15); // 20% of total score
$grammarScore = ceil($score * 0.2); // 20% of total score
$clinicalScore = ceil($score * 0.2); // 20% of total score
$communicationScore = ceil($score * 0.15); // 20% of total score

$totalScore = $logicScore + $numericalScore + $grammarScore + $clinicalScore + $communicationScore;

// Define the total number of items for each subject (assuming each subject has equal weight)
$totalItems = 5;
$itemsPerSubject = ceil($over / $totalItems);

// Calculate the average score
$averageScore = $totalScore / $totalItems;

// Determine subject and course recommendation based on average score
if ($averageScore <= 20) {
    $subject = "Logic";
    $courseRecommendation = "Bachelor of Science in Computer Science (BSCS), Bachelor of Science in Information Technology (BSIT)";
} elseif ($averageScore <= 40) {
    $subject = "Analytical";
    $courseRecommendation = "Bachelor of Science in Architecture (BSA), Bachelor of Science in Engineering (BSE)";
} elseif ($averageScore <= 60) {
    $subject = "Grammar and Vocabulary";
    $courseRecommendation = "Bachelor of Elementary Education (BEE), Bachelor of Secondary Education (BSE)";
} elseif ($averageScore <= 80) {
    $subject = "Science";
    $courseRecommendation = "Bachelor of Science in Nursing (BSN), Bachelor of Science in Pharmacy (BSP)";
} 
 elseif ($averageScore <=100){
    $subject = "Abstract Thinking";
    $courseRecommendation = "Bachelor of Science in Tourism Management (BSTM), Bachelor of Science in Hospitality Management (BSHM)";

 }
else {
    $subject = "";
    $courseRecommendation = "N/a";
}
?>

<!-- Displaying the results -->


<th><?php echo "Total Score: " . $totalScore; ?></th>
<th><?php echo "Average Score: " . number_format($averageScore, 2) . "%"; ?></th>
<th><?php echo "Predefined Subject: " . $subject; ?></th>
<th><?php echo "Predefined Course Recommendation: " . $courseRecommendation; ?></th>  

<!-- Integration of provided code snippet to display subjects and scores -->
<?php
// Associative array to store subjects and their scores
$subjectScores = array(
    "Logic" => $logicScore,
    "Analytical" => $numericalScore,
    "Grammar and Vocabulary" => $grammarScore,
    "Science" => $clinicalScore,
    "Abstract Thinking" => $communicationScore
);

// Sort the array based on scores in descending order
arsort($subjectScores);

// Display subjects and their scores from highest to lowest
foreach ($subjectScores as $subject => $score) {
    echo "<th>$subject: " . number_format(($score / $itemsPerSubject) * 100, 2) . "%</th>";
}
?>



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="chatbot-icon">
            
            <!-- <div class="text-message">The chatbot provides advice after reviewing the results and recommendations.</div> -->
            <a href="./chatbot/index.php">
                <i class='fas fa-comment' style='font-size:30px; color: #FF7377'>Hi, Click here to Chat with Us!</i>
            </a>
        </div>
    </div>
</div>
