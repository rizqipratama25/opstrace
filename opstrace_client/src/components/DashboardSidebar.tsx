import { LogOut, Menu, X, type LucideIcon } from "lucide-react";
import { useState } from "react";
import { useLogout } from "../hooks/auth/useLogout";
import { NavLink, useNavigate } from "react-router-dom";
import { buildHandleLogout } from "../handlers/auth/logout.handler";

interface MenuItem {
    label: string;
    to: string;
    icon: LucideIcon;
}

interface Props {
    menuItems: MenuItem[];
}


const DashboardSidebar = ({ menuItems }: Props) => {
    const [sidebarOpen, setSidebarOpen] = useState(false);

    const { mutate: logout, isPending: isLogoutPending } = useLogout();
    const navigate = useNavigate();

    const handleLogout = buildHandleLogout(logout, navigate);

    return (
        <div className={`${sidebarOpen ? "w-64" : "w-20"} bg-white border-r border-border-primary transition-all duration-300 flex flex-col`}>
            <div className="p-4.5 border-b border-border-primary flex items-center justify-between">
                {sidebarOpen && <h1 className="text-xl text-primary font-bold">Ops<span className="text-secondary">Trace</span></h1>}
                <button onClick={() => setSidebarOpen(!sidebarOpen)} className="p-2 text-secondary hover:text-secondary/90">
                    {sidebarOpen ? <X size={20} /> : <Menu size={20} />}
                </button>
            </div>

            <nav className="flex-1 p-4 space-y-2">
                {menuItems.map((item) => (
                    <NavLink
                        key={item.label}
                        to={item.to}
                        className={({isActive}) => `w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-colors ${isActive
                            ? 'bg-primary text-white'
                            : 'text-secondary hover:bg-primary/10 hover:text-white'
                        }`}
                    >
                        <item.icon size={20} />
                        {sidebarOpen && <span>{item.label}</span>}
                    </NavLink>
                ))}
            </nav>

            <div className="py-4 px-4">
                <button
                    onClick={handleLogout}
                    disabled={isLogoutPending}
                    className="w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-50 text-red-600 transition-colors"
                >
                    <LogOut size={20} />
                    {sidebarOpen && <span>{isLogoutPending ? "Logging out..." : "Log Out"}</span>}
                </button>
            </div>
        </div>
    )
}

export default DashboardSidebar