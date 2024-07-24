<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking Yearly</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" type="text/css" href="css/mycss.css">
</head>
<div class="app-main__outer">
        <div class="app-main__inner">
             


            <?php 
                @$exam_id = $_GET['exam_id'];


                if($exam_id != "")
                {
                   $selEx = $conn->query("SELECT * FROM exam_tbl WHERE ex_id='$exam_id' ")->fetch(PDO::FETCH_ASSOC);
                   $exam_course = $selEx['cou_id'];

                   

                   $selExmne = $conn->query("SELECT * FROM examinee_tbl et  WHERE exmne_course='$exam_course'  ");


                   ?>
                   <div class="app-page-title">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div><b class="text-primary">RANKING BY EXAM</b><br>
                                Exam Name : <?php echo $selEx['ex_title']; ?><br><br>
                               <span class="border" style="padding:10px;color:black;background-color: yellow;">Excellence</span>
                               <span class="border" style="padding:10px;color:white;background-color: green;">Very Good</span>
                               <span class="border" style="padding:10px;color:white;background-color: blue;">Good</span>
                               <span class="border" style="padding:10px;color:white;background-color: red;">Failed</span>
                               <span class="border" style="padding:10px;color:black;background-color: #E9ECEE;">Not Answering</span>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="table-responsive">
                    <table id="tableList" class="align-middle mb-0 table table-striped table-bordered dataTable" style="width:100%">
                          <tbody>
                            <thead>
                                <tr>
                                    <th width="25%">Examinee Full Name</th>
                                    <th>Score / Over</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <?php 
                                while ($selExmneRow = $selExmne->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <?php 
                                            $exmneId = $selExmneRow['exmne_id'];
                                            $selScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND eqt.exam_answer = ea.exans_answer  WHERE ea.axmne_id='$exmneId' AND ea.exam_id='$exam_id' AND ea.exans_status='new' ORDER BY ea.exans_id DESC");

                                              $selAttempt = $conn->query("SELECT * FROM exam_attempt WHERE exmne_id='$exmneId' AND exam_id='$exam_id' ");

                                             $over = $selEx['ex_questlimit_display']  ;    


                                              @$score = $selScore->rowCount();
                                                @$ans = $score / $over * 100;

                                         ?>
                                       <tr style="<?php 
                                                  if ($selAttempt->rowCount() == 0) {
                                                      echo "color: black;";
                                                  } else if ($ans >=90) {
                                                      echo "color: yellow;";
                                                  } else if ($ans >= 70) {
                                                      echo "color: green;";
                                                  } else if ($ans >= 40) {
                                                      echo "color: blue;";
                                                  } else {
                                                      echo "color: red;";
                                                  }
                                              ?>">
                                        <td>

                                          <?php echo $selExmneRow['exmne_fullname']; ?></td>
                                        
                                        <td >
                                        <?php 
                                          if($selAttempt->rowCount() == 0)
                                          {
                                            echo "Not answer yet";
                                          }
                                          else if($selScore->rowCount() > 0)
                                          {
                                            echo $totScore =  $selScore->rowCount();
                                            echo " / ";
                                            echo $over;
                                          }
                                          else
                                          {
                                            echo $totScore =  $selScore->rowCount();
                                            echo " / ";
                                            echo $over;
                                          }

                                            
                                            

                                         ?>
                                        </td>
                                        <td>
                                          <?php 
                                                if($selAttempt->rowCount() == 0)
                                                {
                                                  echo "Not answer yet";
                                                }
                                                else
                                                {
                                                    echo number_format($ans,2); ?>%<?php
                                                }
                                           
                                          ?>
                                        </td>
                                    </tr>
                                <?php }
                             ?>                              
                          </tbody>
                        </table>
                    </div>



                   <?php
                }
                else
                { ?>
                <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div><b>RANKING BY EXAM</b></div>
                    </div>
                </div>
                </div> 

                 <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">ExAM List
                    </div>
                    <div class="table-responsive">
                    <table id="tableList" class="align-middle mb-0 table table-striped table-bordered dataTable" style="width:100%">
                            <thead>
                            <tr>
                                <th class="text-left pl-4">Exam Title</th>
                                <th class="text-left ">Strand</th>
                                <th class="text-left ">Description</th>
                                <th class="text-center" width="8%">Action</th>
                                <th class="text-left ">Date & Time</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php 
                                $selExam = $conn->query("SELECT * FROM exam_tbl ORDER BY ex_id DESC ");
                                if($selExam->rowCount() > 0)
                                {
                                    while ($selExamRow = $selExam->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <tr>
                                            <td class="pl-4"><?php echo $selExamRow['ex_title']; ?></td>
                                            <td>
                                                <?php 
                                                    $courseId =  $selExamRow['cou_id']; 
                                                    $selCourse = $conn->query("SELECT * FROM course_tbl WHERE cou_id='$courseId' ");
                                                    while ($selCourseRow = $selCourse->fetch(PDO::FETCH_ASSOC)) {
                                                        echo $selCourseRow['cou_name'];
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $selExamRow['ex_description']; ?></td>
                                            <td class="text-center">
                                            <a href="?page=ranking-exam&exam_id=<?php echo $selExamRow['ex_id']; ?>" class="btn btn-success btn-sm">
                                                    <i class="fas fa-eye">View</i> <!-- Replace 'fas fa-eye' with the actual class for your desired icon -->
                                            </a>                               
                                            </td>
                                            <td><?php echo $selExamRow['ex_created']; ?></td>
                                        </tr>

                                    <?php }
                                }
                                else
                                { ?>
                                    <tr>
                                      <td colspan="5">
                                        <h3 class="p-3">No Exam Found</h3>
                                      </td>
                                    </tr>
                                <?php }
                               ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>   
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
                <?php }

             ?>      
            
            
      
        
</div>
         


















