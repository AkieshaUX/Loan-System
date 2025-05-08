<?php include '../inc/session.php'?>
<!DOCTYPE html>
<html lang="en">

<head>

  <head>
    <?php include 'includes/link.php' ?>
  </head>
</head>

<body class="hold-transition sidebar-mini" id="tenantlist">
  <div class="wrapper">
    <?php include 'includes/sidebar.php' ?>


    <div class="content-wrapper">
      <section class="content Pages">
        <div class="container-fluid">

          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header">
                  <div class="card-title float-left">
                    <h3>Product List</h3>
                  </div>
                  <button type="button" class="btn btn-primary float-right mr-3" data-toggle="modal" data-target="#modal-product">
                    <i class="fa-solid fa-plus"></i>
                    Add Product
                  </button>
                </div>


                <div class="card-body">
                  <table id="example1" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 2%;">#</th>
                        <th>Product Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $no = 1;
                      $displayviewProduct = displayviewProduct($conn);
                      while ($result = mysqli_fetch_array($displayviewProduct)) {
                        extract($result);

                        $checkPendingQuery = "SELECT COUNT(*) AS count FROM orderproduct WHERE productsupply_id = $productsupply_id AND status = 'Pending'";
                        $checkResult = $conn->query($checkPendingQuery);
                        $pendingData = $checkResult->fetch_assoc();
                        $isPending = $pendingData['count'] > 0;

                      ?>
                        <tr>
                          <td><?php echo $no ?></td>
                          <td><?php echo $productname ?></td>
                          <td class="text-left">
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-productEdit" id="editproductLIst" data-productsupply-id="<?php echo $productsupply_id; ?>">
                              <i class="fa-solid fa-pen-to-square"></i> Edit
                            </button>

                            <!-- Conditionally disable the Delete button -->
                            <button class="btn btn-danger btn-sm deleteproductBTN" id="deleteproductBTN" data-productsupply-id="<?php echo $productsupply_id; ?>" <?php echo $isPending ? 'disabled' : ''; ?>>
                              <i class="fa-solid fa-trash"></i> Delete
                            </button>
                          </td>
                        </tr>
                      <?php
                        $no++;
                      }
                      ?>
                    </tbody>

                  </table>

                </div>

                <div class="modal fade" id="modal-product">
                  <div class="modal-dialog" style="max-width: 380px !important;">
                    <form id="addproducts" method="POST" action="../inc/controller.php" class="form-horizontal">
                      <div class="tab-content">
                        <div class="loan-form">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Add Product</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                <label>Product Name</label>
                                <input name="productname" type=text" placeholder="Product Name" class="form-control" required>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

                <div class="modal fade" id="modal-productEdit">
                  <div class="modal-dialog" style="max-width: 420px !important;">

                    <div class="tab-content">
                      <div class="loan-form">
                        <form id="editproductForm" method="POST" action="../inc/controller.php" class="form-horizontal">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Update Product</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">

                              <div class="form-group">
                                <label>Product Name</label>
                                <input type="hidden" class="form-control" id="productsupplyID" name="productsupply_id">
                                <div class="piedad">
                                  <input type="text" class="form-control" id="productname" name="productname">
                                </div>
                              </div>


                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

            </div>

          </div>

        </div>

      </section>

    </div>



    <footer class="main-footer">
    </footer>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
  </div>
  <?php include 'includes/script.php' ?>


  



</body>

</html>