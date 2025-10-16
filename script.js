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
// Add task
document.getElementById("addTaskForm").addEventListener("submit", (e) => {
  e.preventDefault();

  const taskName = document.getElementById("taskInput").value;
  const priority = document.getElementById("prioritySelect").value;

  fetch("tasks.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `action=add&task_name=${encodeURIComponent(taskName)}&priority=${encodeURIComponent(priority)}&user_id=${user_id}`
  })
      .then((response) => response.json())
      .then((data) => {
          alert(data.message);
          if (data.status === "success") {
              document.getElementById("addTaskForm").reset();
              fetchTasks();
          }
      })
      .catch((error) => {
          console.error("Error:", error);
          alert("An error occurred while adding the task.");
      });
});

// Fetch tasks with optional filter
function fetchTasks(filter = "all") {
  fetch(`tasks.php?action=fetch&user_id=${user_id}&filter=${filter}`)
      .then((response) => response.json())
      .then((tasks) => {
          const taskList = document.getElementById("taskList");
          taskList.innerHTML = "";

          if (tasks.length === 0) {
              taskList.innerHTML = '<div class="alert alert-info">No tasks found. Add your first task above!</div>';
          } else {
              tasks.forEach((task) => {
                  const taskStatus = task.status || 'active'; // Fallback to 'active' if status is undefined
                  const taskItem = document.createElement("div");
                  taskItem.classList.add("list-group-item", "d-flex", "justify-content-between", "align-items-center");
                  taskItem.innerHTML = `
                      <div>
                          <span class="task-name">${task.task_name}</span>
                          <span class="badge bg-${getPriorityClass(task.priority)} ms-2">${task.priority}</span>
                      </div>
                      <div>
                          <button class="btn btn-sm btn-outline-success" onclick="updateTaskStatus(${task.id}, '${taskStatus === "active" ? "completed" : "active"}')">
                              ${taskStatus === "active" ? "Complete" : "Undo"}
                          </button>
                          <button class="btn btn-sm btn-outline-danger" onclick="deleteTask(${task.id})">
                              Delete
                          </button>
                      </div>
                  `;
                  taskList.appendChild(taskItem);
              });
          }

          updateTaskStats(tasks);
      })
      .catch((error) => {
          console.error("Error:", error);
          alert("An error occurred while fetching tasks.");
      });
}

// Update task status
function updateTaskStatus(taskId, status) {
  fetch("tasks.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `action=update&task_id=${taskId}&status=${status}&user_id=${user_id}`
  })
      .then((response) => response.json())
      .then((data) => {
          alert(data.message);
          if (data.status === "success") {
              fetchTasks(document.querySelector(".btn-group .active").dataset.filter || "all");
          }
      })
      .catch((error) => {
          console.error("Error:", error);
          alert("An error occurred while updating the task.");
      });
}

// Delete task
function deleteTask(taskId) {
  if (confirm("Are you sure you want to delete this task?")) {
      fetch("tasks.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `action=delete&task_id=${taskId}&user_id=${user_id}`
      })
          .then((response) => response.json())
          .then((data) => {
              alert(data.message);
              if (data.status === "success") {
                  fetchTasks(document.querySelector(".btn-group .active").dataset.filter || "all");
              }
          })
          .catch((error) => {
              console.error("Error:", error);
              alert("An error occurred while deleting the task.");
          });
  }
}

// Clear completed tasks
document.getElementById("clearCompletedBtn").addEventListener("click", () => {
  if (confirm("Are you sure you want to clear all completed tasks?")) {
      fetch("tasks.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `action=clear_completed&user_id=${user_id}`
      })
          .then((response) => response.json())
          .then((data) => {
              alert(data.message);
              if (data.status === "success") {
                  fetchTasks(document.querySelector(".btn-group .active").dataset.filter || "all");
              }
          })
          .catch((error) => {
              console.error("Error:", error);
              alert("An error occurred while clearing completed tasks.");
          });
  }
});

// Filter tasks
document.querySelectorAll(".btn-group button").forEach((button) => {
  button.addEventListener("click", () => {
      document.querySelectorAll(".btn-group button").forEach((btn) => btn.classList.remove("active"));
      button.classList.add("active");
      fetchTasks(button.dataset.filter);
  });
});

// Update task statistics
function updateTaskStats(tasks) {
  const total = tasks.length;
  const completed = tasks.filter((task) => (task.status || 'active') === 'completed').length;
  const remaining = total - completed;
  document.getElementById("taskStats").textContent = `${total} total tasks | ${completed} completed | ${remaining} remaining`;
}

// Initial task fetch
fetchTasks();
