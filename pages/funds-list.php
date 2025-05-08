<?php include '../inc/session.php'?>
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
  }



  #invoiceContent th,
  #invoiceContent td {
    padding: 8px;
    text-align: left;
  }

  #invoiceContent th {
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


    <div class="content-wrapper">
      <section class="content Pages">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fa-solid fa-sack-dollar"></i></span>
                <?php
                $query = mysqli_query($conn, "SELECT SUM(mshare) AS total_mshare FROM share");
                if ($query) {
                  $result = mysqli_fetch_assoc($query);
                  $total_mshare = isset($result['total_mshare']) ? $result['total_mshare'] : 0.00;
                } else {
                  $total_mshare = 0.00;
                }
                ?>
                <div class="info-box-content">
                  <span class="info-box-text">Total Shares </span>
                  <span class="info-box-number"><?php echo number_format($total_mshare, 2); ?></span>
                </div>
              </div>

            </div>
          </div>

          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header">
                  <div class="card-title float-left">
                    <h3>Shares  Summary</h3>
                  </div>
                </div>


                <div class="card-body">
                  <table id="example1" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Full Name</th>
                        <th>Total Shares </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $displayhighfunds = displayhighfunds($conn);
                      while ($result = mysqli_fetch_array($displayhighfunds)) {
                        extract($result);
                      ?>
                        <tr>

                          <td><?php echo $mname ?></td>
                          <td><a href="funds.php?member_id=<?php echo $member_id?>"><?php echo number_format($total_mshare, 2) ?></a></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>

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