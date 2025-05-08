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
            <div class="col-12">

              <div class="card">
                <div class="card-header">
                  <div class="card-title float-left">
                    <h3>Payment Loan History</h3>
                  </div>
                </div>


                <div class="card-body">
                  <table id="example1" class="table table-striped table-bordered">
                    <thead>
                      <tr>

                        <th>Full Name</th>
                        <th>Amount</th>
                        <th>Tenure</th>
                        <th>Interest</th>
                        <th>T/Interest</th>
                        <th>M/Interest</th>
                        <th>T/Payment</th>
                        <th>M/Payment</th>
                        <!-- <th>Started</th> -->


                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $displayPaidLoan = displayPaidLoan($conn);
                      while ($result = mysqli_fetch_array($displayPaidLoan)) {
                        extract($result);
                      ?>
                        <tr>

                          <td><a href="member-profile.php?member_id=<?php echo $member_id ?>"><?php echo $mname ?></a></td>
                          <td><?php echo number_format($amount, 2) ?></td>
                          <td><?php echo $tenure ?> Month</td>
                          <td><?php echo $interest ?>%</td>
                          <td><?php echo $totalinterest ?></td>
                          <td><?php echo $monthlyinterest ?></td>
                          <td><?php echo $totalpayment ?></td>
                          <td class="project-state">
                            <span class="badge badge-success"><?php echo $monthlypayment ?> Paid</span>
                          </td>
                          <!-- <td><?php echo date('M d, Y', strtotime($loanstarted)) ?></td> -->

                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>


                  </table>

                </div>







                <div class="modal fade" id="modal-confirmationEditLoan">
                  <div class="modal-dialog piedad">
                    <form id="confirmationLoanEdit">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Confirm Password</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <input type="password" class="form-control" placeholder="Enter Password" name="admin_pass" required="">
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