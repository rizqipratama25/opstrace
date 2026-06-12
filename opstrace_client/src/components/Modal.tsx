import { X } from "lucide-react"
import type { Dispatch, ReactNode, SetStateAction } from "react"

const Modal = ({ setShowAuthModal, modalTitle, children }: { setShowAuthModal: Dispatch<SetStateAction<boolean>>, modalTitle: string, children?: ReactNode }) => {
    return (
        <div className="fixed inset-0 bg-black/20 backdrop-blur-sm flex items-center justify-center z-50">
            <div className="bg-white rounded-lg shadow-xl max-w-xl w-full p-6">
                <div className="flex justify-between items-center mb-6">
                    <h2 className="text-lg font-bold text-secondary">{modalTitle}</h2>
                    <button
                        onClick={() => setShowAuthModal(false)}
                        className="p-2 rounded text-secondary hover:text-secondary/50 cursor-pointer"
                    >
                        <X />
                    </button>

                    {children}
                </div>
            </div>
        </div>
    )
}

export default Modal