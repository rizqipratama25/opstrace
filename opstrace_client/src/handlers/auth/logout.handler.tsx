import type { MouseEventHandler } from "react";
import toast from "react-hot-toast";
import type { NavigateFunction } from "react-router-dom";

export const buildHandleLogout = (
    logout: (payload?: any, options?: any) => void,
    navigate: NavigateFunction
): MouseEventHandler<HTMLButtonElement> => {
    return (e) => {
        e.preventDefault();

        logout(undefined, {
            onSuccess: () => {
                toast.success("Logged Out Successfully");

                if (window.location.pathname === "/") {
                    window.location.reload();
                } else {
                    navigate("/");  
                }
            },
            onError: (err: any) => {
                const message = err?.response?.data?.message ?? err.message;
                toast.error(message);
            }
        })
    }
}