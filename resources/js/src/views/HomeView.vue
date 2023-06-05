<script setup lang="ts">
import { ref } from 'vue'
import type { Task as TaskData } from '@/repositories/TaskRepository'
import { archive, create, index, update } from '@/repositories/TaskRepository'

type Task = TaskData & { editing: boolean; newTitle: string; newBody: string }

const loading = ref(false)
const errorMessage = ref<string | null>(null)
const tasks = ref<Task[]>([])
const title = ref('')
const body = ref('')

const fetch = async () => {
  tasks.value = (await index()).map((task) => ({
    ...task,
    editing: false,
    newTitle: '',
    newBody: ''
  }))
}

const updateTask = (id: number, values: Partial<Task>) => {
  const index = tasks.value.findIndex((task) => task.id === id)
  if (index >= 0) {
    tasks.value.splice(index, 1, { ...tasks.value[index], ...values })
  }
}

const onSubmit = async () => {
  if (loading.value) {
    return
  }

  const titleValue = title.value.trim()
  const bodyValue = body.value.trim()
  if (titleValue === '' || bodyValue === '') {
    return
  }

  loading.value = true
  errorMessage.value = null
  try {
    await create(titleValue, bodyValue)
    title.value = ''
    body.value = ''
    await fetch()
  } catch (error) {
    console.error(error)
    errorMessage.value = '失敗しました'
  } finally {
    loading.value = false
  }
}

const saveTask = async (id: number) => {
  if (loading.value) {
    return
  }
  const task = tasks.value.find((task) => task.id === id)
  if (!task || !task.editing) {
    return
  }
  const newTitle = task.newTitle.trim()
  const newBody = task.newBody.trim()
  if (newTitle === '' || newBody === '') {
    return
  }

  loading.value = true
  errorMessage.value = null
  try {
    await update(task.id, newTitle, newBody)
    await fetch()
  } catch (error) {
    console.error(error)
    errorMessage.value = '失敗しました'
  } finally {
    loading.value = false
  }
}

const archiveTask = async (id: number) => {
  if (loading.value) {
    return
  }
  loading.value = true
  errorMessage.value = null
  try {
    await archive(id)
    await fetch()
  } catch (error) {
    console.error(error)
    errorMessage.value = 'アーカイブに失敗しました'
  } finally {
    loading.value = false
  }
}

fetch()
</script>

<template>
  <div class="root">
    <form class="form" @submit.prevent="onSubmit">
      <div class="form-group">
        <label>タイトル</label>
        <input type="text" v-model="title" />
      </div>
      <div class="form-group">
        <label>本文</label>
        <textarea v-model="body" rows="5"></textarea>
      </div>
      <div class="button-container">
        <button type="submit">新規追加</button>
      </div>
    </form>
    <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
    <ul class="tasks">
      <li v-for="task in tasks" class="task">
        <div class="header">
          <div class="id">{{ task.id }}:</div>
          <div class="title">
            <span v-if="!task.editing">{{ task.title }}</span>
            <input
              v-if="task.editing"
              type="text"
              :value="task.newTitle"
              @input="updateTask(task.id, { newTitle: $event.target.value })"
            />
          </div>
          <a
            v-if="!task.editing"
            href="#"
            @click.prevent="
              updateTask(task.id, { editing: true, newTitle: task.title, newBody: task.body })
            "
            >編集</a
          >
          <a v-if="task.editing" href="#" @click.prevent="saveTask(task.id)">保存</a>
        </div>
        <div class="body">
          <div v-if="!task.editing" class="task-body">{{ task.body }}</div>
          <textarea
            v-if="task.editing"
            :value="task.newBody"
            rows="5"
            @input="updateTask(task.id, { newBody: $event.target.value })"
          ></textarea>
        </div>
        <div class="footer">
          <a href="#" @click.prevent="archiveTask(task.id)">アーカイブ</a>
        </div>
      </li>
    </ul>
  </div>
</template>

<style lang="scss" scoped>
.root {
  width: 100%;

  form.form {
    display: flex;
    flex-direction: column;

    .form-group {
      display: flex;
      flex-direction: column;
      margin-bottom: 1rem;

      input {
        padding: 0.5rem 1rem;
      }

      textarea {
        padding: 1rem;
      }
    }

    .button-container {
      width: 100%;

      button {
        padding: 0.5rem 1rem;
      }
    }
  }

  .error-message {
    color: red;
  }

  .tasks {
    list-style: none;
    padding: 0;

    .task {
      display: flex;
      flex-direction: column;
      background-color: #fff;
      color: #2a2a2a;
      margin-bottom: 1rem;
      padding: 1rem;

      .header {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin-bottom: 0.5rem;

        .id {
          font-weight: bold;
          margin-right: 1rem;
        }
        .title {
          flex: 1;
          padding: 0.2rem 0;

          input {
            width: calc(100% - 1.6rem);
            padding: 0.5rem 0.8rem;
          }
        }
        a {
          flex: 0 0 auto;
          font-size: 0.8rem;
          margin-left: 1rem;
        }
      }

      .body {
        width: 100%;

        textarea {
          width: 100%;
        }
      }

      .footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        font-size: 0.6rem;
      }
    }
  }
}
</style>
