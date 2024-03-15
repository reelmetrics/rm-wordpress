<?php
/**
 * Template for displaying game profile based on the static UUID.
 */

$game_data = fetch_reel_game_api_response();

if (is_wp_error($game_data)) {
    echo esc_html($game_data->get_error_message());
    return;
}

if (!isset($game_data['title'])) {
    echo "Game data not available.";
    return;
}

// 1. Game Info & Metrics
echo "<div class='reel-game-container'>";
echo "<div class='main-flex-container'>";
echo "<div class='game-info'>";
echo "<h1 class='reel-game-title'>" . esc_html($game_data['title']) . "</h1>";
echo "<p><strong>Suppliers: </strong>" . esc_html($game_data['supplier']) . "</p>";
echo "<p><strong>Cost Model: </strong>" . esc_html($game_data['cost_model']) . "</p>";
echo "</div>"; 
echo "<div class='metrics-flex-container'>";
$metrics_titles = ["TERMINALS", "VENUES", "MONTHS"];
foreach ($metrics_titles as $index => $title) {
    echo "<div class='metric-box'>";
    echo "<h4>$title</h4>";
    echo "<div class='metric-number'>" . esc_html($game_data['stats_json'][$index][0]['value']) . "</div>";
    $skip_first = true;
    echo "<ul>";
    foreach ($game_data['stats_json'][$index] as $metric) {
        if ($skip_first) {
            $skip_first = false;
            continue;
        }
        echo "<li class='metric-list-item'><strong>" . esc_html($metric['key']) . ": </strong>" . esc_html($metric['value']) . "</li>";
    }
    echo "</ul>";
    echo "</div>";
}
echo "<hr class='mt-4 mb-5'>";
echo "</div>"; // Close the metrics-flex-container
echo "</div>"; // Close the main-flex-container

// Game Image and Performance Profile

// echo "<div class='container'>";
// echo "<div class='row'>";
// echo "<div class='col-md-5'>";
// echo "<h5>Game Image</h5>";
// echo "</div>";
// echo "<div class='col-md-7 mt-5'>";
// echo "<table class='table table-bordered'>";
// echo "<thead><tr><th>Measure</th><th>Value</th></tr></thead><tbody>";
// foreach ($game_data['performance_profile_json'] as $measure => $value) {
//     echo "<tr><td>" . esc_html($measure) . "</td><td>" . esc_html($value) . "</td></tr>";
// }
// echo "</tbody></table>";
// echo "</div>";
// echo "</div>";
// echo "</div>";
echo "</div>"; // Close the reel-game-container


    // 2. Performance Profile
    echo "<div class='performance-profile-container'>"; 

    echo "<div id='performanceAccordion'>";
    
    echo "<div class='card'>";
    // Accordion title for Performance Profile
    echo "<div class='card-header d-flex justify-content-between align-items-center' id='headingPerformanceProfile'>";
    echo "<h4 class='mb-0'>2. Performance Profile</h4>";
    echo "<button class='btn btn-link chevron-button' data-toggle='collapse' data-target='#collapsePerformanceProfile' aria-expanded='true' aria-controls='collapsePerformanceProfile' id='chevron-button-performanceprofile'>";
    echo "<span class='chevron'><i class='fa fa-chevron-down'></i></span>"; 
    echo "</button>";
    echo "</div>";
    
            // Accordion content for Performance Profile
            echo "<div id='collapsePerformanceProfile' class='collapse show' aria-labelledby='headingPerformanceProfile' data-parent='#performanceAccordion'>";
                echo "<div class='card-body'>";
    
                    // Key Metrics Overview
                    echo "<div class='metrics-overview'>";
                    echo "<h4>Key Metrics</h4>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>Measure</th><th>Value</th></tr></thead><tbody>";
                    foreach ($game_data['performance_profile_json'] as $measure => $value) {
                        echo "<tr><td>" . esc_html($measure) . "</td><td>" . esc_html($value) . "</td></tr>";
                    }
                    echo "</tbody></table>";
                    echo "</div>";
    
                    // Note: Additional charts or visualizations can be added here
    
                echo "</div>"; // Close the card-body for Performance Profile
            echo "</div>"; // Close the Accordion content for Performance Profile
        echo "</div>"; // Close the card for Performance Profile
    
    echo "</div>"; // Close the performanceAccordion
    
    echo "</div>"; // Close the performance-profile-container



// 3. Performance  over Time
echo "<div class='vertical-chart-container'>"; 

echo "<div id='accordion'>";

echo "<div class='card'>";
// Accordion title
echo "<div class='card-header d-flex justify-content-between align-items-center' id='headingGamePerformance'>";
echo "<h4 class='mb-0'>3. Performance Over Time </h4>"; 
echo "<button class='btn btn-link chevron-button' data-toggle='collapse' data-target='#collapseGamePerformance' aria-expanded='true' aria-controls='collapseGamePerformance' id='chevron-button-gameperformance'>";
echo "<span class='chevron'><i class='fa fa-chevron-down'></i></span>"; 
echo "</button>";
echo "</div>";

        // Accordion content
        echo "<div id='collapseGamePerformance' class='collapse show' aria-labelledby='headingGamePerformance' data-parent='#accordion'>";
            echo "<div class='card-body'>";

                // TimeSeries Chart
                echo "<div class='vertical-chart-box'>";
                    echo "<div id='timeSeriesChart'></div>"; //Performance over Time
                echo "</div>";

                echo "<div class='vertical-chart-box'>";
                    echo "<div id='adoptionOverTimeChart'></div>"; // Adoption Over Time
                echo "</div>";

                echo "<div class='vertical-chart-box'>";
                    echo "<div id='revenueInsightsChart'></div>"; // Revenue Insights
                echo "</div>";

            echo "</div>"; // Close the card-body
        echo "</div>"; // Close the Accordion content
    echo "</div>"; // Close the card

echo "</div>"; // Close the accordion


echo "</div>"; // Close the chart-container

 

// 4. Market Presence
echo "<div class='vertical-chart-container'>"; 
    echo "<div class='card'>";
        echo "<div class='card-header d-flex justify-content-between align-items-center' id='headingMarketPresence'>";
            echo "<h4 class='mb-0'>4. Market Presence</h4>";   
            echo "<button class='btn btn-link chevron-button' data-toggle='collapse' data-target='#collapseMarketPresence' aria-expanded='true' aria-controls='collapseMarketPresence' id='chevron-button-marketpresence'>";
            echo "<span class='chevron'><i class='fa fa-chevron-down'></i></span>";  
            echo "</button>";
        echo "</div>";
        echo "<div id='collapseMarketPresence' class='collapse' aria-labelledby='headingMarketPresence' data-parent='#accordion'>";
            echo "<div class='card-body'>";
                echo "<div class='vertical-chart-box'>";
                    echo "<div id='marketShareParetoChart'></div>"; // Market Share
                echo "</div>";
                echo "<div class='vertical-chart-box'>";
                    echo "<div id='terminalsParetoChart'></div>"; // 6. Terminal Distribution & Status
                echo "</div>";
                echo "<div class='vertical-chart-box'>";
                    echo "<div id='venuesParetoChart'></div>"; //7. Venue Distribution & Analysis
                echo "</div>";
            echo "</div>";
        echo "</div>";
        echo "</div>";
    echo "</div>";
echo "</div>";

// 5. Dive Deeper
echo "<div class='vertical-chart-container mb-5'>"; 
    echo "<div class='card'>";
        echo "<div class='card-header d-flex justify-content-between align-items-center' id='headingPeerComparison'>";
            echo "<h4 class='mb-0'>5. Dive Deeper</h4>";   
            echo "<button class='btn btn-link chevron-button' data-toggle='collapse' data-target='#collapsePeerComparison' aria-expanded='true' aria-controls='collapsePeerComparison' id='chevron-button-peercomparison'>";
            echo "<span class='chevron'><i class='fa fa-chevron-down'></i></span>";  
            echo "</button>";
        echo "</div>";
        echo "<div id='collapsePeerComparison' class='collapse' aria-labelledby='headingPeerComparison' data-parent='#accordion'>";
            echo "<div class='card-body'>";
                echo "<div class='vertical-chart-box'>";
                    echo "<div>Sign Up</div>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
    echo "</div>";
echo "</div>";

echo "<div class='largeMargin'>";
echo "<h3 class='m-5'>Below is for Testing Purposes Only</h3>";
echo "</div>";



// Begin Container for Further Analysis and Testing charts
echo "<div class='vertical-chart-container mt-5'>";
echo "<div class='chart-container'>";


// Game Performance
echo "<div class='chart-box'>";
echo "<div id='monthlyPerformanceChart'></div>";
echo "</div>";

// Quartile RPM (quartileAnalysisChart)
echo "<div class='chart-box'>";
echo "<div id='quartileAnalysisChart'></div>";
echo "</div>";

//RandomChart
echo "<div class='chart-box'>";
echo "<div id='testChart'></div>";
echo "</div>";


// End Container for Further Analysis and Testing charts
echo "</div>";
echo "</div>";

// Full container - Lifecycle Analysis DataGrid
echo "<div class='reel-game-container'>";
echo "<h3>Lifecycle Analysis</h3>";
echo "<div id='dataGridContainer'></div>";
echo "</div>";