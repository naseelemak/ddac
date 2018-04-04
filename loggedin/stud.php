<?php
$currentPage = "agents";


include '../header.php';
include 'misc/sidebar.php';
include 'misc/navbar.php';

$stmt = $conn->prepare('SELECT * FROM `agents`');

// execute query
$stmt->execute();

// Get the result
$result = $stmt->get_result();
?>


<div class="container">
    <div class="row px-2">
        <div class="col-md-12">
            <div class="card bootstrap-table">
                <div class="card-body table-full-width">
                    <table id="bootstrap-table" class="table">
                        <thead>
                        <th data-field="id">TP No</th>
                        <th data-field="course">Course of Study</th>
                        <th data-field="interests">Interests</th>
                        <th data-field="comp-type"> Preferred Competition Type</th>
                        <th data-field="actions" class="td-actions text-center">Action</th>
                        </thead>
                        <tbody>
                        <?php

                        while ($row = $result->fetch_assoc()) {
                            $compType = $row['preferred_comp_type'];

                            echo '<tr>';
                            echo '<td>' . $row['username'] . '</td>';
                            echo '<td>' . $row['course_of_study'] . '</td>';
                            echo '<td>' . $row['interests'] . '</td>';

                            if ($compType == 0) {
                                echo '<td>Individual</td>';
                            } else {
                                echo '<td>Team</td>';
                            }

                            echo '<td><a rel="tooltip" title="View" class="table-action" href="stud-details.php?id=' . $row['username'] . '"><i class="fa fa-eye"></i></a></td>';
                            echo '</tr>';
                        }

                        ?>
                        <tr>
                            <td>TP035405</td>
                            <td>BSc (Hons) in Business Information Systems</td>
                            <td>Machine Learning, Big Data, Marketing</td>
                            <td>Individual</td>
                            <td><a rel="tooltip" title="View" class="table-action" href="comp-details.php"><i
                                            class="fa fa-eye"></i></a></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'misc/sub-footer.php';
include '../footer.php';
?>

<script type="text/javascript">
    //bootstrapTable
    var $table = $('#bootstrap-table');
    $().ready(function () {

        $table.bootstrapTable({
            toolbar: ".toolbar",
            clickToSelect: true,
            search: true,
            showColumns: true,
            pagination: true,
            searchAlign: 'left',
            pageSize: 5,
            clickToSelect: false,
            pageList: [5, 10, 25, 50, 100],

            formatShowingRows: function (pageFrom, pageTo, totalRows) {
                //do nothing here, we don't want to show the text "showing x of y from..."
            },
            formatRecordsPerPage: function (pageNumber) {
                return pageNumber + " rows visible";
            },
            icons: {
                refresh: 'fa fa-refresh',
                toggle: 'fa fa-th-list',
                columns: 'fa fa-columns',
                detailOpen: 'fa fa-plus-circle',
                detailClose: 'fa fa-minus-circle'
            }
        });

        //activate the tooltips after the data table is initialized
        $('[rel="tooltip"]').tooltip();

        $(window).resize(function () {
            $table.bootstrapTable('resetView');
        });


    });
</script>