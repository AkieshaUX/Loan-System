$(document).ready(function () {


  $('#REGISTERMEMBER').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm the member registration.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, register!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("REGISTERMEMBER", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            Swal.fire({
              position: "top-end",
              title: "Success!",
              text: "Member registered successfully!",
              icon: "success",
              showConfirmButton: false,
              timer: 1500
            });
            setTimeout(function () {
              location.reload();
            }, 1600);
          },

        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#REGISTERMEMBER')[0].reset();
      }

    });

  });

  $(document).on('click', '#EDITMEMBER', function () {
    var memberID = $(this).data('member-id');
    $.ajax({
      type: "GET",
      url: "../inc/controller.php",
      data: { member_id: memberID },
      dataType: "json",
      success: function (data) {

        $('#memberID').val(data.member_id);
        $('#mname').val(data.mname);
        $('#mgender').val(data.mgender);
        $('#mcontact').val(data.mcontact);
        $('#mbdate').val(data.mbdate);
        $('#maddress').val(data.maddress);
        $('#current_mprofile').val(data.mprofile);
        $('#current_mvalidID').val(data.mvalidID);

        $('#bname').val(data.bname);
        $('#bgender').val(data.bgender);
        $('#bcontact').val(data.bcontact);
        $('#bdate').val(data.bdate);
        $('#baddress').val(data.baddress);
        $('#brelation').val(data.brelation);
        $('#current_bprofile').val(data.bprofile);
        $('#current_bvalidID').val(data.bvalidID);
      }
    });
  });

  $('#UPDATEMEMBER').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm the member update.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, update!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("UPDATEMEMBER", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            Swal.fire({
              position: "top-end",
              title: "Success!",
              text: "Member updated successfully!",
              icon: "success",
              showConfirmButton: false,
              timer: 1500
            });
            setTimeout(function () {
              location.reload();
            }, 1600);
          },

        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#UPDATEMEMBER')[0].reset();
      }

    });

  });





  $(document).on('click', '.removemember', function (event) {
    event.preventDefault();
    var memberID = $(this).data('member-id');
    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm the member deletion.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete!"
    }).then((result) => {
      if (result.isConfirmed) {
        $('#modal-confirmationDelete').modal('show');
        $('#confirmationDeleteMember').data('member-id', memberID);
      }
    });
  });
  $('#confirmationDeleteMember').on('submit', function (event) {
    event.preventDefault();
    var memberID = $(this).data('member-id');
    var formData = new FormData(this);
    formData.append("confirmationDeleteMember", "true");

    $.ajax({
      url: "../inc/confirmpass.php",
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.trim() == '1') {
          var deleteMemberData = new FormData();
          deleteMemberData.append("member_id", memberID);
          deleteMemberData.append("removemember", "true");

          $.ajax({
            url: "../inc/controller.php",
            type: 'POST',
            data: deleteMemberData,
            processData: false,
            contentType: false,
            success: function (response) {
              Swal.fire({
                position: "top-end",
                title: "Deleted!",
                text: "Member deleted successfully!",
                icon: "success",
                showConfirmButton: false,
                timer: 1500
              });
              setTimeout(function () {
                location.reload();
              }, 1600);
            }
          });
        } else {
          Swal.fire("Incorrect password", "The password you entered is incorrect.", "error");
        }
      }
    });
  });



  $('#ADDNEWFUNDS').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm the addition of new funds.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, add funds!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("ADDNEWFUNDS", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            Swal.fire({
              position: "top-end",
              title: "Success!",
              text: "Funds or share capital added successfully!",
              icon: "success",
              showConfirmButton: false,
              timer: 1500
            });
            setTimeout(function () {
              location.reload();
            }, 1600);
          },

        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#ADDNEWFUNDS')[0].reset();
      }

    });

  });









  $(document).on('click', '#EDITFUNDS', function () {
    var shareID = $(this).data('share-id');
    $.ajax({
      type: "GET",
      url: "../inc/controller.php",
      data: { share_id: shareID },
      dataType: "json",
      success: function (data) {

        $('#shareID').val(data.share_id);
        $('#mshare').val(data.mshare);

      }
    });
  });


  $(document).on('click', '#viewreciept', function () {
    var shareID = $(this).data('share-id');
    $.ajax({
      type: "GET",
      url: "../inc/controller.php",
      data: { share_id: shareID },
      dataType: "json",
      success: function (data) {

        var formattedDate = new Date(data.date).toLocaleDateString('en-US', {
          month: 'short',
          day: 'numeric',
          year: 'numeric'
        });

        function formatNumber(num) {
          return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        $('#shareID').val(data.share_id);
        $('#invoice_number').text(data.invoice_number);
        $('#member_id').text(data.member_id);
        $('#mname').text(data.mname);
        $('#type').text(data.type + ' ' + 'Fee');
        $('#date').text(formattedDate);
        $('#maddress').text(data.maddress);
        $('#mcontact').text(data.mcontact);
        $('#mshares').text('₱' + formatNumber(data.mshare));


      }
    });
  });



  $('#EDITFUNDSFORM').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm the funds update.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, update funds!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("EDITFUNDSFORM", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            Swal.fire({
              position: "top-end",
              title: "Success!",
              text: "Funds updated successfully!",
              icon: "success",
              showConfirmButton: false,
              timer: 1500
            });
            setTimeout(function () {
              location.reload();
            }, 1600);
          },

        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#EDITFUNDSFORM')[0].reset();
      }

    });

  });






  $('#REGISTERLoan').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm the loan registration.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, register loan!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("REGISTERLoan", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            var jsonResponse = JSON.parse(response);

            if (jsonResponse.status === 'error') {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: jsonResponse.message
              });
            } else {
              Swal.fire({
                position: "top-end",
                title: "Success!",
                text: "Loan registration successfully!",
                icon: "success",
                showConfirmButton: false,
                timer: 1500
              });
              setTimeout(function () {
                location.reload();
              }, 1600);
            }
          },
          error: function () {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong. Please try again later.'
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#REGISTERLoan')[0].reset();
      }
    });
  });


  $(document).on('click', '#EDITLoanBTN', function () {
    var loanID = $(this).data('loan-id');
    $.ajax({
      type: "GET",
      url: "../inc/controller.php",
      data: { loan_id: loanID },
      dataType: "json",
      success: function (data) {

        $('#member_id').val(data.member_id);
        $('#loan_id').val(data.loan_id);
        $('#mname').val(data.mname);
        $('#purposes').val(data.purpose);
        $('#amounts').val(data.amount);
        $('#oldamount').val(data.amount);
        $('#tenures').val(data.tenure);
        $('#totalinterests').val(data.totalinterest);
        $('#monthlyinterests').val(data.monthlyinterest);
        $('#totalpayments').val(data.totalpayment);
        $('#monthlypayments').val(data.monthlypayment);


      }
    });
  });


  $('#EDITLoanFORM').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm the loan update.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, update loan!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("EDITLoanFORM", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            var jsonResponse = JSON.parse(response);

            if (jsonResponse.status === 'error') {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: jsonResponse.message
              });
            } else {
              Swal.fire({
                position: "top-end",
                title: "Success!",
                text: "Loan updated successfully!",
                icon: "success",
                showConfirmButton: false,
                timer: 1500
              });
              setTimeout(function () {
                location.reload();
              }, 1600);
            }
          },
          error: function () {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong. Please try again later.'
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#EDITLoanFORM')[0].reset();
      }
    });
  });


  $(document).on('click', '#AcceptBTN', function () {
    var loanID = $(this).data('loan-id'); // Get loan ID from data attribute

    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this action!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, accept it!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST", // Use POST instead of GET
          url: "../inc/controller.php", // URL to server-side script
          data: {
            loan_id: loanID,
            AcceptBTN: true,
          },
          dataType: "json", // Expect JSON response from the server
          success: function (data) {
            // Check if there's an error due to insufficient funds
            if (data.status === 'error') {
              Swal.fire({
                position: "top-end",
                title: "Error!",
                text: data.message, // Display the error message from server
                icon: "error",
                showConfirmButton: false,
                timer: 1500
              });
            } else if (data.status === 'success') {
              Swal.fire({
                position: "top-end",
                title: "Accepted!",
                text: "The loan has been approved.",
                icon: "success",
                showConfirmButton: false,
                timer: 1500
              }).then(() => {
                window.location.reload(); // Reload the page to reflect changes
              });
            }
          },
          error: function () {
            Swal.fire({
              position: "top-end",
              title: "Error!",
              text: "There was an issue. Please try again.",
              icon: "error",
              showConfirmButton: false,
              timer: 1500
            });
          }
        });
      }
    });
  });





  $(document).on('click', '#viewloanapplication', function () {
    var loanID = $(this).data('loan-id');

    $.ajax({
      type: "GET",
      url: "../inc/controller.php",
      data: { loan_id: loanID },
      dataType: "json",
      success: function (data) {
        var formattedDate = new Date(data.date).toLocaleDateString('en-US', {
          month: 'short',
          day: 'numeric',
          year: 'numeric'
        });

        function formatNumber(num) {
          return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        $('#loan_id').val(data.loan_id);
        $('#member_id').val(data.member_id);
        $('#name').text(data.mname);
        $('#purpose').text(data.purpose);
        $('#date').text(formattedDate);
        $('#status').text(data.status);
        $('#amount').text('₱' + formatNumber(data.amount));
        $('#tenure').text(data.tenure + '/' + 'Month');
        $('#interest').text(data.interest + '%');
        $('#totalinterest').text('₱' + formatNumber(data.totalinterest));
        $('#monthlyinterest').text('₱' + formatNumber(data.monthlyinterest));
        $('#totalpayment').text('₱' + formatNumber(data.totalpayment));
        $('#monthlypayment').text('₱' + formatNumber(data.monthlypayment));

        if (data.mprofile) {
          $('#userImage').attr('src', '../image/member/PROFILE/' + data.mprofile);
        } else {
          $('#userImage').attr('src', '../../dist/img/default-user.png');
        }
      }
    });
  });



  $(document).on('click', '#ViewLoanBTN', function () {
    var memberID = $(this).data('member-id');
    var loanID = $(this).data('loan-id');
    $.ajax({
      type: "GET",
      url: "../inc/controller.php",
      data: { member_id: memberID },
      dataType: "json",
      success: function (data) {
        $('#memberview').val(data.member_id);
        window.location.href = "view-loan.php?member_id=" + memberID + "&loan_id=" + loanID;
      }
    });
  });


  $(document).on('click', '#viewreciept', function () {
    var historyID = $(this).data('history-id');
    $.ajax({
      type: "GET",
      url: "../inc/controller.php",
      data: { payment_history_id: historyID },
      dataType: "json",
      success: function (data) {
        var formattedDate = new Date(data.datepayment).toLocaleDateString('en-US', {
          month: 'short',
          day: 'numeric',
          year: 'numeric'
        });

        var formattedDates = new Date(data.duedate).toLocaleDateString('en-US', {
          month: 'short',
          day: 'numeric',
          year: 'numeric'
        });

        function formatNumber(num) {
          return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        $('#mname').text(data.mname);
        $('#maddress').text(data.maddress);
        $('#mcontact').text(data.mcontact);
        $('#invoiceNumber').text(data.reference_payment);
        $('#reference').text(data.reference);
        $('#type').text(data.type);
        $('#paymentDueDate').text(formattedDate);
        $('#duedate').text(formattedDates);
        $('#monthlypayments').text('₱' + formatNumber(data.monthlypayment));

      }
    });
  });

  $(document).on('click', '#paidviewinvoice', function () {
    var historyID = $(this).data('history-id');
    $.ajax({
      type: "GET",
      url: "../inc/controller.php",
      data: { payment_history_id: historyID },
      dataType: "json",
      success: function (data) {
        var formattedDate = new Date(data.datepayment).toLocaleDateString('en-US', {
          month: 'short',
          day: 'numeric',
          year: 'numeric'
        });

        var formattedDates = new Date(data.duedate).toLocaleDateString('en-US', {
          month: 'short',
          day: 'numeric',
          year: 'numeric'
        });

        function formatNumber(num) {
          return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        $('#mnames').text(data.mname);
        $('#maddresss').text(data.maddress);
        $('#mcontacts').text(data.mcontact);
        $('#invoiceNumber').text(data.reference_payment);
        $('#reference').text(data.reference);
        $('#types').text(data.type);
        $('#paymentDueDate').text(formattedDate);
        $('#duedate').text(formattedDates);
        $('#monthlypayments').text('₱' + formatNumber(data.monthlypayment));

      }
    });
  });





  $(document).on('click', '#viewfundsBTN', function () {
    var memberID = $(this).data('member-id');
    $.ajax({
      type: "GET",
      url: "../inc/controller.php",
      data: { member_id: memberID },
      dataType: "json",
      success: function (data) {
        window.location.href = "funds.php?member_id=" + memberID;
      }
    });
  });




  $(document).on('click', '#referenceBTN', function () {
    var monthlyID = $(this).data('monthly-id');
    $.ajax({
      type: "GET",
      url: "../inc/controller.php",
      data: { monthly_payment_id: monthlyID },
      dataType: "json",
      success: function (data) {

        $('#member_id').val(data.member_id);
        $('#monthly_payment_id').val(data.monthly_payment_id);
        $('#monthlyinterestss').val(data.monthlyinterest);
        $('#monthlypaymentss').val(data.monthlypayment);
        $('#loan_id').val(data.loan_id);



      }
    });
  });

  $('#paymentreference').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Confirm Update",
      text: "Are you sure you want to confirm this payment?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, update it!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("paymentreference", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            if (response.trim() === 'last_payment') {
              Swal.fire({
                position: "top-end",
                title: "Update Successful",
                text: "All payments are completed. Redirecting to loan list.",
                icon: "success",
                showConfirmButton: false,
                timer: 1500
              });
              setTimeout(function () {
                window.location.href = "loan-list.php";
              }, 1600);
            } else {
              Swal.fire({
                position: "top-end",
                title: "Update Successful",
                text: "The payment has been confirmed successfully.",
                icon: "success",
                showConfirmButton: false,
                timer: 1500
              });
              setTimeout(function () {
                location.reload();
              }, 1600);
            }
          },
          error: function (xhr, status, error) {
            Swal.fire({
              title: "Error",
              text: "An error occurred while processing the payment. Please try again.",
              icon: "error",
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#paymentreference')[0].reset();
      }
    });
  });





  $('#addproduct').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm adding the product.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, add product!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("addproduct", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            Swal.fire({
              position: "top-end",
              title: "Success!",
              text: "Product added successfully!",
              icon: "success",
              showConfirmButton: false,
              timer: 1500
            });
            setTimeout(function () {
              location.reload();
            }, 1600);
          },

        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#addproduct')[0].reset();
      }

    });

  });


  $('#addproducts').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm adding the product.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, add product!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("addproducts", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {

            if (response.includes("Product name already exists")) {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Product name already exists!",
                confirmButtonColor: "#3085d6",

              });
              $('#addproducts')[0].reset();
            } else {
              Swal.fire({
                position: "top-end",
                title: "Success!",
                text: "Product added successfully!",
                icon: "success",
                showConfirmButton: false,
                timer: 1500
              });
              setTimeout(function () {
                location.reload();
              }, 1600);
            }
          },
          error: function () {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "There was an error adding the product.",
              confirmButtonColor: "#3085d6"
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#addproducts')[0].reset();
      }
    });
  });


  $(document).on('click', '#plusBTN', function () {
    var productID = $(this).data('product-id');
    $.ajax({
      type: "GET",
      url: "../inc/controller.php",
      data: { product_id: productID },
      dataType: "json",
      success: function (data) {
        $('#plusproduct_id').val(data.product_id);
        $('#plustotalquantitytext').text(data.quantitytotal);
      }
    });
  });







  $(document).on('click', '#minusBTN', function () {
    var productID = $(this).data('product-id');
    $.ajax({
      type: "GET",
      url: "../inc/controller.php",
      data: { product_id: productID },
      dataType: "json",
      success: function (data) {
        $('#minusproduct_id').val(data.product_id);
        $('#minustotalquantitytext').text(data.quantitytotal);
      }
    });
  });



  $(document).on('click', '#EDITproductBTN', function () {
    var productID = $(this).data('product-id');
    $.ajax({
      type: "GET",
      url: "../inc/controller.php",
      data: { product_id: productID },
      dataType: "json",
      success: function (data) {
        $('#productIDS').val(data.product_id);
        $('#price').val(data.price);
        $('#coast').val(data.coast);
        $('#date').val(data.productdate);
        $('#productsupplyID').val(data.productsupply_id);
        $('#productsupply_id').val(data.productsupply_id).trigger('change');
      }
    });
  });





  $('#plusquantityForm').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm the quantity addition.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, add quantity!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("plusquantityForm", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            Swal.fire({
              position: "top-end",
              title: "Success!",
              text: "Quantity added successfully!",
              icon: "success",
              showConfirmButton: false,
              timer: 1500
            });
            setTimeout(function () {
              location.reload();
            }, 1600);
          },
          error: function (xhr, status, error) {
            Swal.fire({
              title: "Error!",
              text: "There was an issue adding the quantity.",
              icon: "error",
              confirmButtonText: "OK"
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#plusquantityForm')[0].reset();
      }
    });
  });

  $('#minusquantityForm').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm the quantity subtraction.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, subtract quantity!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("minusquantityForm", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            Swal.fire({
              position: "top-end",
              title: "Success!",
              text: "Quantity subtracted successfully!",
              icon: "success",
              showConfirmButton: false,
              timer: 1500
            });
            setTimeout(function () {
              location.reload();
            }, 1600);
          },
          error: function (xhr, status, error) {
            Swal.fire({
              title: "Error!",
              text: "There was an issue subtracting the quantity.",
              icon: "error",
              confirmButtonText: "OK"
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#minusquantityForm')[0].reset();
      }
    });
  });

  $('#Editproduct').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm the supply update.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, update supply!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("Editproduct", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            Swal.fire({
              position: "top-end",
              title: "Success!",
              text: "Supply updated successfully!",
              icon: "success",
              showConfirmButton: false,
              timer: 1500
            });
            setTimeout(function () {
              location.reload();
            }, 1600);
          },
          error: function (xhr, status, error) {
            Swal.fire({
              title: "Error!",
              text: "There was an issue updating the supply.",
              icon: "error",
              confirmButtonText: "OK"
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#Editproduct')[0].reset();
      }
    });
  });


  $(document).on('click', '#EDITpendingBTN', function () {
    var orderID = $(this).data('order-id'); // Get the order ID
    var productID = $(this).data('product-id'); // Get the product ID

    $.ajax({
      type: "GET",
      url: "../inc/controller.php",
      data: { order_id: orderID },
      dataType: "json",
      success: function (data) {
        // Populate fields with returned data
        $('#order_id').val(data.order_id); // Set the order ID
        $('#productname').val(data.productname);
        $('#quantityinput').val(data.orderquantity);
        $('#totalcostinput').val(data.orderamount);
        $('#price').val(data.price);
        $('#productsupply_id').val(data.productsupply_id);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching product data: " + error);
      }
    });
  });

  $('#editorderForm').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm the product order update.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, update order!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("editorderForm", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            Swal.fire({
              position: "top-end",
              title: "Success!",
              text: "Product order updated successfully!",
              icon: "success",
              showConfirmButton: false,
              timer: 1500
            });
            setTimeout(function () {
              location.reload();
            }, 1600);
          },
          error: function (xhr, status, error) {
            Swal.fire({
              title: "Error!",
              text: "There was an issue updating the product order.",
              icon: "error",
              confirmButtonText: "OK"
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#editorderForm')[0].reset();
      }
    });
  });

  $('#orderForm').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm the product order.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, update order!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("orderForm", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            var data = JSON.parse(response);
            if (data.status === 'success') {
              Swal.fire({
                position: "top-end",
                title: "Success!",
                text: data.message,
                icon: "success",
                showConfirmButton: false,
                timer: 1500
              });
              setTimeout(function () {
                window.location.href = "pending.php";
              }, 1600);
            } else if (data.status === 'error') {
              Swal.fire({
                title: "Error!",
                text: data.message,
                icon: "error",
                confirmButtonText: "OK"
              });
            }
          },
          error: function (xhr, status, error) {
            Swal.fire({
              title: "Error!",
              text: "There was an issue updating the product order.",
              icon: "error",
              confirmButtonText: "OK"
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#orderForm')[0].reset();
      }
    });
  });





  $(document).on('click', '.buyBTN', function () {
    var orderID = $(this).data('order-id');
    var productID = $(this).data('product-id');

    Swal.fire({
      title: "Confirm Purchase",
      text: "Are you sure you want to buy this product?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, buy it!"
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: "Processing Purchase...",
          text: "Please wait while we complete your transaction.",
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });

        $.ajax({
          url: "../inc/controller.php",
          method: 'POST',
          data: {
            order_id: orderID,
            product_id: productID,
            buyBTN: true,
          },
          success: function (response) {
            var data = JSON.parse(response);
            if (data.status === 'error') {
              Swal.fire({
                title: "Error",
                text: data.message,
                icon: "error",
                confirmButtonText: "OK"
              });
            } else {
              Swal.fire({
                position: "top-end",
                title: "Purchase Successful!",
                text: data.message,
                icon: "success",
                showConfirmButton: false,
                timer: 1500
              });
              setTimeout(function () {
                window.location.href = "order.php";
              }, 1600);
            }
          },
          error: function () {
            Swal.fire({
              title: "Error",
              text: "There was an issue completing your purchase. Please try again.",
              icon: "error",
              confirmButtonText: "OK"
            });
          }
        });
      }
    });
  });







  $(document).on('click', '#editproductLIst', function (e) {
    e.preventDefault();
    var productsupplyID = $(this).data('productsupply-id');
    $.ajax({
      type: "GET",
      url: "../inc/controller.php",
      data: { productsupply_id: productsupplyID },
      dataType: "json",
      success: function (data) {
        if (data) {
          $('#productsupplyID').val(data.productsupply_id);
          $('#productname').val(data.productname);
          $('#modal-productEdit').modal('show');
        } else {
          alert('No data found');
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error('AJAX error: ', textStatus, errorThrown);
      }
    });
  });


  $(document).on('click', '#editmisllaneous', function (e) {
    e.preventDefault();
    var productID = $(this).data('product-id');
    $.ajax({
      type: "GET",
      url: "../inc/controller.php",
      data: { product_id: productID },
      dataType: "json",
      success: function (data) {
        if (data) {
          $('#product_id').val(data.product_id);
          $('#pID').val(data.pID);
          $('#coast').val(data.coast);
          $('#modal-productEdit').modal('show');
        } else {
          alert('No data found');
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error('AJAX error: ', textStatus, errorThrown);
      }
    });
  });





  $('#editproductForm').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm the product update.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, update product!" // Updated text here
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("editproductForm", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            Swal.fire({
              position: "top-end",
              title: "Success!",
              text: "Product updated successfully!", // Updated text here
              icon: "success",
              showConfirmButton: false,
              timer: 1500
            });
            setTimeout(function () {
              location.reload();
            }, 1600);
          },
          error: function (xhr, status, error) {
            Swal.fire({
              title: "Error!",
              text: "There was an issue updating the product.", // Updated text here
              icon: "error",
              confirmButtonText: "OK"
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#editproductForm')[0].reset();
      }
    });
  });




  $(document).on('click', '#deleteproductBTN', function () {
    var productID = $(this).data('productsupply-id');

    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this action to delete the product!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "GET",
          url: "../inc/controller.php",
          data: {
            productsupply_id: productID,
            deleteproductBTN: true,
          },
          dataType: "json",
          success: function (data) {
            Swal.fire({
              position: "top-end",
              title: "Deleted!",
              text: "The product has been deleted.",
              icon: "success",
              showConfirmButton: false,
              timer: 1500
            }).then(() => {
              window.location.reload();
            });
          }
        });
      }
    });
  });



  $(document).on('click', '#deleteproductBTNLIST', function () {
    var productListID = $(this).data('product-id');

    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this action to delete the product!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "GET",
          url: "../inc/controller.php",
          data: {
            product_id: productListID,
            deleteproductBTNLIST: true,
          },
          dataType: "json",
          success: function (data) {
            Swal.fire({
              position: "top-end",
              title: "Deleted!",
              text: "The product has been deleted.",
              icon: "success",
              showConfirmButton: false,
              timer: 1500
            }).then(() => {
              window.location.reload();
            });
          }
        });
      }
    });

  });



  $('#misllaneousForm').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm the miscellaneous addition.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, add miscellaneous!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("misllaneousForm", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            Swal.fire({
              position: "top-end",
              title: "Success!",
              text: "Miscellaneous added successfully!",
              icon: "success",
              showConfirmButton: false,
              timer: 1500
            });
            setTimeout(function () {
              location.reload();
            }, 1600);
          },
          error: function (xhr, status, error) {
            Swal.fire({
              title: "Error!",
              text: "There was an issue adding the miscellaneous item.",
              icon: "error",
              confirmButtonText: "OK"
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#misllaneousForm')[0].reset();
      }
    });
  });



  $(document).on('click', '#orderreciept', function () {
    var orderID = $(this).data('order-id');
    $.ajax({
      type: "GET",
      url: "../inc/controller.php",
      data: { order_id: orderID },
      dataType: "json",
      success: function (data) {
        console.log(data);

        var formattedDate = new Date(data.date).toLocaleDateString('en-US', {
          month: 'short',
          day: 'numeric',
          year: 'numeric'
        });

        function formatNumber(num) {
          return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        $('#orderID').val(data.order_id);
        $('#invoice_number').text(data.orderproductno);
        $('#mname').text(data.ordername);
        $('#productname').text(data.productname);
        $('#orderquantity').text(data.orderquantity);
        $('#dates').text(formattedDate);
        $('#totalincome').text('₱' + formatNumber(data.totalincome));
        $('#priceS').text('₱' + formatNumber(data.price));


      }
    });
  });



  $('#withdrawgenfund').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm the withdrawal request.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, proceed!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("withdrawgenfund", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            var data = JSON.parse(response);

            if (data.status === 'error') {
              Swal.fire({
                icon: 'error',
                title: 'Insufficient Funds',
                text: data.message,
              });
            } else if (data.status === 'success') {
              Swal.fire({
                position: "top-end",
                title: "Success!",
                text: "General Fund withdrawal completed successfully!",
                icon: "success",
                showConfirmButton: false,
                timer: 1500
              });
              setTimeout(function () {
                location.reload();
              }, 1600);
            }
          },
          error: function () {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'An error occurred. Please try again later.'
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#withdrawgenfund')[0].reset();
      }
    });
  });

  $('#withdrawcapital').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm the withdrawal request.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, proceed!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("withdrawcapital", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            var data = JSON.parse(response);

            if (data.status === 'error') {
              Swal.fire({
                icon: 'error',
                title: 'Insufficient Funds',
                text: data.message,
              });
            } else if (data.status === 'success') {
              Swal.fire({
                position: "top-end",
                title: "Success!",
                text: "Capital withdrawal completed successfully!",
                icon: "success",
                showConfirmButton: false,
                timer: 1500
              });
              setTimeout(function () {
                location.reload();
              }, 1600);
            }
          },
          error: function () {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'An error occurred. Please try again later.'
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#withdrawcapital')[0].reset();
      }
    });
  });
  $('#withdrawprofit').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm the withdrawal request.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, proceed!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("withdrawprofit", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            var data = JSON.parse(response);

            if (data.status === 'error') {
              Swal.fire({
                icon: 'error',
                title: 'Insufficient Funds',
                text: data.message,
              });
            } else if (data.status === 'success') {
              Swal.fire({
                position: "top-end",
                title: "Success!",
                text: "Profit withdrawal completed successfully!",
                icon: "success",
                showConfirmButton: false,
                timer: 1500
              });
              setTimeout(function () {
                location.reload();
              }, 1600);
            }
          },
          error: function () {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'An error occurred. Please try again later.'
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#withdrawprofit')[0].reset();
      }
    });
  });



  $('#withdrawSales').on('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Please confirm the withdrawal request.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, proceed!"
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData(this);
        formData.append("withdrawSales", "true");

        $.ajax({
          url: "../inc/controller.php",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            var data = JSON.parse(response);

            if (data.status === 'error') {
              Swal.fire({
                icon: 'error',
                title: 'Insufficient Sales Amount',
                text: data.message,
              });
            } else if (data.status === 'success') {
              Swal.fire({
                position: "top-end",
                title: "Success!",
                text: "Sales Amount withdrawal completed successfully!",
                icon: "success",
                showConfirmButton: false,
                timer: 1500
              });
              setTimeout(function () {
                location.reload();
              }, 1600);
            }
          },
          error: function () {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'An error occurred. Please try again later.'
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        $('#withdrawSales')[0].reset();
      }
    });
  });





});