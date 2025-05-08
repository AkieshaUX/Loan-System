<?php include '../inc/session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <head>
    <?php include 'includes/link.php' ?>
  </head>
</head>
<style>
  #invoiceContent p {
    margin: 0;
    font-size: 13px;
  }

  #invoiceContent h5 {
    font-size: 15px;
    font-weight: bold;
    text-align: left !important;
  }



  .table th,
  .table td {
    padding: 8px;
    text-align: left;
  }

  .table th {
    background-color: #f8f8f8;
  }

  .text-center {
    text-align: center;
  }

  .text-right {
    text-align: right;
  }

  .border-bottom {
    border-bottom: 1px solid #e0e0e0;
  }

  .lead {
    font-size: 1.25em;
    font-weight: bold;
  }

  address {
    font-size: 13px;
  }
</style>

<body class="hold-transition sidebar-mini" id="tenantlist">
  <div class="wrapper">
    <?php include 'includes/sidebar.php' ?>
    <?php
    if (isset($_GET['member_id']) && $_GET['loan_id']) {
      $query = mysqli_query($conn, "SELECT monthly_payment.*, member.* FROM `member` INNER JOIN `monthly_payment` ON member.member_id = monthly_payment.member_id WHERE  member.member_id = $member_id AND loan_id = $loan_id");
      $result = mysqli_fetch_array($query);
      extract($result);
    }
    ?>

    <div class="content-wrapper">
      <section class="content Pages">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fa-solid fa-chart-simple"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Payment</span>
                  <span class="info-box-number"><?php echo number_format($totalpayment, 2); ?></span>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa-solid fa-coins"></i></i></span>
                <?php
                $query = mysqli_query($conn, "SELECT SUM(monthlypayment) AS total_paid FROM payment_history WHERE `status` = 'Paid' AND `member_id` = $member_id AND `loan_id` = $loan_id");
                if ($query) {
                  $result = mysqli_fetch_assoc($query);
                  $total_paid = isset($result['total_paid']) ?  $result['total_paid'] : 0.00;
                } else {
                  $total_paid = 0.00;
                }
                ?>
                <div class="info-box-content">
                  <span class="info-box-text">Total Paid Amount</span>
                  <span class="info-box-number"><?php echo number_format($total_paid, 2); ?></span>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fa-solid fa-question"></i></span>
                <?php
                $query = mysqli_query($conn, "SELECT SUM(monthlypayment) AS total_balance FROM monthly_payment WHERE `status` = 'Unpaid' AND `member_id` = $member_id AND `loan_id` = $loan_id");
                if ($query) {
                  $result = mysqli_fetch_assoc($query);
                  $total_balance = isset($result['total_balance']) ? $result['total_balance'] : 0.00;
                } else {
                  $total_balance = 0.00;
                }
                ?>
                <div class="info-box-content">
                  <span class="info-box-text">Total Balance</span>
                  <span class="info-box-number"><?php echo number_format($total_balance, 2); ?></span>
                </div>
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-md-3">


              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <a class="image-popup-vertical-fit" href="../image/member/PROFILE/<?php echo $mprofile ?>">
                      <img style="width: 140px;height: 140px;" class="profile-user-img img-fluid img-circle" src="../image/member/PROFILE/<?php echo $mprofile ?>">
                    </a>
                  </div>

                  <h3 class="profile-username text-center"><?php echo $mname ?></h3>

                  <p class="text-muted text-center">Member</p>

                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>Loan started</b> <a class="float-right"><?php echo date('M d, Y', strtotime($loanstarted)) ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Purpose</b> <a class="float-right"><?php echo $purpose ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Loan Tenure</b> <a class="float-right"><?php echo $tenure . ' Month/s ' ?></a>
                    </li>


                    <li class="list-group-item">
                      <b>Interest</b> <a class="float-right"><?php echo $interest . ' % ' ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Total Interest</b> <a class="float-right"><?php echo $totalinterest ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Monthly Interest</b> <a class="float-right"><?php echo $monthlyinterest ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Total Payment</b> <a class="float-right"><?php echo $totalpayment ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Monthly Payment</b> <a class="float-right"><?php echo $monthlypayment ?></a>
                    </li>
                  </ul>

                  <a href="member-profile.php?member_id=<?php echo $member_id ?>" class="btn btn-primary btn-block"><b>More Details</b></a>

                </div>

              </div>

            </div>

            <div class="col-md-9">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active " href="#unpaid" data-toggle="tab">Unpaid</a></li>
                    <li class="nav-item"><a class="nav-link" href="#paymenthistory" data-toggle="tab">Payment History</a></li>
                    <li class="nav-item"><a class="nav-link " href="#loanreport" data-toggle="tab">Report</a></li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content">


                    <div class="tab-pane active " id="unpaid">
                      <div class="table-responsive" style="max-height: 38rem;overflow-y: scroll;">
                        <table id="exmaple" class="table table-striped table-bordered">
                          <thead>
                            <tr>

                              <th style="width: 25%;">Due Date</th>
                              <th style="width: 25%;">Monthly Payment</th>
                              <th style="width: 25%;">Status</th>
                              <th style="width: 25%;"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $viewLoanUnpaid = viewLoanUnpaid($conn);
                            $firstUnpaid = true;
                            while ($result = mysqli_fetch_array($viewLoanUnpaid)) {
                              extract($result);
                            ?>
                              <tr>


                                <td><?php echo date('M d, Y', strtotime($duedate)) ?></td>
                                <td><?php echo $monthlypayment ?></td>

                                <td class="project-state">
                                  <span class="badge badge-warning" style="color: #fff;">Unpaid</span>
                                </td>

                                <td class="text-center">
                                  <button class="btn btn-success btn-sm" id="referenceBTN"
                                    data-monthly-id="<?php echo $monthly_payment_id; ?>"
                                    data-toggle="modal"
                                    data-target="#modal-paymentreference"
                                    <?php echo $firstUnpaid ? '' : 'disabled'; ?>>
                                    <i class="fa-brands fa-amazon-pay"></i> PAY
                                  </button>
                                </td>
                              </tr>
                            <?php
                              $firstUnpaid = false;
                            }
                            ?>
                          </tbody>

                        </table>
                      </div>

                    </div>

                    <div class="tab-pane" id="paymenthistory">
                      <div class="table-responsive" style="max-height: 38rem;overflow-y: scroll;">
                        <table id="" class="table table-striped table-bordered">
                          <thead>
                            <tr>


                              <th>Due Date</th>
                              <th>Date Payment</th>
                              <th>Monthly Payment</th>
                              <th>Status</th>
                              <th> Invoice</th>

                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $viewLoanPaid = viewLoanPaid($conn);
                            while ($result = mysqli_fetch_array($viewLoanPaid)) {
                              extract($result);
                            ?>
                              <tr>


                                <td><?php echo date('M d, Y', strtotime($duedate)) ?></td>
                                <td><?php echo date('M d, Y', strtotime($datepayment)) ?></td>
                                <td><?php echo $monthlypayment ?></td>
                                <td class="project-state">
                                  <span class="badge badge-success"><?php echo $status ?></span>
                                </td>
                                <td>
                                  <button class="btn btn-primary btn-sm" id="viewreciept"
                                    data-history-id="<?php echo $payment_history_id; ?>"
                                    data-toggle="modal" data-target="#modal-viewinvoice">
                                    <i class="fa-solid fa-file-invoice"></i>Receipt
                                  </button>
                                </td>

                              </tr>
                            <?php
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>

                    </div>

                    <div class="tab-pane " id="loanreport">


                      <div class="reportprint" id="printPaymentHistory">
                        <div class="post">
                          <h3 style="color: black;">Pineapple Growers and Farmer's Association</h3>
                          <p>Member Name: <strong style="color: black;"> <?php echo $mname ?></strong></p>
                        </div>
                        <table id="" class="table table-striped ">
                          <thead>
                            <tr>

                              <th style="width: 50%;">Due Date</th>
                              <th style="width: 50%;">Monthly Payment</th>

                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $viewLoanUnpaid = viewLoanUnpaid($conn);
                            $firstUnpaid = true;
                            while ($result = mysqli_fetch_array($viewLoanUnpaid)) {
                              extract($result);
                            ?>
                              <tr>
                                <td><?php echo date('M d, Y', strtotime($duedate)) ?></td>
                                <td><?php echo $monthlypayment ?></td>
                              </tr>
                            <?php
                              $firstUnpaid = false;
                            }
                            ?>
                          </tbody>
                        </table>
                        <h4 style="border-top: 1px solid #adb5bd;padding-top: 20px;">Loan Summary</h4>
                        <div class="post">
                          <div class="wrap">
                            <strong>Loan started: <?php echo date('M d, Y', strtotime($loanstarted)) ?></strong>
                            <p id="amount"></p>
                          </div>
                          <div class="wrap">
                            <strong>Loan Amount: <?php echo $amount ?></strong>
                            <p id="amount"></p>
                          </div>
                          <div class="wrap">
                            <strong>Tenure: <?php echo $tenure . ' Month/s ' ?></strong>
                            <p id="tenure"></p>
                          </div>
                          <div class="wrap">
                            <strong>Interest Rate: <?php echo $interest . ' % ' ?></strong>
                            <p id="interest"></p>
                          </div>
                          <div class="wrap">
                            <strong>Total Interest: <?php echo $totalinterest ?></strong>
                            <p id="totalinterest"></p>
                          </div>
                          <div class="wrap">
                            <strong>Monthly Interest: <?php echo $monthlyinterest ?></strong>
                            <p id="monthlyinterest"></p>
                          </div>
                          <div class="wrap">
                            <strong>Total Payment: <?php echo $totalpayment ?></strong>
                            <p id="totalpayment"></p>
                          </div>
                          <div class="wrap">
                            <strong>Monthly Payment: <?php echo $monthlypayment ?></strong>
                            <p id="monthlypayment"></p>
                          </div>
                        </div>
                      </div>
                      <button style="width: 100px;" class="btn btn-primary btn-block" onclick="printPaymentHistory()">Print</button>

                    </div>


                  </div>
                </div>



                <div class="modal fade" id="modal-paymentreference">
                  <div class="modal-dialog piedad">
                    <form id="paymentreference" action="../inc/controller.php" method="POST">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Payment</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <input type="hidden" id="monthly_payment_id" name="monthly_payment_id">
                          <input type="hidden" id="monthlyinterestss" name="monthlyinterest">
                          <input type="hidden" id="loan_id" name="loan_id">
                          <div class="form-group">
                            <label>Amount:</label>
                            <input type="text" class="form-control" id="monthlypaymentss" name="monthlypayment" required readonly>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" name="paymentreference" class="btn btn-primary">Submit Payment</button>
                        </div>
                      </div>
                    </form>

                  </div>

                </div>

                <div class="modal fade" id="modal-viewinvoice">
                  <div class="modal-dialog piedad" style="max-width: 365px  !important;">
                    <form id="confirmationreference">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Payment Receipt</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" id="invoiceContent">
                          <div class="invoice p-3 mb-3">
                            <!-- Header Section -->
                            <div class="row">
                              <div class="col-12 text-left">
                                <strong>
                                  <h5>Pineapple Growers and Farmer's Association</h5>
                                </strong>
                              </div>
                            </div>

                            <!-- Invoice Details -->
                            <div class="row my-3 mt-0 mb-0">
                              <div class="col-6">
                                <p>Invoice Date: <span id="paymentDueDate"></span></p>
                                <p>OR No: <span id="invoiceNumber"></span></p>
                              </div>
                            </div>

                            <!-- Billing Information -->
                            <div class="row border-bottom pb-3 mb-3">
                              <div class="col-12 text-left">
                                <address>
                                  <strong>From:</strong><br>
                                  Pineapple Growers and Farmer's Association<br>
                                  P-7 Sering Basilisa, Dinagat Islands<br>
                                  Philippines
                                </address>
                              </div>

                              <div class="col-12">
                                <address>
                                  <strong>Billed To:</strong><br>
                                  <span id="mname"></span><br>
                                  <span id="maddress"></span><br>
                                  <span id="mcontact"></span>
                                </address>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-12">
                                <strong class="d-flex labelpayment" style="gap: 1px;">
                                  <h5 class="labelpayment">Payment For</h5>
                                  <h5 id="type"></h5>
                                </strong>
                              </div>

                            </div>
                            <div class="row">
                              <div class="col-12">
                                <div class="d-flex">
                                  <p>Due Date:</p>
                                  <p id="duedate"></p>
                                </div>
                                <div class="d-flex">
                                  <p>Amount:</p>
                                  <p><strong id="monthlypayments"></strong></p>
                                </div>
                              </div>
                            </div>

                            <!-- Footer Message -->
                            <div class="row mt-4">
                              <div class="col-12 text-center">
                                <p>Thank you! We appreciate your trust in us and look forward to serving you again.</p>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-default" onclick="printInvoice()">
                            <i class="fas fa-print"></i> Print
                          </button>
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
    $(document).ready(function() {
      $('.image-popup-vertical-fit').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        mainClass: 'mfp-img-mobile',
        image: {
          verticalFit: true
        }
      });
    });
  </script>
  <script type="text/javascript">
    function printPaymentHistory() {
      var printContents = document.getElementById('printPaymentHistory').innerHTML;
      var originalContents = document.body.innerHTML;

      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
    }
  </script>




</body>

</html>