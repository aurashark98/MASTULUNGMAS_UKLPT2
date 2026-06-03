import { motion } from "motion/react";
import { Menu, X } from "lucide-react";
import { useState } from "react";
import { Link, useLocation } from "react-router";
import { ThemeToggle } from "./ThemeToggle";

export function Navbar() {
  const [isOpen, setIsOpen] = useState(false);
  const location = useLocation();

  const navItems = [
    { name: "Home", path: "/" },
    { name: "Layanan", path: "/layanan" },
    { name: "Cara Kerja", path: "/cara-kerja" },
    { name: "Tentang Kami", path: "/tentang" },
    { name: "Kontak", path: "/kontak" },
  ];

  const isActive = (path: string) => location.pathname === path;

  return (
    <>
      {/* Desktop Floating Capsule Navbar */}
      <motion.nav
        initial={{ y: -100, opacity: 0 }}
        animate={{ y: 0, opacity: 1 }}
        className="fixed top-4 left-1/2 -translate-x-1/2 z-40 hidden md:block"
      >
        <div className="bg-white/80 dark:bg-[#1E1E1E]/80 backdrop-blur-xl border border-gray-200/50 dark:border-gray-700/50 rounded-full px-6 py-3 shadow-lg shadow-black/5">
          <div className="flex items-center gap-8">
            {/* Logo */}
            <Link to="/" className="flex items-center gap-2 pr-4 border-r border-gray-200 dark:border-gray-700">
              <div className="w-8 h-8 bg-gradient-to-br from-[#D32F2F] to-[#8B5A2B] rounded-full flex items-center justify-center">
                <span className="text-white font-bold text-sm">M</span>
              </div>
              <span className="font-bold text-[#D32F2F] dark:text-[#EF5350] font-poppins">MTM</span>
            </Link>

            {/* Nav Items */}
            <div className="flex items-center gap-6">
              {navItems.map((item) => (
                <Link
                  key={item.path}
                  to={item.path}
                  className={`text-sm font-medium transition-colors hover:text-[#D32F2F] dark:hover:text-[#EF5350] relative ${
                    isActive(item.path)
                      ? "text-[#D32F2F] dark:text-[#EF5350]"
                      : "text-gray-700 dark:text-gray-300"
                  }`}
                >
                  {item.name}
                  {isActive(item.path) && (
                    <motion.div
                      layoutId="activeNav"
                      className="absolute -bottom-1 left-0 right-0 h-0.5 bg-[#D32F2F] dark:bg-[#EF5350]"
                    />
                  )}
                </Link>
              ))}
            </div>

            {/* Actions */}
            <div className="flex items-center gap-3 pl-4 border-l border-gray-200 dark:border-gray-700">
              <ThemeToggle />
              <Link
                to="/login"
                className="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-[#D32F2F] dark:hover:text-[#EF5350] transition-colors"
              >
                Login
              </Link>
              <Link
                to="/register"
                className="px-5 py-2 bg-gradient-to-r from-[#D32F2F] to-[#B71C1C] text-white rounded-full text-sm font-medium hover:shadow-lg hover:shadow-[#D32F2F]/30 transition-all duration-300 hover:scale-105"
              >
                Daftar
              </Link>
            </div>
          </div>
        </div>
      </motion.nav>

      {/* Mobile Navbar */}
      <motion.nav
        initial={{ y: -100, opacity: 0 }}
        animate={{ y: 0, opacity: 1 }}
        className="fixed top-0 left-0 right-0 z-40 md:hidden bg-white/90 dark:bg-[#1E1E1E]/90 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-700/50"
      >
        <div className="flex items-center justify-between px-4 py-3">
          {/* Logo */}
          <Link to="/" className="flex items-center gap-2">
            <div className="w-8 h-8 bg-gradient-to-br from-[#D32F2F] to-[#8B5A2B] rounded-full flex items-center justify-center">
              <span className="text-white font-bold text-sm">M</span>
            </div>
            <span className="font-bold text-[#D32F2F] dark:text-[#EF5350] font-poppins">MTM</span>
          </Link>

          {/* Actions */}
          <div className="flex items-center gap-2">
            <ThemeToggle />
            <button
              onClick={() => setIsOpen(!isOpen)}
              className="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
            >
              {isOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
            </button>
          </div>
        </div>

        {/* Mobile Menu */}
        <motion.div
          initial={false}
          animate={{ height: isOpen ? "auto" : 0 }}
          className="overflow-hidden bg-white dark:bg-[#1E1E1E] border-t border-gray-200 dark:border-gray-700"
        >
          <div className="p-4 space-y-2">
            {navItems.map((item) => (
              <Link
                key={item.path}
                to={item.path}
                onClick={() => setIsOpen(false)}
                className={`block px-4 py-3 rounded-lg font-medium transition-colors ${
                  isActive(item.path)
                    ? "bg-[#D32F2F]/10 text-[#D32F2F] dark:bg-[#EF5350]/10 dark:text-[#EF5350]"
                    : "text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800"
                }`}
              >
                {item.name}
              </Link>
            ))}
            <div className="pt-2 space-y-2">
              <Link
                to="/login"
                onClick={() => setIsOpen(false)}
                className="block px-4 py-3 rounded-lg font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-center"
              >
                Login
              </Link>
              <Link
                to="/register"
                onClick={() => setIsOpen(false)}
                className="block px-4 py-3 rounded-lg font-medium bg-gradient-to-r from-[#D32F2F] to-[#B71C1C] text-white hover:shadow-lg transition-all text-center"
              >
                Daftar
              </Link>
            </div>
          </div>
        </motion.div>
      </motion.nav>
    </>
  );
}
