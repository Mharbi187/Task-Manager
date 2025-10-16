<?php
session_start();
include('connection.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user_id'];
$action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];

header('Content-Type: application/json');

if ($action === 'add') {
    $task_name = $_POST['task_name'] ?? '';
    $priority = $_POST['priority'] ?? 'medium';

    if (empty($task_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Task name is required']);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO tasks (task_name, priority, status, user_id, created_at) VALUES (?, ?, 'active', ?, NOW())");
    $stmt->bind_param("ssi", $task_name, $priority, $user_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Task added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add task']);
    }
    $stmt->close();
} elseif ($action === 'fetch') {
    $filter = $_GET['filter'] ?? 'all';
    $query = "SELECT * FROM tasks WHERE user_id = ?";
    if ($filter === 'active') {
        $query .= " AND status = 'active'";
    } elseif ($filter === 'completed') {
        $query .= " AND status = 'completed'";
    }
    $query .= " ORDER BY created_at DESC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $tasks = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($tasks);
    $stmt->close();
} elseif ($action === 'update') {
    $task_id = $_POST['task_id'] ?? 0;
    $status = $_POST['status'] ?? '';

    $stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sii", $status, $task_id, $user_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Task updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update task']);
    }
    $stmt->close();
} elseif ($action === 'delete') {
    $task_id = $_POST['task_id'] ?? 0;

    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $user_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Task deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete task']);
    }
    $stmt->close();
} elseif ($action === 'clear_completed') {
    $stmt = $conn->prepare("DELETE FROM tasks WHERE status = 'completed' AND user_id = ?");
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Completed tasks cleared']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to clear completed tasks']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}
?>