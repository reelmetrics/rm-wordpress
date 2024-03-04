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
echo "<h2 class='reel-game-title'>" . esc_html($game_data['title']) . "</h2>";
echo "<p><strong>Supplier: </strong>" . esc_html($game_data['supplier']) . "</p>";
echo "<p><strong>Cost Model: </strong>" . esc_html($game_data['cost_model']) . "</p>";
echo "</div>"; 
echo "<div class='metrics-flex-container'>";
$metrics_titles = ["TERMINALS", "VENUES", "MONTHS"];
foreach ($metrics_titles as $index => $title) {
    echo "<div class='metric-box'>";
    echo "<h3>$title</h3>";
    echo "<div class='metric-number'>" . esc_html($game_data['stats_json'][$index][0]['value']) . "</div>";
    $skip_first = true;
    echo "<ul>";
    foreach ($game_data['stats_json'][$index] as $metric) {
        if ($skip_first) {
            $skip_first = false;
            continue;
        }
        echo "<li><strong>" . esc_html($metric['key']) . ": </strong>" . esc_html($metric['value']) . "</li>";
    }
    echo "</ul>";
    echo "</div>";
}
echo "</div>"; 
echo "</div>"; 
echo "</div>"; 

    // 2. Performance Profile
    echo "<div class='reel-game-container performance-profile-container'>"; 

    echo "<div id='performanceAccordion'>";
    
    echo "<div class='card'>";
    // Accordion title for Performance Profile
    echo "<div class='card-header d-flex justify-content-between align-items-center' id='headingPerformanceProfile'>";
    echo "<h3 class='mb-0'>2. Performance Profile</h3>";   // Title as H3
    echo "<button class='btn btn-link chevron-button' data-toggle='collapse' data-target='#collapsePerformanceProfile' aria-expanded='true' aria-controls='collapsePerformanceProfile' id='chevron-button-performanceprofile'>";
    echo "<span class='chevron'><i class='fa fa-chevron-down'></i></span>";  // Font Awesome chevron icon
    echo "</button>";
    echo "</div>";
    
            // Accordion content for Performance Profile
            echo "<div id='collapsePerformanceProfile' class='collapse show' aria-labelledby='headingPerformanceProfile' data-parent='#performanceAccordion'>";
                echo "<div class='card-body'>";
    
                    // Key Metrics Overview
                    echo "<div class='metrics-overview'>";
                    echo "<h4>Key Metrics</h4>";
                    echo "<table class='table table-bordered'>";
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

    // Performance  over Time
echo "<div class='reel-game-container vertical-chart-container'>"; 

echo "<div id='accordion'>";

echo "<div class='card'>";
// Accordion title
echo "<div class='card-header d-flex justify-content-between align-items-center' id='headingGamePerformance'>";
echo "<h3 class='mb-0'>2. Performance Over Time </h3>";   // Title as H3
echo "<button class='btn btn-link chevron-button' data-toggle='collapse' data-target='#collapseGamePerformance' aria-expanded='true' aria-controls='collapseGamePerformance' id='chevron-button-gameperformance'>";
echo "<span class='chevron'><i class='fa fa-chevron-down'></i></span>";  // Font Awesome chevron icon
echo "</button>";
echo "</div>";

        // Accordion content
        echo "<div id='collapseGamePerformance' class='collapse show' aria-labelledby='headingGamePerformance' data-parent='#accordion'>";
            echo "<div class='card-body'>";

                // TimeSeries Chart
                echo "<div class='vertical-chart-box'>";
                    echo "<div id='timeSeriesChart'></div>"; //2.  Performance over Time
                    echo "<div id='adoptionOverTimeChart'></div>"; // 3. Adoption Over Time
                    echo "<div id='revenueInsightsChart'></div>"; // 4 - Revenue Insights

                echo "</div>";

            echo "</div>"; // Close the card-body
        echo "</div>"; // Close the Accordion content
    echo "</div>"; // Close the card

echo "</div>"; // Close the accordion


echo "</div>"; // Close the chart-container

 

// 3. Market Presence
echo "<div class='reel-game-container vertical-chart-container'>"; 
echo "<div class='card'>";
echo "<div class='card-header d-flex justify-content-between align-items-center' id='headingMarketPresence'>";
echo "<h3 class='mb-0'>3. Market Presence</h3>";   
echo "<button class='btn btn-link chevron-button' data-toggle='collapse' data-target='#collapseMarketPresence' aria-expanded='true' aria-controls='collapseMarketPresence' id='chevron-button-marketpresence'>";
echo "<span class='chevron'><i class='fa fa-chevron-down'></i></span>";  
echo "</button>";
echo "</div>";
echo "<div id='collapseMarketPresence' class='collapse' aria-labelledby='headingMarketPresence' data-parent='#accordion'>";
echo "<div class='card-body'>";
echo "<div class='vertical-chart-box'>";
echo "<div id='marketShareParetoChart'></div>"; // 5. Market Share
echo "<div id='terminalsParetoChart'></div>"; // 6. Terminal Distribution & Status
echo "<div id='venuesParetoChart'></div>"; //7. Venue Distribution & Analysis
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";

// 4. Premium
echo "<div class='reel-game-container vertical-chart-container'>"; 
echo "<div class='card'>";
echo "<div class='card-header d-flex justify-content-between align-items-center' id='headingPeerComparison'>";
echo "<h3 class='mb-0'>4. Dive Deeper</h3>";   
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

// Tenth container - Deep Dive Analyis
echo "</div>";


// Begin Container for Further Analysis and Testing charts
echo "<div class='reel-game-container chart-container'>";

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

// Full container - Lifecycle Analysis DataGrid
echo "<div class='reel-game-container'>";
echo "<h3>Lifecycle Analysis</h3>";
echo "<div id='dataGridContainer'></div>";
echo "</div>";