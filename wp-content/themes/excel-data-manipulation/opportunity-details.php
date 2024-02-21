<?php
/*
Template Name: Opportunity Details
*/

// Include WordPress header
get_header();

// Retrieve opportunity name from URL parameter
$opportunity_name = isset($_GET['opportunity']) ? $_GET['opportunity'] : '';

// Function to parse CSV file and filter data based on opportunity name
function parseCSV($csvFile, $opportunity_name) {
    $csvData = [];
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            // Check if the opportunity name matches
            if ($data[0] == $opportunity_name) {
                // Add the matching row to the data array
                $csvData[] = $data;
                break; // Stop parsing after finding the matching row
            }
        }
        fclose($handle);
    }
    return $csvData;
}

// Path to your CSV file
$csvFile = wp_upload_dir()['basedir'] . '/Dummy_Data.csv';

// Get opportunity details from CSV
$opportunity_details = parseCSV($csvFile, $opportunity_name);

// Display opportunity details
if (!empty($opportunity_details)) {
    echo '<div class="opportunity-details">';
    echo '<button class="close-btn" onclick="closeCurrentTab()">Close</button>';
    echo '<h2 class="opportunity-name">' . $opportunity_details[0][0] . '</h2>'; // Assuming the opportunity name is in the first column
    echo '<p class="opportunity-info">' . $opportunity_details[0][1] . '</p>'; 
    echo '<p class="opportunity-info">' . $opportunity_details[0][2] . '</p>'; 
    echo '<p class="opportunity-info">' . $opportunity_details[0][3] . '</p>'; 
    echo '<p class="opportunity-info">' . $opportunity_details[0][4] . '</p>'; 
    echo '<p class="opportunity-info">' . $opportunity_details[0][5] . '</p>'; 

    // Add more fields as needed
    echo '</div>';

} else {
    echo '<p>Opportunity not found.</p>';
}

// Include WordPress footer
get_footer();
?>

<script>
function closeCurrentTab() {
    window.close();
}
</script>
