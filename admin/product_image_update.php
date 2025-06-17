<?php
require '../require/db.php';
require '../require/common.php';
require '../require/common_function.php';
$error = false;
$file_error = '';
$id = isset($_GET['id']) ? $_GET['id'] : '';
if ($id === '') {
    $url = $admin_base_url . "product_list.php?error=ID not found. Create product first";
    header("Location: $url");
} else {
    $res = selectData('products', $mysqli, "WHERE id='$id'");
    if ($res->num_rows == 0) {
        $url = $admin_base_url . "product_list.php?error=ID not found. Create product first";
        header("Location: $url");
    } else {
        $image_res = selectData('product_img', $mysqli, "WHERE product_id='$id'");
    }
}
if (isset($_POST['form_sub']) && $_POST['form_sub'] == '1') {
    $files          = $_FILES['product_img'];
    // var_dump($files);
    // exit;
    $fileName = $files['name'];
    $allowExtension = ['png', 'jpg', 'jpeg'];
    $folder = 'upload/';
    foreach ($fileName as $key => $val) {
        $extension = explode('.', $val);
        $extension = end($extension);
        $tmpPath = $files['tmp_name'][$key];
        if (!in_array($extension, $allowExtension)) {
            $error = true;
            $file_error = " File Only allow png, jpg, jpeg";
        } else {
            if (!file_exists($folder)) {
                mkdir($folder, 755);
            }
            $currentName = date("Ymd_His") . "_" . $val;
            $fullPath = $folder . $currentName;
            $data = [
                'image'         => $currentName,
                'product_id'    => $id
            ];
            $res = insertData('product_img', $mysqli, $data);
            if ($res) {
                $saveImg =  move_uploaded_file($tmpPath, $fullPath);
            }
        }
    }
    if ($saveImg) {
        $url = $admin_base_url . "product_list.php?success=Product Create Success";
        header("Location: $url");
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
            <h1>Product Create</h1>
            <div class="">
                <a href="<?= $admin_base_url . 'product_list.php' ?>" class="btn btn-dark">
                    Back
                </a>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-md-8 col-sm-10 col-12">
                <?php if ($error && $file_error) { ?>
                    <div class="alert alert-danger">
                        <?= $file_error ?>
                    </div>
                <?php } ?>
                <div class="card">
                    <div class="card-body">
                        <form action="<?= $admin_base_url . "product_image.php?id=" . $id ?>" method="POST" enctype="multipart/form-data">
                            <div class="d-flex flex-wrap my-3 preview_img_container" style="gap: 10px;">
                                <?php if ($image_res->num_rows > 0) {
                                    while ($row = $image_res->fetch_assoc()) { ?>
                                        <img src="upload/<?= $row['image'] ?>" class="preview_img">
                                <?php }
                                } ?>
                            </div>
                            <div class="form-group">
                                <input type="file" name="product_img[]" multiple class="form-control" id="product_img">
                                <span class="error_msg text-danger"></span>
                            </div>
                            <input type="hidden" name="form_sub" value="1" />
                            <button type="submit" class="btn btn-primary w-100">Save</button>
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
    $('.error_msg').hide()
    $('#product_img').change(function() {
        const files = $(this)[0]?.files;
        $('.error_msg').hide()
        if (files.length > 5) {
            $('.error_msg').show()
            $('.error_msg').text('File only can fill 5');
            $('#product_img').val('')
            return
        }
        if (files && files.length > 0) {
            $('.preview_img_container').html('');
            Array.from(files).forEach((item) => {
                const fileName = item.name
                const extension = fileName.split('.').pop().toLowerCase()
                if (extension == 'png' ||
                    extension == 'jpg' ||
                    extension == 'jpeg') {
                    const imageUrl = URL.createObjectURL(item);
                    const img = `<img src="${imageUrl}" class="preview_img">`
                    $('.preview_img_container').append(img);
                } else {
                    $('.error_msg').show()
                    $('.preview_img_container').html('');
                    $('.error_msg').text('File only allow png, jpg, jpeg');
                    $('#product_img').val('')
                    return
                }
            });
        }
    });
</script>