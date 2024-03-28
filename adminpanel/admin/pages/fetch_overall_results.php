<?php
$selExmne = $conn->query("SELECT * FROM examinee_tbl et INNER JOIN exam_attempt ea ON et.exmne_id = ea.exmne_id ORDER BY ea.examat_id DESC ");
if ($selExmne->rowCount() > 0) {
    while ($selExmneRow = $selExmne->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td><?php echo $selExmneRow['exmne_fullname']; ?></td>
            <td>
                <?php
                $eid = $selExmneRow['exmne_id'];
                $selExName = $conn->query("SELECT * FROM exam_tbl et INNER JOIN exam_attempt ea ON et.ex_id=ea.exam_id WHERE  ea.exmne_id='$eid' ")->fetch(PDO::FETCH_ASSOC);
                $exam_id = $selExName['ex_id'];
                echo $selExName['ex_title'];
                ?>
            </td>
            <!-- Add other table data here -->
        </tr>
<?php }
} else { ?>
    <tr>
        <td colspan="2">
            <h3 class="p-3">No Course Found</h3>
        </td>
    </tr>
<?php } ?>
