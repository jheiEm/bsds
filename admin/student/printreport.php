<?php


// Fetch data from the database
$sql = "SELECT * FROM your_table";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Start building the report
    $report = "<h1>Report</h1>";

    while ($row = $result->fetch_assoc()) {
        // Format each row of data
        $report .= "<p><strong>ID:</strong> " . $row["id"] . "</p>";
        $report .= "<p><strong>Name:</strong> " . $row["firstname"] . "</p>";
      
        $report .= "<hr>";
    }

    // Display the report with a print button
    echo $report;
    echo "<button id=". print" >Print</button>";
} else {
    echo "No record found in the database.";
}

// Close the MySQLi connection
$conn->close();
?>
<script>
    $(function(){
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
        $('#print').click(function(){
	        window.print();
        });
    });
</script>