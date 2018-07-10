<style>
  .input-group{
    padding-bottom: 5px;
  }

  .hiddenRow {
    padding: 0 !important;
  }

  .modal {
        display:    none;
        position:   fixed;
        z-index:    1000;
        top:        0;
        left:       0;
        height:     100%;
        width:      100%;
        background: rgba( 255, 255, 255, .8 ) 
                    url('assets/img/Preloader_6.gif') 
                    50% 50% 
                    no-repeat;
    }

    body.loading {
        overflow: hidden;   
    }

    body.loading .modal {
        display: block;
    }
</style>

<div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
        <!-- Default panel contents -->
          <div class="panel-heading"><span class="glyphicon glyphicon-home" aria-hidden="true"></span><b> Add Candidate</b></div>
          <div class="panel-body">
            <div class="col-md-12">
              <h3 id="cl" name="cl">Candidate List</h3>
              <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                <b>Note : T1 : <i>TPA</i>, T2 : <i>Practical Test</i>, T3 : <i>Interview</i>, T4 : <i>Psikotest</i></b>
              </div>
              <!-- Table -->
              <form id="frmTestResult">
                <table class="table">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Input Date</th>
                      <th>Name</th>
                      <!-- <th>Email</th> -->
                      <th>Gender</th>
                      <th>Address</th>
                      <th>Phone</th>
                      <th>T1</th>
                      <td></td> 
                      <th>T2</th>
                      <td></td> 
                      <th>T3</th>
                      <td></td> 
                      <th>T4</th>
                      <!-- <th></th> -->
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sqlRequest = "SELECT a.*, DATE_FORMAT(a.created_at,'%d %M %Y %h:%i:%s') created_at,tpa,practical,
                                CASE 
                                  WHEN interview = 0 THEN 'N/A'
                                  WHEN interview = 1 THEN 'P'
                                  WHEN interview = 2 THEN 'R'
                                END Tinterview,
                                CASE 
                                  WHEN psikotest = 0 THEN 'N/A'
                                  WHEN psikotest = 1 THEN 'P'
                                  WHEN psikotest = 2 THEN 'R'
                                END Tpsikotest,
                                CASE WHEN a.gender = 1 THEN 'Male' ELSE 'Female' END gender,
                                b.sfpt
                                FROM sm_hc_candidate a
                                LEFT JOIN sm_hc_request b ON a.req_id = b.id
                                ORDER BY a.created_at DESC";
                    $dataRequest = $conn->query($sqlRequest);

                    if ($dataRequest->num_rows > 0) {
                      $no = 1;
                      while($rowRequest = $dataRequest->fetch_assoc()) {
                    ?>
                    <tr data-toggle="collapse" data-target="#demo<?php echo $no ?>" class="accordion-toggle">
                      <td><?php echo $no ?></td>
                      <td><?php echo $rowRequest["created_at"] ?></td>
                      <td><b>
                        <?php echo $rowRequest["name"] ?><br>
                          <small><a href="mailto:<?php echo $rowRequest["email"] ?>" target="_top"><?php echo $rowRequest["email"] ?></a></small>
                        </b>
                        <select name="switch" id="switch" class="selectpicker" data-show-subtext="true" data-live-search="true" onchange="switchto(this)">
                          <option data-subtext="to req ..." value="0">Switch</option>
                          <?php
                          $sqlSwitch = "SELECT a.id, a.req_number, b.nama FROM sm_hc_request a 
                                          LEFT JOIN tb_datapribadi b ON a.pic = b.nik WHERE a.status IN (1) ORDER BY a.req_date DESC";
                          $dataSwitch = $conn->query($sqlSwitch);

                          if ($dataSwitch->num_rows > 0) {
                            while($rowSwitch = $dataSwitch->fetch_assoc()) {
                          ?>
                              <option data-subtext="<?php echo $rowSwitch["nama"] ?>" value="<?php echo $rowRequest["id"]."||".$rowSwitch["id"]."||".$rowSwitch["req_number"] ?>"><?php echo $rowSwitch["req_number"] ?></option>
                          <?php
                            }
                          } 
                          ?>
                        </select>
                      </td>
                      <td><?php echo $rowRequest["address"] ?></td>
                      <td><?php echo $rowRequest["gender"] ?></td>
                      <td><?php echo $rowRequest["phone"] ?></td>
                      <?php
                      if($rowRequest["tpa"]<15){
                        echo "<td style=\"background-color:#FF6666\"><b>".$rowRequest["tpa"]."</b></td>";
                      }else{
                        echo "<td style=\"background-color:#66FF66\"><b>".$rowRequest["tpa"]."</b></td>";
                      }
                      ?>
                      <td></td> 
                      <?php
                      if($rowRequest["practical"] < $rowRequest["sfpt"]){
                        echo "<td style=\"background-color:#FF6666\"><b>".$rowRequest["practical"]."</b></td>";
                      }else{
                        echo "<td style=\"background-color:#66FF66\"><b>".$rowRequest["practical"]."</b></td>";
                      }
                      ?>
                      <td></td> 
                      <?php
                      if($rowRequest["Tinterview"] == "R"){
                        echo "<td style=\"background-color:#FF6666\"><b>".$rowRequest["Tinterview"]."</b></td>";
                      }elseif($rowRequest["Tinterview"] == "P"){
                        echo "<td style=\"background-color:#66FF66\"><b>".$rowRequest["Tinterview"]."</b></td>";
                      }else{
                        echo "<td><b>".$rowRequest["Tinterview"]."</b></td>";
                      }
                      ?>
                      <td></td> 
                      <?php
                      if($rowRequest["Tpsikotest"] == "R"){
                        echo "<td style=\"background-color:#FF6666\"><b>".$rowRequest["Tpsikotest"]."</b></td>";
                      }elseif($rowRequest["Tpsikotest"] == "P"){
                        echo "<td style=\"background-color:#66FF66\"><b>".$rowRequest["Tpsikotest"]."</b></td>";
                      }else{
                        echo "<td><b>".$rowRequest["Tpsikotest"]."</b></td>";
                      }
                      ?>
                      <td>
                        <?php 
                        if($rowRequest["cvfile"]!=="-"){
                        ?>
                        <a class="btn btn-info btn-xs" target="_blank" role="button" href="files/<?php echo $rowRequest["cvfile"] ?>">CV</a>
                        <?php
                        }
                        ?>
                      </td>
                    </tr>
                    
                  </tbody>
                    <?php
                      $no += 1;
                      }
                    }
                    ?>

                </table>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <div class="modal" id="modal"></div>
  <script src="assets/js/jquery.min.js"></script>
  <script>
    function switchto(req_id){
      var id = req_id.value;
      // alert(id);
      var splitid = id.split("||");

      alertify.confirm("Are you sure to switch this candidate to Request " + splitid[2] + "?", 
      function(a){
        var dataRequest = {req_id:splitid[1], cad_id:splitid[0], typeSave:"switchTalentPool", userLogin:"<?php echo $_SESSION['user'] ?>"};

        $.ajax({
          data: dataRequest,
          type: "POST",
          url: "process.php",
          success: function(data){
            // alert(data);
            if(data=="true"){
              window.location = "http://www.edii.local/sms_hc/index.php?mn=5";
            }else{
              alertify.alert("Switch Candidate Failed, contact your Administrator")
            }
          }
        });
      },
      function(){

      });
    }

    $(document).ready(function(){
    
    });
  </script>