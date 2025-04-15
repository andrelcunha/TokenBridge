<script>
import { ref } from 'vue';
import axios from 'axios';
import { Task } from 'src/models/Task';

export default {
  name: 'TasksPage',
  setup() {
    const tasks = ref([]);
    const dialogOpen = ref(false);
    const taskTitle = ref('');
    const selectedTask = ref(null);

    const fetchTasks = async () => {
      const token = getCookie('token');
      try {
        const response = await axios.get('http://localhost:8002/api/tasks', {
          headers: { Authorization: `Bearer ${token}` },
        });
        tasks.value = response.data.map(
          (task) => new Task(task.id, task.title, task.description, task.status, task.user_id)
        );

      } catch (error) {
        console.error('Error fetching tasks:', error);
      }
    };

    const addTask = async (taskTitle) => {
      const token = getCookie('token');
      try {
        const response = await axios.post(
          'http://localhost:8002/api/tasks',
          { title: taskTitle },
          { headers: { Authorization: `Bearer ${token}` } }
        );
        tasks.value.push(response.data);
      } catch (error) {
        console.error('Error adding task:', error);
      }
    };

    const editTask = async (task) => {
      const token = getCookie('token');
      try {
        await axios.put(
          `http://localhost:8002/api/tasks/${task.id}`,
          task,
          { headers: { Authorization: `Bearer ${token}` } }
        );
        fetchTasks();
      } catch (error) {
        console.error('Error editing task:', error);
      }
    };

    const deleteTask = async (taskId) => {
      const token = getCookie('token');
      try {
        await axios.delete(`http://localhost:8002/api/tasks/${taskId}`, {
          headers: { Authorization: `Bearer ${token}` },
        });
        tasks.value = tasks.value.filter((task) => task.id !== taskId);
      } catch (error) {
        console.error('Error deleting task:', error);
      }
    };

    const getCookie = (name) => {
      const value = `; ${document.cookie}`;
      const parts = value.split(`; ${name}=`);
      return parts.length === 2 ? parts.pop().split(';').shift() : '';
    };

    const openTaskDialog = (task = null) => {
      selectedTask.value = task;
      taskTitle.value = task ? task.title : '';
      dialogOpen.value = true;
    };

    const saveTask = async () => {
      if (selectedTask.value) {
        selectedTask.value.title = taskTitle.value;
        await editTask(selectedTask.value);
      } else {
        await addTask(taskTitle.value);
      }
      dialogOpen.value = false;
      taskTitle.value = '';
      selectedTask.value = null;
    };

    fetchTasks();

    return {
      tasks,
      addTask,
      editTask,
      deleteTask,
      dialogOpen,
      taskTitle,
      openTaskDialog,
      saveTask,
    };
  },
};
</script>


<template>
  <q-page>
    <div class="q-pa-md">
      <q-card>
        <q-card-section>
          <h2>Task Manager</h2>
        </q-card-section>
        <q-separator />
        <q-card-section>
          <q-btn label="Add Task" @click="openTaskDialog" color="primary" />
        </q-card-section>
        <q-list bordered separator>
          <q-item
            v-for="task in tasks"
            :key="task.id"
            clickable
            @click="editTask(task)"
          >
            <q-item-section>{{ task.title }}</q-item-section>
            <q-item-section side>
              <q-btn
                icon="delete"
                @click.stop="deleteTask(task.id)"
                flat
                round
                color="negative"
              />
            </q-item-section>
          </q-item>
        </q-list>
      </q-card>
    </div>
  </q-page>
  <q-dialog v-model="dialogOpen">
  <q-card>
    <q-card-section>
      <q-input
        v-model="taskTitle"
        label="Task Title"
        filled
        lazy-rules
      />
      <q-input
        v-model="taskDescription"
        label="Task Description"
        filled
        type="textarea"
        lazy-rules
      />
      <q-select
      v-model="taskStatus"
      label="Task Status"
      :options="[
        { label: 'Pending', value: 'Pending' },
        { label: 'In Progress', value: 'in_progress' },
        { label: 'Completed', value: 'completed' },
      ]"
      filled
      lazy-rules
      />
      <q-input
      v-model="taskDueDate"
      label="Due Date"
      filled
      type="date"
      lazy-rules
      />
    </q-card-section>
    <q-card-actions align="right">
      <q-btn flat label="Cancel" color="negative" @click="dialogOpen = false" />
      <q-btn
        flat
        label="Save"
        color="positive"
        @click="saveTask"
      />
    </q-card-actions>
  </q-card>
  </q-dialog>
</template>
