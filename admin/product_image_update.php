<?php
require '../require/db.php';
require '../require/common.php';
require '../require/common_function.php';
$error = false;
$file_error = '';
$success_msg = isset($_GET['success']) ? $_GET['success'] : '';
$error_msg = isset($_GET['error']) ? $_GET['error'] : '';
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
    $fileName = $files['name'];
    $allowExtension = ['png', 'jpg', 'jpeg'];
    $folder = 'upload/';
    $sql = "SELECT count(id) AS count FROM `product_img` WHERE `product_id`='$id'";
    $res = $mysqli->query($sql);
    $data =  $res->fetch_assoc();
    $dbCount = $data['count'];
    $fileCount  = count($fileName);
    $totalCount = $dbCount + $fileCount;
    if ($totalCount > 5) {
        $error = true;
        $file_error = "Image max can fill 5 files.";
    }
    if (!$error) {
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
            $url = $admin_base_url . "product_image_update.php?id=$id&success=Image Update Success";
            header("Location: $url");
        }
    }
}
if (
    $id &&
    isset($_GET['delete_img_id']) &&
    $_GET['delete_img_id'] !== ''
) {
    $delete_img_id = $_GET['delete_img_id'];
    $selectImg = selectData('product_img', $mysqli, "WHERE product_id='$id' AND `id`='$delete_img_id'");
    if ($selectImg->num_rows > 0) {
        $data = $selectImg->fetch_assoc();
        $imagePath = $data['image'];
        $fullPath = 'upload/' . $imagePath;
        if (unlink($fullPath)) {
            $deleteRes = deleteData('product_img', $mysqli, "`id`='$delete_img_id'");
            if ($deleteRes) {
                $url = $admin_base_url . "product_image_update.php?id=$id&success=Image Delete Success";
                header("Location: $url");
                exit;
            }
        }
    } else {
        $url = $admin_base_url . "product_image_update.php?id=$id&error=Image Not Found";
        header("Location: $url");
        exit;
    }
}
require './layouts/header.php';
?>
<style>
    .preview_img {
        position: relative;
        width: 300px;
        height: 300px;
        z-index: 1;
    }

    .preview_img img {
        width: 100%;
        height: 100%;
    }

    .img_delete_btn {
        position: absolute;
        right: 10px;
        top: 10px;
        background-color: gray;
        color: #fff;
        width: 30px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        transition: .3s;
        text-decoration: none;
        border: none;
        outline: none;
    }

    .img_delete_btn:hover {
        transform: scale(1.2);
        color: #fff;
    }
</style>
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
        <div class="row">
            <div class="col-md-4 offset-md-8 col-sm-6 offset-sm-6">
                <?php if ($success_msg !== '') { ?>
                    <div class="alert alert-success">
                        <?= $success_msg ?>
                    </div>
                <?php } ?>
                <?php if ($error_msg !== '') { ?>
                    <div class="alert alert-danger">
                        <?= $error_msg ?>
                    </div>
                <?php } ?>
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
                        <form action="<?= $admin_base_url . "product_image_update.php?id=" . $id ?>" id="update_img" method="POST" enctype="multipart/form-data">
                            <div class="d-flex flex-wrap my-3 preview_img_container" style="gap: 10px;">
                                <?php if ($image_res->num_rows > 0) {
                                    while ($row = $image_res->fetch_assoc()) { ?>
                                        <div class="preview_img">
                                            <img src="upload/<?= $row['image'] ?>">
                                            <button type="button" data-img_id="<?= $row['id'] ?>" data-id="<?= $id ?>" class="img_delete_btn">X</button>
                                        </div>
                                <?php }
                                } ?>
                            </div>
                            <div class="form-group">
                                <input type="file" name="product_img[]" multiple class="form-control" id="product_img">
                                <span class="error_msg text-danger"></span>
                            </div>
                            <input type="hidden" name="form_sub" value="1" />
                            <button type="submit" class="d-none btn btn-primary w-100">Save</button>
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
    $(document).ready(function() {
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
                // $('.preview_img_container').html('');
                Array.from(files).forEach((item) => {
                    const fileName = item.name
                    const extension = fileName.split('.').pop().toLowerCase()
                    if (extension == 'png' ||
                        extension == 'jpg' ||
                        extension == 'jpeg') {
                        const imageUrl = URL.createObjectURL(item);
                        const img = `<img src="${imageUrl}" class="preview_img">`
                        $('.preview_img_container').append(img);
                        $('#update_img').submit();
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
        $('.img_delete_btn').click(function() {
            const id = $(this).data('id')
            const img_id = $(this).data('img_id')
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'product_image_update.php?id=' + id + '&delete_img_id=' + img_id
                }
            });

        })
    })
</script>