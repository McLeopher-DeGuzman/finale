<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Examinee with Pagination</title>
    <link rel="stylesheet" type="text/css" href="css/mycss.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div>MANAGE EXAMINEE</div>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <button class="btn btn-success" data-toggle="modal" data-target="#modalForAddExaminee" style="margin-left: 2%;">
                    <i class="fas fa-plus-circle"></i> Add Examinee
                </button>
            </div>
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">Examinee List</div>
                    <div class="table-responsive">
                        <table id="tableList" class="align-middle mb-0 table table-striped table-bordered dataTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>Birthdate</th>
                                    <th>Strand</th>
                                    <th>Year level</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $selExmne = $conn->query("SELECT * FROM examinee_tbl ORDER BY exmne_id DESC ");
                                if($selExmne->rowCount() > 0)
                                {
                                    while ($selExmneRow = $selExmne->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <tr>
                                            <td><?php echo $selExmneRow['exmne_fullname']; ?></td>
                                            <td><?php echo $selExmneRow['exmne_gender']; ?></td>
                                            <td><?php echo $selExmneRow['exmne_birthdate']; ?></td>
                                            <td>
                                                <?php 
                                                    $exmneCourse = $selExmneRow['exmne_course'];
                                                    $selCourse = $conn->query("SELECT * FROM course_tbl WHERE cou_id='$exmneCourse' ")->fetch(PDO::FETCH_ASSOC);
                                                    echo $selCourse['cou_name'];
                                                ?>
                                            </td>
                                            <td><?php echo $selExmneRow['exmne_year_level']; ?></td>
                                            <td><?php echo $selExmneRow['exmne_email']; ?></td>
                                            <td><?php echo md5($selExmneRow['exmne_password']); ?></td>
                                            <td><?php echo $selExmneRow['exmne_status']; ?></td>
                                            <td>
                                                <a rel="facebox" href="facebox_modal/updateExaminee.php?id=<?php echo $selExmneRow['exmne_id']; ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> 
                                                </a>
                                                <button type="button" id="deleteExaminee" data-id='<?php echo $selExmneRow['exmne_id']; ?>' class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> 
                                                </button>
                                            </td>
                                        </tr>
                                    <?php }
                                }
                                else
                                { ?>
                                    <tr>
                                        <td colspan="9">
                                            <h3 class="p-3">No Examinee Found</h3>
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
                            <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-500 bg-white border border-gray-300 rounded-md shadow-sm">
                                Previous
                            </a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-500 bg-white border border-gray-300 rounded-md shadow-sm">
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
        </div>
    </div>
</body>
</html>
