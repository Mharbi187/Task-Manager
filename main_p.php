<?php
session_start();
include('connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch username
$stmt = $conn->prepare("SELECT username FROM accounts WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$username = $user['username'] ?? 'User';
$stmt->close();

// Fetch tasks for the specific user
$query = "SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-4">
                <i class="bi bi-check2-circle"></i> Task Manager
            </h1>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userDropdown"
                    data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i>
                    <span id="usernameDisplay"><?= htmlspecialchars($username); ?></span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a>
                    </li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <a class="dropdown-item text-danger" href="logout.php" id="logoutBtn"><i
                                class="bi bi-box-arrow-right"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Add Task Form -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form id="addTaskForm" class="row g-3">
                    <div class="col-md-8">
                        <input type="text" id="taskInput" class="form-control" placeholder="What needs to be done?"
                            required />
                    </div>
                    <div class="col-md-2">
                        <select id="prioritySelect" class="form-select">
                            <option value="low">Low Priority</option>
                            <option value="medium" selected>Medium Priority</option>
                            <option value="high">High Priority</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-lg"></i> Add
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Task Filters -->
        <div class="d-flex justify-content-between mb-3">
            <div class="btn-group" role="group">
                <button class="btn btn-outline-secondary active" data-filter="all">All Tasks</button>
                <button class="btn btn-outline-secondary" data-filter="active">Active</button>
                <button class="btn btn-outline-secondary" data-filter="completed">Completed</button>
            </div>
            <button class="btn btn-outline-danger" id="clearCompletedBtn">
                <i class="bi bi-trash"></i> Clear Completed
            </button>
        </div>

        <!-- Task List -->
        <div class="list-group" id="taskList">
            <?php if (empty($tasks)): ?>
                <div class="alert alert-info">No tasks found. Add your first task above!</div>
            <?php else: ?>
                <?php foreach ($tasks as $task): ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="task-name"><?= htmlspecialchars($task['task_name']); ?></span>
                            <span class="badge bg-<?= getPriorityClass($task['priority']); ?> ms-2"><?= htmlspecialchars($task['priority']); ?></span>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-success" onclick="updateTaskStatus(<?= $task['id']; ?>, '<?= isset($task['status']) && $task['status'] === 'active' ? 'completed' : 'active'; ?>')">
                                <?= isset($task['status']) && $task['status'] === 'active' ? 'Complete' : 'Undo'; ?>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteTask(<?= $task['id']; ?>)">
                                Delete
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Task Statistics -->
        <div class="mt-3 text-muted">
            <small id="taskStats">
                <?= count($tasks); ?> total tasks | 
                <?= count(array_filter($tasks, fn($task) => isset($task['status']) && $task['status'] === 'completed')); ?> completed | 
                <?= count(array_filter($tasks, fn($task) => !isset($task['status']) || $task['status'] === 'active')); ?> remaining
            </small>
        </div>
    </div>

    <script>
        // Define user_id for JavaScript
        const user_id = <?php echo json_encode($_SESSION['user_id']); ?>;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>

<?php
// Helper function to determine priority badge color
function getPriorityClass($priority)
{
    switch ($priority) {
        case 'low':
            return 'success';
        case 'medium':
            return 'warning';
        case 'high':
            return 'danger';
        default:
            return 'secondary';
    }
}
?>