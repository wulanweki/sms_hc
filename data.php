<?
include("database.php");

$typeGet = $_GET["typeGet"];

if($typeGet=="1"){
?>
	<table id="example" class="display" cellspacing="0" width="100%">
		<thead>
		    <tr>
		        <th>No.</th>
	          	<th>Request Date</th>
	          	<th>Request Number</th>
	          	<th>Division</th>
	          	<th>PIC</th>
	          	<th>Position</th>
	          	<th>Qty.</th>
	          	<th>Detail</th>
	          	<th>Deadline</th>
	          	<th>Status</th>
	          	<th></th>
		    </tr>
		</thead>
		<tbody>
<?php	
	$sqlRequest = "SELECT a.id, DATE_FORMAT(a.req_date, '%d %M %Y') req_date, a.req_number, a.detail_pos, a.qty, DATE_FORMAT(a.deadline, '%d %M %Y') deadline, b.nama_div_ext, c.nama, d.jabatan,
				CASE 
					WHEN a.status = 0 THEN '<td style=\"background-color:#3498DB; font-weight:bold\">Received</td>'
					WHEN a.status = 1 THEN '<td style=\"background-color:#FFD42A; font-weight:bold\">Processing</td>'
					WHEN a.status = 2 THEN '<td style=\"background-color:#FF3333; font-weight:bold\">Rejected</td>'
					WHEN a.status = 3 THEN '<td style=\"background-color:#00CC00; font-weight:bold\">Finish</td>'
				END status,
				CASE
					WHEN a.status = 0 THEN 
						CONCAT('<button type=\"button\" class=\"btn btn-info btn-xs\" onclick=\"addCandidate(',a.id,')\"><b>Candidate (',(SELECT COUNT(id) FROM sm_hc_candidate WHERE req_id = a.id),')</b></button>
			            <button type=\"button\" class=\"btn btn-success btn-xs\" onclick=\"finishReq(',a.id,')\"><b>Request Finish</b></button>
			            <button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"rejectReq(',a.id,')\"><b>Reject</b></button>')
			        WHEN a.status = 1 THEN 
						CONCAT('<button type=\"button\" class=\"btn btn-info btn-xs\" onclick=\"addCandidate(',a.id,')\"><b>Candidate (',(SELECT COUNT(id) FROM sm_hc_candidate WHERE req_id = a.id),')</b></button>
			            <button type=\"button\" class=\"btn btn-success btn-xs\" onclick=\"finishReq(',a.id,')\"><b>Request Finish</b></button>
			            <button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"rejectReq(',a.id,')\"><b>Reject</b></button>')
			        WHEN a.status = 2 THEN 
						CONCAT('
			            <button type=\"button\" class=\"btn btn-warning btn-xs\" onclick=\"roolbackReq(',a.id,')\"><b>Roolback</b></button>')
			        WHEN a.status = 3 THEN 
						CONCAT('<button type=\"button\" class=\"btn btn-info btn-xs\" onclick=\"addCandidate(',a.id,')\"><b>Candidate (',(SELECT COUNT(id) FROM sm_hc_candidate WHERE req_id = a.id),')</b></button>
			            <button type=\"button\" class=\"btn btn-warning btn-xs\" onclick=\"roolbackReq(',a.id,')\"><b>Roolback</b></button>')
				END actions,
                (SELECT COUNT(id) FROM sm_hc_candidate WHERE req_id = a.id) candidate
                FROM sm_hc_request a
                LEFT JOIN tbldivmaster b ON a.division = b.id
                LEFT JOIN tb_datapribadi c ON a.pic = c.nik
                LEFT JOIN tb_jabatan d ON a.position = d.id
                ORDER BY a.created_at DESC";
    $dataRequest = $conn->query($sqlRequest);
   	$no = 1;
   	while($row=$dataRequest->fetch_array(MYSQLI_BOTH))
	{
		echo "<tr>";
		echo "<td>" . $no. "</td>";
		echo "<td>" . $row['req_date']. "</td>";
		echo "<td>" . $row['req_number']. "</td>";
		echo "<td>" . $row['nama_div_ext']. "</td>";
		echo "<td>" . $row['nama']. "</td>";
		echo "<td>" . $row['jabatan']. "</td>";
		echo "<td>" . $row['qty']. "</td>";
		echo "<td>" . $row['detail_pos']. "</td>";
		echo "<td>" . $row['deadline']. "</td>";
		echo $row['status'];
		echo "<td>" . $row['actions'] . "</td>";
		echo "</tr>";

		$no += 1;
	}
    // $data = array();
    // foreach ($dataRequest as $row ) {
    //     $data['data'][] = $row ;
    // }
    // echo json_encode($data);
?>
		</tbody>
	</table>
<?php
}

$conn->close();