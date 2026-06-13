import api from "../lib/axios";
import type { ApiResponse } from "../types/apiResponse.type";
import type { AuthUser, LoginPayload, RegisterPayload } from "../types/auth.type";

export const login = async (payload: LoginPayload): Promise<AuthUser> => {
    const res = await api.post<ApiResponse<AuthUser>>("/auth/login", payload);
    return res.data.data;
};

export const register = async (payload: RegisterPayload): Promise<AuthUser> => {
    const res = await api.post<ApiResponse<AuthUser>>("/auth/register", payload);
    return res.data.data;
}

export const me = async (): Promise<AuthUser> => {
    const res = await api.get<ApiResponse<AuthUser>>("/auth/me");
    return res.data.data;
}

export const logout = async (): Promise<void> => {
    await api.post("/auth/logout");
}