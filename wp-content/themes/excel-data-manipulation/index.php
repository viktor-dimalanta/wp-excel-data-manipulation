<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage WP CSV Data Manipulation
 * @since Custom Theme 1.0
 */

get_header(); ?>

<div class="container">
    <main id="main" class="site-main">
        <?php
        // Path to your Excel file
        $csvFile = wp_upload_dir()['basedir'] . '/Dummy_Data.csv';

        // Ensure the file exists
        if (file_exists($csvFile)) {

            // Include necessary WordPress functions
            while (have_posts()) :
                the_post();

                // Function to parse CSV file
                function parseCSV($csvFile, $start, $length)
                {
                    $csvData = [];
                    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
                        $rowCount = 0;
                        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                            $rowCount++;
                            if ($rowCount > $start + $length) {
                                break; // Stop reading if beyond current page's range
                            }
                            if ($rowCount > $start) {
                                $csvData[] = $data;
                            }
                        }
                        fclose($handle);
                    }
                    return $csvData;
                }

                // Number of rows per page
                $rowsPerPage = 10;

                // Current page number (default to 1 if not set)
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                // Get total number of rows
                $totalRows = count(parseCSV($csvFile, 0, PHP_INT_MAX));

                // Get data for the current page
                $start = ($page - 1) * $rowsPerPage;
                $csvData = parseCSV($csvFile, $start, $rowsPerPage);

                // Add the button to redirect to a new page for adding records
                ?>
                    <a href="<?php echo esc_url(home_url('/add-record')); ?>" class="add-record-btn">Add New Record</a>
                <?php

                // Generate HTML table markup with table design
                echo '<div class="table-responsive">';
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr>';
                foreach ($csvData[0] as $cell) {
                    echo '<th>' . htmlspecialchars($cell) . '</th>';
                }
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                for ($i = 1; $i < count($csvData); $i++) {
                    echo '<tr>';
                    foreach ($csvData[$i] as $key => $cell) {
                        if ($key === 0) {
                            // First column (opportunity name), make it a link
                            echo '<td><a href="' . esc_url(home_url('/opportunity-details')) . '?opportunity=' . urlencode($cell) . '" target="_blank">' . htmlspecialchars($cell) . '</a></td>';
                        } else {
                            // Other columns
                            echo '<td>' . htmlspecialchars($cell) . '</td>';
                        }
                    }
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';

                // Generate pagination links with pagination design
                echo '<div class="pagination">';
                $numPages = ceil($totalRows / $rowsPerPage);
                for ($i = 1; $i <= $numPages; $i++) {
                    $class = ($page == $i) ? 'active' : '';
                    echo '<a href="?page=' . $i . '" class="' . $class . '">' . $i . '</a>';
                }
                echo '</div><br>';

            endwhile;

        } else {
            echo 'CSV file not found.';
        }
        ?>

    </main><!-- #main -->
</div><!-- .container -->

<?php
get_footer();
?>
