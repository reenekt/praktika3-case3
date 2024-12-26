import type {NuxtError} from "#app/composables/error";
import type {DefaultAsyncDataErrorValue} from "#app/defaults";
import type {AsyncData, PickFrom} from "#app/composables/asyncData";

type HTTPMethod = 'GET' | 'POST' | 'PUT' | 'PATCH' | 'DELETE'

export default async function <RespT, ErrRespT = unknown>(
  method: HTTPMethod,
  path: string,
  data?: Record<string, any>,
  uniqueKey?: string,
  options?: object,
  lazy?: boolean
): Promise<AsyncData<RespT, (ErrRespT extends NuxtError | Error ? ErrRespT : NuxtError<ErrRespT>)>>
{
  const client = useSanctumClient();

  return useAsyncData<RespT, ErrRespT>(
    uniqueKey ? uniqueKey : `${method} ${path}`,
    () => {
      return client(path, {
        method: method,
        headers: {
          'Accept': 'application/json',
        },
        body: data ? data : null,
        ...(options ? options : {}),
      })
    },
    {lazy: lazy !== undefined ? lazy : false}
  ) as unknown as Promise<AsyncData<RespT, (ErrRespT extends NuxtError | Error ? ErrRespT : NuxtError<ErrRespT>)>>
}
