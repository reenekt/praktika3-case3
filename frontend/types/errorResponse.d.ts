export default interface ErrorResponse {
  message: string,
  errors: Record<string, string[]>
}
