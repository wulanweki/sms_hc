<div class="container">
  <div class="row">
    <div class="col-md-12">

      <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-home" aria-hidden="true"></span><b> Staff Request Monitoring Dashboard</b></div>
        <div class="panel-body" id="result">
           
        </div>
      </div>
    </div>
  </div>
</div>
  <script src="assets/js/jquery.min.js"></script>
  <script>
    $(document).ready(function() {

      $.ajax({
        url: 'data.php?typeGet=1',
        type: 'post',
        success: function(response) {
          $("#result").html(response);
          $('#example').DataTable();
        }
      });
    } );

    function addCandidate(idReq){
      // alert(idReq);
      window.location = "http://www.edii.local/sms_hc/index.php?mn=3&&idReq=" + idReq;
    }

    function finishReq(idReq){
      var dataRequest = {req_id:idReq, typeSave:"finishReq", userLogin:"<?php echo $_SESSION['user'] ?>"};

      $.ajax({
        data: dataRequest,
        type: "POST",
        url: "process.php",
        success: function(data){
          // alert(data);
          if(data=="true"){
            alertify.alert("SMSHC", "Yeyyy... Request Finished")
            window.location = "http://www.edii.local/sms_hc/index.php";
          }else{
            alertify.alert("SMSHC", "Insert Failed, contact your Administrator")
          }
        }
      });
    }

    function rejectReq(idReq){
      // alert(idReq); 
      alertify.confirm('SMSHC','Are you sure to reject this request?', 
        function(a){
          var dataRequest = {req_id:idReq, typeSave:"rejectReq", userLogin:"<?php echo $_SESSION['user'] ?>"};

          $.ajax({
            data: dataRequest,
            type: "POST",
            url: "process.php",
            success: function(data){
              // alert(data);
              if(data=="true"){
                alertify.log("Request Rejected")
                window.location = "http://www.edii.local/sms_hc/index.php";
              }else{
                alertify.alert("SMSHC", "Insert Failed, contact your Administrator")
              }
            }
          });
        
        },
        function(){

        }); 
    }

    function roolbackReq(idReq){
      // alert(idReq); 
      alertify.confirm("Roolback to Processing","Are you sure to roolback this request?", 
        function(a){
          var dataRequest = {req_id:idReq, typeSave:"roolbackReq", userLogin:"<?php echo $_SESSION['user'] ?>"};

          $.ajax({
            data: dataRequest,
            type: "POST",
            url: "process.php",
            success: function(data){
              // alert(data);
              if(data=="true"){
                window.location = "http://www.edii.local/sms_hc/index.php";
              }else{
                alertify.alert("SMSHC", "Insert Failed, contact your Administrator")
              }
            }
          });
        },
        function(){
          
        }); 
    }
  </script>