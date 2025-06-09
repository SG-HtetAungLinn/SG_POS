<?php

require './layouts/header.php';

?>

<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <h1>Category Create</h1>
            <div class="">
                <a href="" class="btn btn-dark">
                    Back
                </a>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="col-md-6 col-sm-10 col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="">
                            <div class="form-group">
                                <label for="" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="">
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