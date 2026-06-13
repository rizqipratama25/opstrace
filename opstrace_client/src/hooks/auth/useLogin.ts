import { useMutation } from "@tanstack/react-query"
import type { LoginPayload } from "../../types/auth.type"
import { login } from "../../services/auth.service"
import { saveAuth } from "../../utils/authStorage"
import api from "../../lib/axios"

export const useLogin = () => {
    return useMutation({
        mutationFn: (payload: LoginPayload) => login(payload),
        onSuccess: (res) => {
            const user = res;
            saveAuth(res);
            api.defaults.headers.common.Authorization = `Bearer ${user.token}`
        }
    })
}