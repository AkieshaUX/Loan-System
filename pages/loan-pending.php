<?php include '../inc/session.php'?>
<!DOCTYPE html>
<html lang="en">

<head>

  <head>
    <?php include 'includes/link.php' ?>
  </head>
</head>
<style>
  .wrap {
    display: flex !important;
    gap: 9px;
  }

  .post:last-of-type {
    border-bottom: 1px solid #adb5bd;
    color: #666;
    margin-bottom: 15px;
    padding-bottom: 15px;
  }

  p {
    font-size: 18px !important;
  }
  
</style>

<body class="hold-transition sidebar-mini" id="tenantlist">
  <div class="wrapper">
    <?php include 'includes/sidebar.php' ?>


    <div class="content-wrapper">
      <section class="content Pages">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fa-solid fa-sack-dollar"></i></span>
                <?php
                $query = mysqli_query($conn, "SELECT SUM(withdraw) AS total_funds FROM funding");
                if ($query) {
                  $result = mysqli_fetch_assoc($query);
                  $total_funds = isset($result['total_funds']) ? $result['total_funds'] : 0.00;
                } else {
                  $total_funds = 0.00;
                }
                ?>
                <div class="info-box-content">
                  <span class="info-box-text">Available Funds</span>
                  <span class="info-box-number"><?php echo number_format($total_funds, 2); ?></span>
                </div>
              </div>

            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-success"><i style="color: #fff;" class="fa-solid fa-sack-xmark"></i></span>
                <?php
                $query = mysqli_query($conn, "SELECT SUM(monthlypayment) AS total_payment, SUM(monthlyinterest) AS total_interest FROM monthly_payment");

                if ($query) {
                  $result = mysqli_fetch_assoc($query);
                  $total_payment = isset($result['total_payment']) ? $result['total_payment'] : 0.00;
                  $total_interest = isset($result['total_interest']) ? $result['total_interest'] : 0.00;
                  $net_total = $total_payment - $total_interest;
                } else {
                  $net_total = 0.00;
                }
                ?>
                <div class="info-box-content">
                  <span class="info-box-text">Total Loan</span>
                  <span class="info-box-number"><?php echo number_format($net_total, 2); ?></span>
                </div>
              </div>


            </div>


            <div class="col-md-3 col-sm-6 col-12">
              <a href="loan-list.php" style="color: black;">
                <div class="info-box">
                  <span class="info-box-icon bg-success"><i class="fa-solid fa-user-group"></i></span>
                  <?php
                  $sql = "SELECT COUNT(*) AS total_borrower FROM `member` WHERE `mstatus` = 1";
                  $query = $conn->query($sql);
                  if ($query) {
                    $result = $query->fetch_assoc();
                    $total_borrower = $result['total_borrower'];

                  ?>
                    <div class="info-box-content">
                      <span class="info-box-text">Total Borrowers</span>
                      <span class="info-box-number"><?php echo $total_borrower ?></span>
                    </div>
                  <?php } ?>

                </div>
              </a>

            </div>

            <div class="col-md-3 col-sm-6 col-12">
              <a href="loan-pending.php" style="color: black;">
                <div class="info-box">
                  <span class="info-box-icon bg-success"><i class="fa-brands fa-wpforms"></i></span>
                  <?php
                  $sql = "SELECT COUNT(*) AS total_pending_loan FROM `loan` WHERE `status` = 'Pending'";
                  $query = $conn->query($sql);
                  if ($query) {
                    $result = $query->fetch_assoc();
                    $total_pending_loan = $result['total_pending_loan'];

                  ?>
                    <div class="info-box-content">
                      <span class="info-box-text">Pending Application</span>
                      <span class="info-box-number"><?php echo $total_pending_loan ?></span>
                    </div>
                  <?php } ?>

                </div>
              </a>

            </div>

          </div>
          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header">
                  <div class="card-title float-left">
                    <h3>Loan Pending</h3>
                  </div>

                </div>


                <div class="card-body">
                  <table id="example1" class="table table-striped">
                    <thead>
                      <tr>

                        <th style="width: 20%;">Full Name</th>
                        <th style="width: 20%;">Purpose</th>
                        <th style="width: 20%;">Date</th>
                        <th style="width: 20%;">Status</th>
                        <th style="width: 20%;"></th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $displayLoanPending = displayLoanPending($conn);
                      while ($result = mysqli_fetch_array($displayLoanPending)) {
                        extract($result);
                      ?>
                        <tr>
                          <td><?php echo $mname ?></td>
                          <td><?php echo $purpose ?></td>
                          <td><?php echo date('M d, Y', strtotime($date))?></td>
                          <td class="project-state">
                            <span class="badge badge-warning" style="color: #fff;"><?php echo $status ?></span>
                          </td>
                       

                          <td class="text-center">

                            <button class="btn btn-primary btn-sm" id="viewloanapplication"
                              data-loan-id="<?php echo $loan_id; ?>"
                              data-toggle="modal" data-target="#modal-viewpendingloan">
                              <i class="fa-solid fa-envelope"></i> View
                            </button>


                            <button class="btn btn-info btn-sm" id="EDITLoanBTN" data-loan-id="<?php echo $loan_id; ?>"
                              data-toggle="modal" data-target="#modal-Editloan">
                              <i class="fa-solid fa-pen-to-square"></i> Edit
                            </button>
                            <button class="btn btn-success btn-sm AcceptBTN" id="AcceptBTN" data-loan-id="<?php echo $loan_id; ?>">
                              <i class="fa-solid fa-thumbs-up"></i> Accept
                            </button>

                          </td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>


                  </table>

                </div>


                <div class="modal fade" id="modal-Editloan">
                  <div class="modal-dialog" style="max-width: 600px !important;">
                    <form id="EDITLoanFORM" method="POST" action="../inc/controller.php" class="form-horizontal">
                      <div class="tab-content">
                        <div class="loan-form">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Update Loan</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body" style="padding-top:0; padding-bottom:0;">
                              <div class="card-body">
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Full Name</label>
                                  <div class="col-sm-9">
                                    <input name="member_id" id="member_id" type="hidden" class="form-control">
                                    <input name="loan_id" id="loan_id" type="hidden" class="form-control">
                                    <input name="oldamount" id="oldamount" value="<?php echo $amount ?>" type="hidden" class="form-control">
                                    <input name="oldtenure" id="oldtenure" value="<?php echo $tenure ?>" type="hidden" class="form-control">
                                    <input name="mname" id="mname" type="text" class="form-control" readonly required>
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Purpose</label>
                                  <div class="col-sm-9">
                                    <textarea class="form-control" name="purpose" id="purposes" required></textarea>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Amount</label>
                                  <div class="col-sm-9">
                                    <input name="amount" id="amounts" type="number" placeholder="Loan Amount" class="form-control" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Loan Tenure</label>
                                  <div class="col-sm-9">
                                    <div class="input-group">
                                      <input name="tenure" id="tenures" type="number" class="form-control" placeholder="Loan Tenure" min="1" max="12" required>
                                      <span class="input-group-text"> Month</span>
                                    </div>

                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Interest</label>
                                  <div class="col-sm-9">
                                    <div class="input-group">
                                      <input name="interest" id="interests" type="text" class="form-control" value="5" required readonly>
                                      <span class="input-group-text">%</span>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">T/Interest</label>
                                  <div class="col-sm-9">
                                    <input name="totalinterest" id="totalinterests" type="number" class="form-control" placeholder="NaN" required readonly>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">M/Interest</label>
                                  <div class="col-sm-9">
                                    <input name="monthlyinterest" id="monthlyinterests" type="number" class="form-control" placeholder="NaN" required readonly>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">T/Payment</label>
                                  <div class="col-sm-9">
                                    <input name="totalpayment" id="totalpayments" type="number" class="form-control" placeholder="NaN" required readonly>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">M/Payment</label>
                                  <div class="col-sm-9">
                                    <input name="monthlypayment" id="monthlypayments" type="number" class="form-control" placeholder="NaN" required readonly>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" name="EDITLoanFORM" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>




                <div class="modal fade" id="modal-viewpendingloan">
                  <div class="modal-dialog">
                    <form id="confirmationViewLoan">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Loan Application Details</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>

                        <div class="modal-body">

                          <div class="post">
                            <div class="user-block">
                              <img id="userImage" class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">

                              <span class="username">
                                <a href="#" id="name"></a>
                              </span>
                              <span class="description">Member</span>
                            </div>
                            <p>
                              Has requested a loan for <em id="purpose"></em> on <strong id="date"></strong>.
                              The status of the loan is currently <strong id="status"></strong>.
                            </p>
                          </div>
                          <div class="post">
                            <div class="wrap">
                              <strong>Loan Amount:</strong>
                              <p id="amount"></p>
                            </div>
                            <div class="wrap">
                              <strong>Tenure:</strong>
                              <p id="tenure"></p>
                            </div>
                            <div class="wrap">
                              <strong>Interest Rate:</strong>
                              <p id="interest"></p>
                            </div>
                            <div class="wrap">
                              <strong>Total Interest:</strong>
                              <p id="totalinterest"></p>
                            </div>
                            <div class="wrap">
                              <strong>Monthly Interest:</strong>
                              <p id="monthlyinterest"></p>
                            </div>
                            <div class="wrap">
                              <strong>Total Payment:</strong>
                              <p id="totalpayment"></p>
                            </div>
                            <div class="wrap">
                              <strong>Monthly Payment:</strong>
                              <p id="monthlypayment"></p>
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
  <script>
    function calculate() {
      // Parse input values
      const principalAmount = parseFloat($('#amount').val().replace(/,/g, '')) || 0;
      const loanPlan = parseInt($('#tenure').val()) || 0;
      const interestRate = 5; // Default interest rate of 5%

      if (principalAmount > 0 && loanPlan > 0) {
        // Calculate monthly interest (simple interest based on full principal)
        const monthlyInterest = principalAmount * (interestRate / 100);

        // Calculate total interest for the loan period
        const totalInterest = monthlyInterest * loanPlan;

        // Calculate total amount to be paid over the loan period
        const totalAmount = principalAmount + totalInterest;

        // Calculate monthly payment
        const monthlyPayment = totalAmount / loanPlan;

        // Update the form fields with calculated values
        $('#monthlypayment').val(monthlyPayment.toFixed(2));
        $('#totalinterest').val(totalInterest.toFixed(2));
        $('#totalpayment').val(totalAmount.toFixed(2));
        $('#monthlyinterest').val(monthlyInterest.toFixed(2));
      } else {
        // Reset the form fields if input is invalid
        $('#monthlypayment, #totalinterest, #totalpayment, #monthlyinterest').val('NaN');
      }
    }

    // Attach the calculate function to input events on tenure and amount fields
    $('.loan-form').on('input', '#tenure, #amount', function() {
      calculate();
    });


    function calculates() {
      // Parse input values
      const principalAmount = parseFloat($('#amounts').val().replace(/,/g, '')) || 0;
      const loanPlan = parseInt($('#tenures').val()) || 0;
      const interestRate = 5; // Default interest rate of 5%

      if (principalAmount > 0 && loanPlan > 0) {
        // Calculate monthly interest (simple interest based on full principal)
        const monthlyInterest = principalAmount * (interestRate / 100);

        // Calculate total interest for the loan period
        const totalInterest = monthlyInterest * loanPlan;

        // Calculate total amount to be paid over the loan period
        const totalAmount = principalAmount + totalInterest;

        // Calculate monthly payment
        const monthlyPayment = totalAmount / loanPlan;

        // Update the form fields with calculated values
        $('#monthlypayments').val(monthlyPayment.toFixed(2));
        $('#totalinterests').val(totalInterest.toFixed(2));
        $('#totalpayments').val(totalAmount.toFixed(2));
        $('#monthlyinterests').val(monthlyInterest.toFixed(2));
      } else {
        // Reset the form fields if input is invalid
        $('#monthlypayments, #totalinterests, #totalpayments, #monthlyinterests').val('NaN');
      }
    }

    // Attach the calculate function to input events on tenure and amount fields
    $('.loan-form').on('input', '#tenures, #amounts', function() {
      calculates();
    });
  </script>


</body>

</html>