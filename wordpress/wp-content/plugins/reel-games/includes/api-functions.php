<?php
/**
 * Fetch the game data using the static UUID.
 */
function fetch_reel_game_api_response() {
    $uuid = '7c8fd346-c9f3-46d2-a74f-948bda5a3988';
    $api_url = "https://www.reelmetrics.com/api/games/{$uuid}/performance";

    $response = wp_remote_get($api_url);
    if (is_wp_error($response)) {
        return new WP_Error('api_error', 'Failed to fetch game data: ' . $response->get_error_message());
    }

    $game_data = json_decode(wp_remote_retrieve_body($response), true);
    if (!$game_data) {
        return new WP_Error('no_data', 'No game data found or issue with JSON decoding.');
    }

    return $game_data;
}
?>
