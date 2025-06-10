<?php
require '../require/db.php';
require '../require/common.php';
require '../require/common_function.php';

$error = false;
$error_message =
    $name_error =
    $name = '';

if (isset($_GET['id']) && $_GET['id'] !== '') {
    $id = $_GET['id'];
    $select_res = selectData('categories', $mysqli, "WHERE id='$id'");
    if ($select_res->num_rows > 0) {
        $data = $select_res->fetch_assoc();
        $name = $data['name'];
    } else {
        $url = $admin_base_url . "category_list.php?error=Id Not Found";
        header("Location: $url");
    }
} else {
    $url = $admin_base_url . "category_list.php?error=Id Not Found";
    header("Location: $url");
}

if (isset($_POST['form_sub']) && $_POST['form_sub'] == '1') {
    $name = $mysqli->real_escape_string($_POST['name']);
    if ($name === '' || strlen($name) === 0) {
        $error = true;
        $name_error = "Please Fill Category Name.";
    } else if (strlen($name) < 3) {
        $error = true;
        $name_error = "Category name must be fill greater then 3.";
    } else if (strlen($name) > 100) {
        $error = true;
        $name_error = "Category name must be fill less then 100.";
    }
    if (!$error) {
        $data = [
            'name' => $name
        ];
        $where = [
            'id' => $id,
        ];
        $result = updateData('categories', $mysqli, $data, $where);
        if ($result) {
            $url = $admin_base_url . 'category_list.php?success=Update Success';
            header("Location: $url");
            exit;
        } else {
            $error = true;
            $error_message = "Category Update Fail.";
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
            <h1>Category Update</h1>
            <div class="">
                <a href="<?= $admin_base_url . 'category_list.php' ?>" class="btn btn-dark">
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
                        <form action="<?= $admin_base_url . 'category_edit.php?id=' . $id ?>" method="POST">
                            <div class="form-group">
                                <label for="" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="name" value="<?= $name ?>" />
                                <?php if ($error && $name_error) { ?>
                                    <span class="text-danger"><?= $name_error ?></span>
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