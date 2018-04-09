<?php
$currentPage = "Customers";

include 'header.php';
include 'misc/sidebar.php';
include 'misc/navbar.php';

$stmt = $conn->prepare('SELECT * FROM `customers`');

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
                    <a class="btn btn-primary mb-3" href="cust-add.php" style="padding: auto 30px; margin-left; 10px;">Create
                        New</a>&nbsp;&nbsp;
                    <table id="bootstrap-table" class="table">
                        <thead>
                        <th data-field="id">ID</th>
                        <th data-field="name">Name</th>
                        <th data-field="address">Address</th>
                        <th data-field="number">Contact Number</th>
                        <th data-field="actions" class="td-actions text-center">Actions</th>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['id'] . '</td>';
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td>' . $row['address'] . '</td>';
                            echo '<td>' . $row['number'] . '</td>';
                            echo '<td>
                                        <a rel="tooltip" title="Edit" class="table-action" href="cust-edit.php?id=' . $row['id'] . '">
                                        <i class="fa fa-edit text-warning"></i>
                                        </a>
                                        <a rel="tooltip" title="Delete" class="table-action" href="cust-delete.php?id=' . $row['id'] . '" onclick="return checkDelete()">
                                        <i class="fa fa-close text-danger"></i>
                                        </a></td>';
                            echo '</tr>';
                        }

                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'sub-footer.php';
?>

<!-- Delete confirmation prompt -->
<script language="JavaScript" type="text/javascript">
    function checkDelete() {
        return confirm('Are you sure you want to delete this post? Once deleted, it cannot be recovered.');
    }
</script>

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