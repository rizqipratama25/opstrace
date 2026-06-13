import { useMutation } from "@tanstack/react-query"
import type { RegisterPayload } from "../../types/auth.type"
import { register } from "../../services/auth.service"
import { saveAuth } from "../../utils/authStorage"
import api from "../../lib/axios"

export const useRegister = () => {
    return useMutation({
        mutationFn: (payload: RegisterPayload) => register(payload),
        onSuccess: (res) => {
            const user = res;
            saveAuth(res);
            api.defaults.headers.common.Authorization = `Bearer ${user.token}`
        }
    })
}