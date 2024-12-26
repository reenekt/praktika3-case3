import type {User} from "~/types/user";

export enum TaskStatusEnum {
  NEW = 'new',
  IN_PROGRESS = 'in_progress',
  DONE = 'done',
}

export interface Task {
  id: number,
  title: string,
  description_content: string,
  status: `${TaskStatusEnum}`,
  author_id: number,
  assignee_id: number | null,
  deadline_at: string | null | Date,
  created_at: string | null,
  updated_at: string | null,
  author?: User,
  assignee?: User,
}

export interface TasksResponse {
  data: Task[]
}

export interface TaskResponse {
  data: Task
}
