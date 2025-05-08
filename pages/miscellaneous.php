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
                    <h3>Cost</h3>
                  </div>
                </div>


                <div class="card-body">

                  <table id="example1" class="table table-striped">
                    <thead>
                      <tr>

                        <th style="width: 2%;">Order ID</th>
                        <th>Product Name</th>
                        <th>Total Cost</th>
                        <th>Date</th>
                        <th></th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php

                      $displayMiscellaneous = displayMiscellaneous($conn);
                      while ($result = mysqli_fetch_array($displayMiscellaneous)) {
                        extract($result);



                      ?>
                        <tr>

                          <td style="color: #007bff;"><?php echo  $pID ?></td>
                          <td><?php echo $productname ?></td>
                          <td><?php echo number_format($coast ?? 0, 2); ?></td>

                          <td><?php echo date('M d, Y', strtotime($productdate)) ?></td>
                          <td class="text-center">
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-misllaneous" id="editmisllaneous" data-product-id="<?php echo $product_id; ?>">
                              <i class="fa-solid fa-pen-to-square"></i> Edit
                            </button>

                          </td>
                        </tr>
                      <?php

                      }
                      ?>
                    </tbody>

                  </table>
                  

                </div>



                <div class="modal fade" id="modal-misllaneous">
                  <div class="modal-dialog" style="max-width: 420px !important;">

                    <div class="tab-content">
                      <div class="loan-form">
                        <form id="misllaneousForm" method="POST" action="../inc/controller.php" class="form-horizontal">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Update Cost</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">

                              <div class="form-group">
                                <label>Order ID</label>
                                <input type="hidden" class="form-control" id="product_id" name="product_id">
                                <div class="piedad">
                                  <input type="text" class="form-control" id="pID" name="pID" readonly>
                                </div>
                              </div>

                              <div class="form-group">
                                <label>Cost</label>
                                <div class="piedad">
                                  <input type="text" class="form-control" id="coast" name="coast" placeholder="Cost">
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