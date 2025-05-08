<?php include '../inc/session.php' ?>
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

          <!-- <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
              <a href=" product-list.php">
                <div class="info-box">
                  <span class="info-box-icon bg-primary"><i class="fa-solid fa-layer-group"></i></span>
                  <?php
                  $query = mysqli_query($conn, "SELECT count(productname) AS total_categories FROM productsupply WHERE productsupply_status IS NULL");
                  if ($query) {
                    $result = mysqli_fetch_assoc($query);
                    $total_categories = isset($result['total_categories']) ? $result['total_categories'] : 0;
                  } else {
                    $total_categories = 0;
                  }
                  ?>
                  <div class="info-box-content">
                    <span class="info-box-text">Products List</span>
                    <span class="info-box-number"><?php echo $total_categories; ?></span>
                  </div>
                </div>
              </a>

            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fa-solid fa-chart-bar"></i></span>
                <?php
                $query = mysqli_query($conn, "SELECT SUM(quantity) AS total_quantity FROM product");
                if ($query) {
                  $result = mysqli_fetch_assoc($query);
                  $total_quantity = isset($result['total_quantity']) ? $result['total_quantity'] : 0;
                } else {
                  $total_quantity = 0;
                }
                ?>
                <div class="info-box-content">
                  <span class="info-box-text">Total Products</span>
                  <span class="info-box-number"><?php echo number_format($total_quantity, 2); ?></span>
                </div>
              </div>


            </div>

          </div> -->

          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header">
                  <div class="card-title float-left">
                    <h3>Stocks</h3>
                  </div>
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-addsupply">
                    <i class="fa-solid fa-plus"></i>
                    Add Stocks
                  </button>
                </div>


                <div class="card-body">
                  <table id="example1" class="table table-striped table-bordered">
                    <thead>
                      <tr>

                        <th>Product Name</th>
                        <!-- <th>Total Quantity</th> -->
                        <th>Qty Stock</th>
                        <th>Price</th>
                        <th>Details</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $displayProduct = displayProduct($conn);
                      while ($result = mysqli_fetch_array($displayProduct)) {
                        extract($result);



                      ?>
                        <tr>

                          <td><?php echo  $productname ?></td>
                          <!-- <td><?php echo number_format($total_quantity) ?></td> -->
                          <td><?php echo number_format($total_quantity) ?></td>

                          <td><?php echo number_format($price, 2) ?></td>
                          <td>
                            <a class="btn btn-info btn-sm" href="stock-details.php?productsupply_id=<?php echo $productsupply_id?>&price=<?php echo $price?>">
                              <i class="fa-solid fa-circle-info"></i> Details
                            </a>
                          </td>





                          <!-- <td class="text-center">

                            <button class="btn btn-success btn-sm" id="plusBTN" data-product-id="<?php echo $product_id; ?>"
                              data-toggle="modal" data-target="#modal-plus">
                              <i class="fa-solid fa-plus"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" id="minusBTN" data-product-id="<?php echo $product_id; ?>"
                              data-toggle="modal" data-target="#modal-minus">
                              <i class="fa-solid fa-minus"></i>
                            </button>
                            <button class="btn btn-info btn-sm" id="EDITproductBTN" data-product-id="<?php echo $product_id; ?>"
                              data-toggle="modal" data-target="#modal-editsupply">
                              <i class="fa-solid fa-pen-to-square"></i> Edit
                            </button>

                            <button class="btn btn-danger btn-sm deleteproductBTNLIST" id="deleteproductBTNLIST" data-product-id="<?php echo $product_id; ?>" <?php echo $isPending ? 'disabled' : ''; ?>>
                              <i class="fa-solid fa-trash"></i> Delete
                            </button>

                          </td> -->
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>


                  </table>

                </div>



                <div class="modal fade" id="modal-details">
                  <div class="modal-dialog" style="max-width: 600px  !important;">
                    <div class="modal-content">
                      <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body pl-0 pr-0">
                        <div class="card-body">
                          <table id="example1" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th style="width: 2%;">Order ID</th>
                                <th>Product Name</th>
                                <th>Total Cost</th>
                                <th>Date</th>
                              </tr>
                            </thead>

                            <tbody>
                              <?php
                              // Assuming displayMiscellaneous() fetches all product data
                              $displayMiscellaneous = displayMiscellaneous($conn);
                              while ($result = mysqli_fetch_array($displayMiscellaneous)) {
                                extract($result);
                              ?>
                                <tr class="clickable-row" data-productsupply-id="<?php echo $productsupply_id; ?>">
                                  <td style="color: #007bff;"><?php echo $pID ?></td>
                                  <td><?php echo $productname ?></td>
                                  <td><?php echo number_format($coast ?? 0, 2); ?></td>
                                  <td><?php echo date('M d, Y', strtotime($productdate)) ?></td>
                                </tr>
                              <?php } ?>
                            </tbody>
                          </table>

                        </div>
                      </div>

                    </div>
                  </div>
                </div>














                <div class="modal fade" id="modal-addsupply">
                  <div class="modal-dialog" style="max-width: 525px !important;">
                    <form id="addproduct" method="POST" action="../inc/controller.php" class="form-horizontal">
                      <div class="tab-content">
                        <div class="loan-form">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Add Stocks</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body" style="padding-top:0; padding-bottom:0;">
                              <div class="card-body">
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Product Name</label>
                                  <div class="col-sm-9">
                                    <select class="form-control select2bs4" data-placeholder="Select Product" name="productsupply_id" style="width: 100%;">
                                      <option selected disabled>Select one</option>
                                      <?php
                                      $query = mysqli_query($conn, "SELECT * FROM `productsupply` WHERE productsupply_status IS NULL");
                                      while ($result = mysqli_fetch_array($query)) {
                                        extract($result);
                                      ?>

                                        <option value="<?php echo $productsupply_id ?>"><?php echo $productname ?></option>
                                      <?php    } ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Quantity</label>
                                  <div class="col-sm-9">
                                    <input name="quantity" type="number" class="form-control" placeholder="Quantity" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Price</label>
                                  <div class="col-sm-9">
                                    <input name="price" type="number" class="form-control" placeholder="Price" required>
                                  </div>
                                </div>
                                <div class="form-group row ">
                                  <label class="col-sm-3 col-form-label">Cost</label>
                                  <div class="col-sm-9">
                                    <input type="text" class="form-control" id="coast" name="coast" placeholder="Cost">
                                  </div>
                                </div>

                                <!-- <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Date</label>
                                  <div class="col-sm-9">
                                    <input name="date" type="date" class="form-control" placeholder="Date" min="<?php echo date('Y-m-d'); ?>" required>
                                  </div>
                                </div> -->


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

                <div class="modal fade" id="modal-editsupply">
                  <div class="modal-dialog" style="max-width: 525px !important;">
                    <form id="Editproduct" method="POST" action="../inc/controller.php" class="form-horizontal">
                      <div class="tab-content">
                        <div class="loan-form">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Edit Stocks</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body" style="padding-top:0; padding-bottom:0;">
                              <div class="card-body">
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Product Name</label>
                                  <div class="col-sm-9">
                                    <select class="form-control select2bs4" data-placeholder="Select Product" name="productsupply_id" id="productsupply_id" style="width: 100%;" disabled>
                                      <?php
                                      $query = mysqli_query($conn, "SELECT * FROM `productsupply`");
                                      while ($result = mysqli_fetch_array($query)) {
                                        extract($result);
                                      ?>
                                        <option value="<?php echo $productsupply_id ?>"><?php echo $productname ?></option>
                                      <?php } ?>
                                    </select>


                                  </div>
                                </div>

                                <div class="form-group row">
                                  <input type="hidden" name="product_id" id="productIDS">
                                  <input type="hidden" name="productsupply_id" id="productsupplyID">
                                  <label class="col-sm-3 col-form-label">Price</label>
                                  <div class="col-sm-9">
                                    <input name="price" id="price" type="number" class="form-control" placeholder="Price" required>
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Date</label>
                                  <div class="col-sm-9">
                                    <input name="date" id="date" type="date" class="form-control" placeholder="Date" required>
                                  </div>
                                </div>

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

                <div class="modal fade" id="modal-plus">
                  <div class="modal-dialog" style="max-width: 380px !important;">
                    <form id="plusquantityForm" method="POST" action="../inc/controller.php" class="form-horizontal">
                      <div class="tab-content">
                        <div class="loan-form">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Total quantity: <span id="plustotalquantitytext"></span></h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body pl-0 pr-0">
                              <div class="card-body">
                                <div class="form-group ">
                                  <label>Add Quantity</label>
                                  <input type="hidden" name="product_id" id="plusproduct_id">
                                  <input name="plusquantity" type="number" class="form-control" placeholder="Add new quantity" required>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Add new</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

                <div class="modal fade" id="modal-minus">
                  <div class="modal-dialog" style="max-width: 380px !important;">
                    <form id="minusquantityForm" method="POST" action="../inc/controller.php" class="form-horizontal">
                      <div class="tab-content">
                        <div class="loan-form">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Total quantity: <span id="minustotalquantitytext"></span></h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body pl-0 pr-0">
                              <div class="card-body">
                                <div class="form-group ">
                                  <label>Minus Quantity</label>
                                  <input type="hidden" name="product_id" id="minusproduct_id">
                                  <input name="minusquantity" type="number" class="form-control" placeholder="Minus quantity" required>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Minus</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
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