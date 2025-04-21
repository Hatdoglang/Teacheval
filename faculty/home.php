<?php
include('db_connect.php');

// Helper function for ordinal suffix
function ordinal_suffix1($num)
{
    $num = $num % 100; // Protect against large numbers
    if ($num < 11 || $num > 13) {
        switch ($num % 10) {
            case 1:
                return $num . 'st';
            case 2:
                return $num . 'nd';
            case 3:
                return $num . 'rd';
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
// Fetch the total number of students who evaluated this faculty
$student_query = $conn->query("SELECT COUNT(DISTINCT student_id) AS total_students 
                               FROM evaluation_list 
                               WHERE faculty_id = $faculty_id");
$student_result = $student_query->fetch_assoc();
$total_students = $student_result['total_students'] ?? 0;

// Fetch rating distribution for the selected faculty_id
$rating_query = $conn->query("SELECT rate, COUNT(*) as count 
                              FROM evaluation_answers 
                              WHERE faculty_id = $faculty_id
                              GROUP BY rate");
$rating_data = [];
while ($row = $rating_query->fetch_assoc()) {
    $rating_data[$row['rate']] = $row['count'];
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
    $rating_percentages[$rate] = $total_students > 0 ? round(($count / $total_students) * 100, 2) : 0;
}


// Fetch and group faculty comments
$comments_query = $conn->query("
    SELECT DISTINCT LOWER(TRIM(comments)) AS comment 
    FROM evaluation_answers 
    WHERE faculty_id = $faculty_id AND TRIM(comments) != ''
");

$comments = [];
while ($row = $comments_query->fetch_assoc()) {
    $comments[] = ucfirst(htmlspecialchars($row['comment'])); // Capitalize first letter and prevent XSS
}

// Fetch the faculty_id based on the logged-in faculty name
$faculty_query = $conn->query("SELECT id FROM faculty_list WHERE firstname = '$firstname' AND lastname = '$lastname'");
$faculty = $faculty_query->fetch_assoc();

if (!$faculty) {
    echo "Error: Faculty not found!";
    exit;
}

$faculty_id = $faculty['id'];

// Fetch assigned subjects and class names from restriction_list
$subjects_query = $conn->query("
    SELECT s.code AS subject_code, s.subject AS subject_name, 
           CONCAT(c.level, '-', c.section) AS class_name 
    FROM restriction_list r
    JOIN subject_list s ON r.subject_id = s.id
    JOIN class_list c ON r.class_id = c.id
    WHERE r.faculty_id = $faculty_id
");

$subjects = [];
while ($row = $subjects_query->fetch_assoc()) {
    $subjects[] = $row;
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
                    <h5><b>Academic Year:
                            <?php echo $_SESSION['academic']['year'] . ' ' . (ordinal_suffix1($_SESSION['academic']['semester'])) ?>
                            Semester</b></h5>
                    <h6><b>Evaluation Status: <?php echo $astat[$_SESSION['academic']['status']] ?></b></h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Subject & Class List Section -->
<div class="col-12">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5>Assigned Subjects & Classes</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($subjects)): ?>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Class</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subjects as $subject): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($subject['subject_code']); ?></td>
                                <td><?php echo htmlspecialchars($subject['subject_name']); ?></td>
                                <td><?php echo htmlspecialchars($subject['class_name']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-light text-center">No subjects assigned.</div>
            <?php endif; ?>
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

                <dt>Total Students</dt>
                <dd><?php echo $total_students ?></dd>


                <dt>Status</dt>
                <dd>
                    <span
                        class="badge <?php echo ($status == 'Positive') ? 'badge-success' : (($status == 'Average') ? 'badge-warning' : 'badge-danger') ?>">
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
<!-- Comment Display with Scroll -->
<div class="col-12">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5>Student Comments</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($comments)): ?>
                <div style="max-height: 300px; overflow-y: auto;"> <!-- Enable scrolling if comments exceed 7 -->
                    <ul class="list-group">
                        <?php foreach ($comments as $comment): ?>
                            <li class="list-group-item"><?php echo $comment; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php else: ?>
                <div class="alert alert-light text-center">No comments available.</div>
            <?php endif; ?>
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
            labels: ['Ratings'], // Single category for better grouping
            datasets: [
                {
                    label: 'Strongly Disagree (1 Star)',
                    data: [ratingData[1]],
                    backgroundColor: 'rgba(255, 99, 132, 0.6)', // Red
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Disagree (2 Stars)',
                    data: [ratingData[2]],
                    backgroundColor: 'rgba(255, 165, 0, 0.6)', // Orange
                    borderColor: 'rgba(255, 165, 0, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Uncertain (3 Stars)',
                    data: [ratingData[3]],
                    backgroundColor: 'rgba(255, 206, 86, 0.6)', // Yellow
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Agree (4 Stars)',
                    data: [ratingData[4]],
                    backgroundColor: 'rgba(54, 162, 235, 0.6)', // Blue
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Strongly Agree (5 Stars)',
                    data: [ratingData[5]],
                    backgroundColor: 'rgba(75, 192, 75, 0.6)', // Green
                    borderColor: 'rgba(75, 192, 75, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: 'black',
                        font: {
                            size: 14,
                            weight: 'bold'
                        },
                        padding: 15
                    }
                },
                tooltip: {
                    enabled: true // Disable hover tooltips
                }
            },
            hover: {
                mode: null // Completely disable hover effects
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "Number of Reviews"
                    }
                }
            }
        }
    });
</script>

