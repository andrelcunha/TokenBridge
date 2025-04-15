export class Task {
    constructor(id, title, description = '', status, due_date, user_id) {
      this.id = id;           // Unique identifier
      this.title = title;     // Title of the task
      this.description = description; // Optional description
      this.status = status;   // Status, e.g., "completed" or "pending"
      this.due_date = due_date; // Due date (ISO format)
      this.user_id = user_id; // User associated with the task
    }
}
