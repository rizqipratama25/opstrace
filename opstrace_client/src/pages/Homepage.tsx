import { useState } from "react"
import Navbar from "../components/Navbar"
import Modal from "../components/Modal"

const Homepage = () => {
    const [showAuthModal, setShowAuthModal] = useState(false)

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
                    <form className="space-y-4">
                        <input
                            type="text"
                            
                        />
                    </form>
                </Modal>
            )}
        </>
    )
}

export default Homepage