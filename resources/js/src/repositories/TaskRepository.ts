import axios from 'axios'

export type Task = {
  id: number
  title: string
  body: string
  is_archived: boolean
  created_at: Date
  updated_at: Date
}

export const index = async (): Promise<Task[]> => {
  const res = await axios.get('/tasks')
  return res.data.data
}

export const create = async (title: string, body: string): Promise<void> => {
  await axios.post('/tasks', {
    title,
    body
  })
}

export const update = async (id: number, title: string, body: string): Promise<void> => {
  await axios.put(`/tasks/${id}`, {
    title,
    body
  })
}

export const archive = async (id: number): Promise<void> => {
  await axios.put(`/tasks/${id}/archive`)
}

export const unarchive = async (id: number): Promise<void> => {
  await axios.put(`/tasks/${id}/unarchive`)
}
