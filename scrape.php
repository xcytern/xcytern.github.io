scrape.php (Backend):

php
Copy code
<?php
// Check if the form is submitted
if (isset($_POST['search_query'])) {
    // Get the search query
    $searchQuery = $_POST['search_query'];

    // Fetch the Google search results page
    $googleUrl = "https://www.google.com/search?q=" . urlencode($searchQuery);
    $searchPage = file_get_contents($googleUrl);

    // Parse the HTML response
    $dom = new DOMDocument();
    @$dom->loadHTML($searchPage);

    // Extract the URLs of the first ten websites
    $links = $dom->getElementsByTagName('a');
    $searchResults = array();

    foreach ($links as $link) {
        $href = $link->getAttribute('href');
        if (strpos($href, '/url?q=') !== false) {
            $url = urldecode(substr($href, strpos($href, '/url?q=') + 7, strpos($href, '&') - (strpos($href, '/url?q=') + 7)));
            $searchResults[] = $url;
        }
    }

    // Display the search results
    echo "<h2>Search Results for: " . $searchQuery . "</h2>";
    echo "<ol>";
    foreach ($searchResults as $result) {
        echo "<li><a href='$result'>$result</a></li>";
    }
    echo "</ol>";
}
?>






