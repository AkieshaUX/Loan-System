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
          <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-warning"><i style="color: white;" class="fa-solid fa-chart-simple"></i></span>
                <?php
                $query = mysqli_query($conn, "SELECT SUM(withdraw_income) AS total_income FROM orderproduct");
                if ($query) {
                  $result = mysqli_fetch_assoc($query);
                  $total_income = isset($result['total_income']) ? $result['total_income'] : 0.00;
                } else {
                  $total_income = 0.00;
                }
                ?>
                <div class="info-box-content">
                  <span class="info-box-text">Total Sales Income</span>
                  <span class="info-box-number"><?php echo number_format($total_income, 2); ?></span>
                </div>
              </div>

            </div>
          </div>

          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header">
                  <div class="card-title float-left">
                    <h3>Withdraw Sales Summary</h3>
                  </div>
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-withdraw">
                    <i class="fa-solid fa-plus"></i>
                    Withdraw
                  </button>
                </div>


                <div class="card-body">
                  <table id="example1" class="table table-striped">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      date_default_timezone_set('Asia/Manila');
                      $displaywithSales = displaywithSales($conn);
                      while ($result = mysqli_fetch_array($displaywithSales)) {
                        extract($result);
                      ?>
                        <tr>
                          <td><?php echo $admin ?></td>
                          <td><?php echo number_format($amount, 2) ?></td>
                          <td><?php echo $type ?></td>
                          <td><?php echo date('M d, Y - h:i A', strtotime($date)) ?></td>

                          <td class="project-state">
                            <span class="badge badge-success" style="color: #fff;">Withdrawn</span>
                          </td>

                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>

                </div>


                <div class="modal fade" id="modal-withdraw">
                  <div class="modal-dialog" style="max-width: 400px;">
                    <form id="withdrawSales">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Withdraw Sales</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <label>Amount</label>
                          <input name="amount" type="number" class="form-control" placeholder="Enter  Amount" required>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save changes</button>
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