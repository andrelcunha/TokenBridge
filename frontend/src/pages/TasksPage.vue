<script>
import { ref } from 'vue';
import axios from 'axios';

export default {
  name: 'TasksPage',
  setup() {
    const tasks = ref([]);
    const dialogOpen = ref(false);
    const taskName = ref('');
    const selectedTask = ref(null);

    const fetchTasks = async () => {
      const token = getCookie('token');
      try {
        console.log('Token:', token);
        const response = await axios.get('http://localhost:8002/api/tasks', {
          headers: { Authorization: `Bearer ${token}` },
        });
        tasks.value = response.data;
      } catch (error) {
        console.error('Error fetching tasks:', error);
      }
    };

    const addTask = async (taskName) => {
      const token = getCookie('token');
      try {
        const response = await axios.post(
          'http://localhost:8002/api/tasks',
          { name: taskName },
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
      taskName.value = task ? task.name : '';
      dialogOpen.value = true;
    };

    const saveTask = async () => {
      if (selectedTask.value) {
        selectedTask.value.name = taskName.value;
        await editTask(selectedTask.value);
      } else {
        await addTask(taskName.value);
      }
      dialogOpen.value = false;
      taskName.value = '';
      selectedTask.value = null;
    };

    fetchTasks();

    return {
      tasks,
      addTask,
      editTask,
      deleteTask,
      dialogOpen,
      taskName,
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
            <q-item-section>{{ task.name }}</q-item-section>
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
        v-model="taskName"
        label="Task Name"
        filled
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
