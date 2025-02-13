export interface User {
  id: int
  name: string,
  email: string,
  email_verified_at: string|null,
  is_superuser: boolean,
  created_at: string|null,
  updated_at: string|null,
}

interface UserData {
  data: User,
}
interface UsersResponse {
  data: User[],
}
