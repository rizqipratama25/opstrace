export interface AuthUser {
    id: number;
    name: string;
    email: string;
    telegram_username: string;
    telegram_id: string;
    token: string;
}

export interface LoginPayload {
    email: string;
    password: string;
}

export interface RegisterPayload {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
}