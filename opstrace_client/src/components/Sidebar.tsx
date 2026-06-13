import type { LucideIcon } from "lucide-react";
import { useState } from "react";
import { useLogout } from "../hooks/auth/useLogout";
import { useNavigate } from "react-router-dom";

interface MenuItem {
    label: string;
    to: string;
    icon: LucideIcon;
}

interface Props {
    menuItems: MenuItem[];
}

const Sidebar = ({ menuItems }: Props) => {
    const [sidebarOpen, setSidebarOpen] = useState(false);

    const {mutate: logout, isPending: isLogoutPending} = useLogout();
    const navigate = useNavigate();

    

    return (
        <div>Sidebar</div>
    )
}

export default Sidebar