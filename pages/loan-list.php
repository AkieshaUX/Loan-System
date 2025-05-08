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
                    <h3>Loan List</h3>
                  </div>
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-registerloan">
                    <i class="fa-solid fa-user-plus"></i>
                    New Loan
                  </button>
                </div>


                <div class="card-body">
                  <table id="example1" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Reference No.</th>
                        <th>Full Name</th>
                        <th>Contact No.</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $displayLoan = displayLoan($conn);
                      
                      while ($result = mysqli_fetch_array($displayLoan)) {
                        extract($result);


                        $paymentCountSql = "SELECT COUNT(*) as payment_count FROM `monthly_payment` WHERE `loan_id` = '$loan_id'";
                        $paymentCountResult = $conn->query($paymentCountSql);
                        $paymentCountRow = $paymentCountResult->fetch_assoc();
                        $paymentCount = $paymentCountRow['payment_count'];


                        $tenureCheckSql = "SELECT `tenure` FROM `monthly_payment` WHERE `loan_id` = '$loan_id' LIMIT 1";
                        $tenureResult = $conn->query($tenureCheckSql);
                        $tenureRow = $tenureResult->fetch_assoc();
                        $tenure = $tenureRow['tenure'];


                        $statusCheckSql = "SELECT `status` FROM `monthly_payment` WHERE `loan_id` = '$loan_id' LIMIT 1";
                        $statusResult = $conn->query($statusCheckSql);
                        $statusRow = $statusResult->fetch_assoc();
                        $paymentStatus = $statusRow['status'];
                      ?>
                        <tr>
                          <td><?php echo $reference ?></td>
                          <td><?php echo $mname ?></td>
                          <td><?php echo $mcontact ?></td>
                          <td><?php echo $maddress ?></td>
                          <td class="project-state">
                            <span class="badge badge-success" style="color: #fff;">Active Loan</span>
                          </td>

                          <td class="text-left">

                            <button class="btn btn-primary btn-sm" id="ViewLoanBTN"
                              data-member-id="<?php echo $member_id; ?>"
                              data-loan-id="<?php echo $loan_id; ?>"
                              data-toggle="modal" data-target="#modal-confirmationViewLoan">
                              <i class="fa-solid fa-address-card"></i> View
                            </button>

                          </td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>


                  </table>

                </div>

                <div class="modal fade" id="modal-registerloan">
                  <div class="modal-dialog" style="max-width: 600px !important;">
                    <form id="REGISTERLoan" method="POST" action="../inc/controller.php" class="form-horizontal">
                      <div class="tab-content">
                        <div class="loan-form">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Register New Loan</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body" style="padding-top:0; padding-bottom:0;">
                              <div class="card-body">
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Full Name</label>
                                  <div class="col-sm-9">
                                    <select class="form-control select2bs4" name="member_id" style="width: 100%;">
                                    <option selected disabled>Select one</option>
                                      <?php
                                      $query = mysqli_query($conn, "SELECT * FROM `member` WHERE mstatus = 0");
                                      while ($result = mysqli_fetch_array($query)) {
                                        extract($result);
                                      ?>
                                    
                                        <option value="<?php echo $member_id ?>"><?php echo $mname ?></option>
                                      <?php    } ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Purpose</label>
                                  <div class="col-sm-9">
                                    <textarea class="form-control" name="purpose" id="inputExperience" placeholder="Purpose" required></textarea>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Amount</label>
                                  <div class="col-sm-9">
                                    <input name="amount" id="amount" type="number" placeholder="Loan Amount" class="form-control" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Loan Tenure</label>
                                  <div class="col-sm-9">
                                    <div class="input-group">
                                      <input name="tenure" id="tenure" type="number" class="form-control" placeholder="Loan Tenure" min="1" max="12" required>
                                      <span class="input-group-text"> Month</span>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Interest</label>
                                  <div class="col-sm-9">
                                   <div class="input-group">
                                   <input name="interest" type="text" class="form-control" value="5" required readonly>
                                   <span class="input-group-text">%</span>
                                   </div>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">T/Interest</label>
                                  <div class="col-sm-9">
                                  <input name="totalinterest" id="totalinterest" type="number" class="form-control" placeholder="NaN" required readonly>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">M/Interest</label>
                                  <div class="col-sm-9">
                                    <input name="monthlyinterest" id="monthlyinterest" type="number" class="form-control" placeholder="NaN" required readonly>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">T/Payment</label>
                                  <div class="col-sm-9">
                                    <input name="totalpayment" id="totalpayment" type="number" class="form-control" placeholder="NaN" required readonly>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">M/Payment</label>
                                  <div class="col-sm-9">
                                    <input name="monthlypayment" id="monthlypayment" type="number" class="form-control" placeholder="NaN" required readonly>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" name="REGISTERLoan" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
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
                                    <input name="tenure" id="tenures" type="number" class="form-control" placeholder="Loan Tenure" min="1" max="12" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Interest</label>
                                  <div class="col-sm-9">
                                    <input name="interest" id="interests" type="text" class="form-control" value="5" required readonly>
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



                <div class="modal fade" id="modal-confirmationLoan">
                  <div class="modal-dialog piedad">
                    <form id="confirmationLoan">
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


                <div class="modal fade" id="modal-confirmationViewLoan">
                  <div class="modal-dialog piedad">
                    <form id="confirmationViewLoan">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Confirm Password</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <input type="hidden" id="memberview" name="member_id">
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