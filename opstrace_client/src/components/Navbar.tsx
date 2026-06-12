const Navbar = () => {
    return (
        <header className="fixed top-0 left-0 right-0 z-45 bg-white border-b border-border-primary">
            <nav className="w-full max-w-7xl mx-auto px-6 lg:px-6 md:px-12 sm:px-8  p-4 flex justify-between items-center">
                <div className="text-primary font-bold text-xl">Ops<span className="text-secondary">Trace</span></div>
                <div className="flex justify-between items-center">
                    <a href="" className="px-4 py-2 text-sm text-secondary hover:text-secondary/70">Log In</a>
                    <a href="" className="px-4 py-2 text-sm text-primary hover:text-primary/70">Sign Up</a>
                </div>
            </nav>
        </header>
    )
}

export default Navbar