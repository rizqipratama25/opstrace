import { useState, type FormEvent } from "react"
import Navbar from "../components/Navbar"
import Modal from "../components/Modal"
import { useLogin } from "../hooks/auth/useLogin"
import toast from "react-hot-toast"
import { useNavigate } from "react-router-dom"

const Homepage = () => {
    const navigate = useNavigate()
    const [showAuthModal, setShowAuthModal] = useState(false)

    // Login
    const {mutate: login, isPending} = useLogin();

    const [form, setForm] = useState({
        email: "",
        password: ""
    });

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault();

        login(
            {
                email: form.email,
                password: form.password
            },
            {
                onSuccess: () => {
                    toast.success("Login Successful");
                    navigate('/monitored-products')
                },
                onError: () => {
                    const message = "Invalid Credentials";
                    toast.error(message);
                }
            }
        )
    }

    return (
        <>
            <div className="bg-background-primary">
                <Navbar />

                <div className="min-h-screen w-full max-w-7xl mx-auto flex flex-col justify-center items-center gap-12">
                    <div className="flex flex-col justify-center items-center">
                        <div className="text-7xl font-bold text-primary">Monitor Smarter</div>
                        <div className="text-7xl font-bold text-secondary">Respond Faster</div>
                    </div>
                    <button onClick={() => setShowAuthModal((prev) => !prev)} className="bg-primary hover:bg-primary/90 text-white px-12 py-2 rounded-3xl cursor-pointer">Get Started</button>
                </div>


            </div>

            {showAuthModal && (
                <Modal setShowAuthModal={setShowAuthModal} modalTitle="Log In">
                    <form onSubmit={handleSubmit} className="space-y-4 text-secondary">
                        <input
                            type="email"
                            placeholder="Email"
                            className="w-full bg-background-primary border border-secondary/50 focus:border-primary/70 focus:ring-1 focus:ring-primary/70 outline-none rounded-lg p-2 transition-all duration-300"
                            value={form.email}
                            onChange={(e) => 
                                setForm((prev) => ({...prev, email: e.target.value}))
                            }
                            required
                        />

                        <input
                            type="password"
                            placeholder="Password"
                            className="w-full bg-background-primary border border-secondary/50 focus:border-primary/70 focus:ring-1 focus:ring-primary/70 outline-none rounded-lg p-2 transition-all duration-300"
                            value={form.password}
                            onChange={(e) => 
                                setForm((prev) => ({...prev, password: e.target.value}))
                            }
                            required
                        />

                        <button
                            type="submit"
                            disabled={isPending}
                            className="w-full bg-primary hover:bg-primary/90 disabled:bg-primary/60 text-white py-2 rounded-lg font-medium  cursor-pointer"
                        >
                            {isPending ? "Logging In..." : "Log In"}
                        </button>
                    </form>
                </Modal>
            )}
        </>
    )
}

export default Homepage