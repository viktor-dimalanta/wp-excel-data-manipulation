<?php
/**
 * Template Name: Add Record Page
 *
 * @package Your_Custom_Theme
 */

// Initialize success message
$success_message = '';

// Process form submission
if (isset($_POST['add_record'])) {
    // Path to your CSV file
    $csvFile = wp_upload_dir()['basedir'] . '/Dummy_Data.csv';

    // Get form data
    $opportunityName = isset($_POST['opportunity_name']) ? sanitize_text_field($_POST['opportunity_name']) : '';
    $agent = isset($_POST['agent']) ? sanitize_text_field($_POST['agent']) : '';
    $region = isset($_POST['region']) ? sanitize_text_field($_POST['region']) : '';
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $amount = isset($_POST['amount']) ? sanitize_text_field($_POST['amount']) : '';
    $sale = isset($_POST['sale']) ? sanitize_text_field($_POST['sale']) : '';


    // Validate form data (You can add your validation logic here)

    // Add a new row to the CSV file
    $newRow = array($opportunityName, $agent, $region, $category,$amount,$sale);
    $fp = fopen($csvFile, 'a');
    if (fputcsv($fp, $newRow)) {
        $success_message = 'Record added successfully.';
    } else {
        $success_message = 'Failed to add record.';
    }
    fclose($fp);

    // Redirect to refresh the page after adding record
    wp_redirect(home_url());
    exit;
}

// No HTML output or headers sent before this point
get_header();
?>

<div class="container">
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <!-- Display success message if set -->
                    <?php if ($success_message): ?>
                        <div class="success-message"><?php echo esc_html($success_message); ?></div>
                    <?php endif; ?>

                    <!-- Your page content goes here -->
                    <form id="addRecordForm" action="" method="post" class="add-record-form">
                        <div class="form-group">
                            <label for="opportunity_name">Opportunity Name</label>
                            <input type="text" id="opportunity_name" name="opportunity_name">
                        </div>
                        <div class="form-group">
                            <label for="agent">Sales Agent</label>
                            <input type="text" id="agent" name="agent">
                        </div>
                        <div class="form-group">
                            <label for="region">Sales Region</label>
                            <input type="text" id="region" name="region">
                        </div>
                        <div class="form-group">
                            <label for="category">Sales Category</label>
                            <input type="text" id="category" name="category">
                        </div>
                        <div class="form-group">
                            <label for="amount">Forecast Amount</label>
                            <input type="text" id="amount" name="amount">
                        </div>
                        <div class="form-group">
                            <label for="sale">Probability of Sale</label>
                            <input type="text" id="sale" name="sale">
                        </div>
                        <button type="submit" name="add_record" class="add-new-record-btn">Add Record</button>
                    </form>
                </div><!-- .entry-content -->
            </article><!-- #post-<?php the_ID(); ?> -->
        </main><!-- #main -->
    </div><!-- #primary -->
</div><!-- .container -->

<?php get_footer(); ?>
