import type { AuthUser } from "../types/auth.type";


const TOKEN_KEY = "opstrace_token";
const USER_KEY = "opstrace_user";

export const saveAuth = (user: AuthUser) => {
    localStorage.setItem(TOKEN_KEY, user.token);
    localStorage.setItem(USER_KEY, JSON.stringify(user));
}

export const clearAuth = () => {
    localStorage.removeItem(TOKEN_KEY);
    localStorage.removeItem(USER_KEY);
}

export const getToken = () => localStorage.getItem(TOKEN_KEY);

export const getUser = () => {
    const raw = localStorage.getItem(USER_KEY);
    if (!raw) return null;

    try {
        return JSON.parse(raw);
    } catch (e) {
        return null;
    }
}