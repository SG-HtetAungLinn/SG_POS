<?php
require '../require/db.php';
require '../require/common.php';
require '../require/common_function.php';
$error = false;
$error_message =
    $name_error =
    $name =
    $percentage_error =
    $percentage =
    $start_date_error =
    $start_date =
    $end_date_error =
    $end_date =  '';

if (isset($_POST['form_sub']) && $_POST['form_sub'] == '1') {
    $name = $mysqli->real_escape_string($_POST['name']);
    $percentage = $mysqli->real_escape_string($_POST['percentage']);
    $start_date = $mysqli->real_escape_string($_POST['start_date']);
    $end_date = $mysqli->real_escape_string($_POST['end_date']);
    if ($name === '' || strlen($name) === 0) {
        $error = true;
        $name_error = "Please Fill Discount Name.";
    } else if (strlen($name) < 3) {
        $error = true;
        $name_error = "Discount name must be fill greater then 3.";
    } else if (strlen($name) > 100) {
        $error = true;
        $name_error = "Discount name must be fill less then 100.";
    }
    if ($percentage === '' || strlen($percentage) === 0) {
        $error = true;
        $percentage_error = "Please Fill Percent.";
    } else if ($percentage > 100) {
        $error = true;
        $percentage_error = "Percent must be under 100%";
    }
    if ($start_date === '' || strlen($start_date) === 0) {
        $error = true;
        $start_date_error = "Please choose start date";
    }
    if ($end_date !== '' && $end_date < $start_date) {
        $error = true;
        $end_date_error = "End date must me greather then start date";
    }
    if (!$error) {
        $data = [
            'name'          => $name,
            'percent'       => $percentage,
            'start_date'    => $start_date,
            'end_date'      => $end_date
        ];
        $result = insertData('discounts', $mysqli, $data);
        if ($result) {
            $url = $admin_base_url . 'discount_list.php?success=Register Success';
            header("Location: $url");
            exit;
        } else {
            $error = true;
            $error_message = "Discount Create Fail.";
        }
    }
}
require './layouts/header.php';
?>

<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <h1>Discount Create</h1>
            <div class="">
                <a href="<?= $admin_base_url . 'discount_list.php' ?>" class="btn btn-dark">
                    Back
                </a>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-md-6 col-sm-10 col-12">
                <?php if ($error && $error_message) { ?>
                    <div class="alert alert-danger">
                        <?= $error_message ?>
                    </div>
                <?php } ?>
                <div class="card">
                    <div class="card-body">
                        <form action="<?= $admin_base_url ?>discount_create.php" method="POST">
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" placeholder="Enter Name" class="form-control" id="name" value="<?= $name ?>" />
                                <?php if ($error && $name_error) { ?>
                                    <span class="text-danger"><?= $name_error ?></span>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="percentage" class="form-label">Percentage</label>
                                <input type="number" placeholder="Enter percent" max="100" name="percentage" class="form-control" id="percentage" value="<?= $percentage ?>" />
                                <?php if ($error && $percentage_error) { ?>
                                    <span class="text-danger"><?= $percentage_error ?></span>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="text" name="start_date" class="form-control" placeholder="Please enter start date" id="start_date" value="<?= $start_date ?>" />
                                <?php if ($error && $start_date_error) { ?>
                                    <span class="text-danger"><?= $start_date_error ?></span>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="text" name="end_date" class="form-control" id="end_date" placeholder="Please enter end date" value="<?= $end_date ?>" />
                                <?php if ($error && $end_date_error) { ?>
                                    <span class="text-danger"><?= $end_date_error ?></span>
                                <?php } ?>
                            </div>
                            <input type="hidden" name="form_sub" value="1" />
                            <button type="submit" class="btn btn-primary w-100">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>
<!--**********************************
            Content body end
        ***********************************-->

<?php
require './layouts/footer.php';
?>
<script>
    $('#start_date').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        minDate: moment()
    }).on('change', function(e, date) {
        // $('#end_date').val('')
        $('#end_date').bootstrapMaterialDatePicker('setMinDate', date);
    });

    $('#end_date').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false
    });
</script>