<?php
include('db_connect.php');

// Helper function for ordinal suffix
function ordinal_suffix1($num) {
    $num = $num % 100; // Protect against large numbers
    if ($num < 11 || $num > 13) {
        switch ($num % 10) {
            case 1: return $num . 'st';
            case 2: return $num . 'nd';
            case 3: return $num . 'rd';
        }
    }
    return $num . 'th';
}

// Academic status array
$astat = array("Not Yet Started", "On-going", "Closed");

// Get the full name from the session
$login_name = $_SESSION['login_name'] ?? null;

if (!$login_name) {
    echo "Error: User is not logged in!";
    exit;
}

// Split the name into firstname and lastname
$name_parts = explode(' ', $login_name);
$firstname = $name_parts[0];
$lastname = isset($name_parts[1]) ? $name_parts[1] : '';

if (empty($firstname) || empty($lastname)) {
    echo "Error: Invalid name format!";
    exit;
}

// Fetch the faculty_id based on the displayed name
$faculty_query = $conn->query("SELECT id FROM faculty_list WHERE firstname = '$firstname' AND lastname = '$lastname'");
$faculty = $faculty_query->fetch_assoc();

if (!$faculty) {
    echo "Error: Faculty not found!";
    exit;
}

// Get the faculty_id
$faculty_id = $faculty['id'];

// Fetch specific average rating and rating distribution for the selected faculty_id
$avg_query = $conn->query("SELECT AVG(rate) AS average_rating 
                           FROM evaluation_answers 
                           WHERE faculty_id = $faculty_id");
$avg_result = $avg_query->fetch_assoc();
$average_rating = round($avg_result['average_rating'] ?? 0, 2);

// Determine the review status based on the average rating
$status = 'Negative';
if ($average_rating >= 4) {
    $status = 'Positive';
} elseif ($average_rating >= 3) {
    $status = 'Average';
}

// Fetch rating distribution for the selected faculty_id
$rating_query = $conn->query("SELECT rate, COUNT(*) as count 
                              FROM evaluation_answers 
                              WHERE faculty_id = $faculty_id
                              GROUP BY rate");
$rating_data = [];
$total_reviews = 0;
while ($row = $rating_query->fetch_assoc()) {
    $rating_data[$row['rate']] = $row['count'];
    $total_reviews += $row['count'];
}

// Ensure all ratings from 1 to 5 are represented
for ($i = 1; $i <= 5; $i++) {
    if (!isset($rating_data[$i])) {
        $rating_data[$i] = 0;
    }
}

// Calculate percentage of each rating
$rating_percentages = [];
foreach ($rating_data as $rate => $count) {
    $rating_percentages[$rate] = $total_reviews > 0 ? round(($count / $total_reviews) * 100, 2) : 0;
}
?>

<!-- HTML Section -->
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h4>Welcome <?php echo $_SESSION['login_name'] ?>!</h4>
            <p style="display: none;">
                Faculty: <b><?php echo $firstname . ' ' . $lastname; ?></b><br>
                Faculty ID: <b><?php echo $faculty_id; ?></b>
            </p>
            <div class="col-md-5">
                <div class="callout callout-info">
                    <h5><b>Academic Year: <?php echo $_SESSION['academic']['year'] . ' ' . (ordinal_suffix1($_SESSION['academic']['semester'])) ?> Semester</b></h5>
                    <h6><b>Evaluation Status: <?php echo $astat[$_SESSION['academic']['status']] ?></b></h6>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5>Faculty Evaluation Status</h5>
        </div>
        <div class="card-body">
            <dl>
                <dt>Average Rating</dt>
                <dd><?php echo $average_rating ?> / 5</dd>

                <dt>Total Reviews</dt>
                <dd><?php echo $total_reviews ?></dd>

                <dt>Status</dt>
                <dd>
                    <span class="badge <?php echo ($status == 'Positive') ? 'badge-success' : (($status == 'Average') ? 'badge-warning' : 'badge-danger') ?>">
                        <?php echo $status ?>
                    </span>
                </dd>
            </dl>
        </div>
        <div class="card-body">
        <canvas id="ratingChart" style="width: 200px; height: 60px;"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('ratingChart').getContext('2d');
    var ratingData = <?php echo json_encode($rating_data); ?>;

    var ratingChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [1, 2, 3, 4, 5],
            datasets: [{
                label: 'Number of Reviews',
                data: [ratingData[1], ratingData[2], ratingData[3], ratingData[4], ratingData[5]],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        afterLabel: function(context) {
                            var percentage = <?php echo json_encode($rating_percentages); ?>;
                            return percentage[context.raw] + '% of total reviews';
                        }
                    }
                }
            }
        }
    });
</script>
