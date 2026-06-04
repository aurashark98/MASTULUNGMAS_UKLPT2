import React from "react";
import { motion } from "framer-motion";
import { Menu, X } from "lucide-react";
import { useState } from "react";
import { Link, useLocation } from "react-router-dom";
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
        <div className="bg-white dark:bg-[#1E1E1E] border border-gray-200 dark:border-gray-700 rounded-full px-6 py-3 shadow-xl shadow-black/5">
          <div className="flex items-center gap-8">
            {/* Logo */}
            <Link to="/" className="flex items-center gap-2 pr-4 border-r border-gray-200 dark:border-gray-700">
              <div className="w-8 h-8 bg-gradient-to-br from-[#EF4444] to-[#F59E0B] rounded-full flex items-center justify-center">
                <span className="text-white font-bold text-sm">M</span>
              </div>
              <span className="font-bold text-gray-900 dark:text-white font-poppins">MTM</span>
            </Link>

            {/* Nav Items */}
            <div className="flex items-center gap-6">
              {navItems.map((item) => (
                <Link
                  key={item.path}
                  to={item.path}
                  className={`text-sm font-bold transition-all hover:text-red-600 relative inline-block ${
                    isActive(item.path)
                      ? "text-red-500 dark:text-red-400"
                      : "text-gray-900 dark:text-gray-300"
                  }`}
                >
                  {item.name}
                  {isActive(item.path) && (
                    <motion.div
                      layoutId="activeNav"
                      className="absolute -bottom-1 left-0 right-0 h-0.5 bg-red-500 dark:bg-red-400"
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
                className="text-sm font-bold text-gray-900 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 transition-colors"
              >
                Login
              </Link>
              <Link
                to="/register"
                className="px-6 py-2 bg-gradient-to-r from-[#EF4444] to-[#DC2626] text-white rounded-full text-sm font-bold shadow-md hover:shadow-lg hover:shadow-[#EF4444]/30 transition-all duration-300 hover:scale-105"
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
        className="fixed top-0 left-0 right-0 z-40 md:hidden bg-white dark:bg-[#121212] border-b border-gray-200 dark:border-gray-700"
      >
        <div className="flex items-center justify-between px-4 py-3">
          {/* Logo */}
          <Link to="/" className="flex items-center gap-2">
            <div className="w-8 h-8 bg-gradient-to-br from-[#EF4444] to-[#F59E0B] rounded-full flex items-center justify-center">
              <span className="text-white font-bold text-sm">M</span>
            </div>
            <span className="font-bold text-gray-900 dark:text-white font-poppins">MTM</span>
          </Link>

          {/* Actions */}
          <div className="flex items-center gap-2">
            <ThemeToggle />
            <button
              onClick={() => setIsOpen(!isOpen)}
              className="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
            >
              {isOpen ? <X className="w-6 h-6 text-gray-900 dark:text-white" /> : <Menu className="w-6 h-6 text-gray-900 dark:text-white" />}
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
                className={`block px-4 py-3 rounded-lg font-bold transition-all ${
                  isActive(item.path)
                    ? "bg-[#EF4444]/10 text-[#EF4444] dark:text-[#F59E0B]"
                    : "text-[#111827] dark:text-[#E5E7EB] hover:bg-gray-100 dark:hover:bg-gray-800"
                }`}
              >
                {item.name}
              </Link>
            ))}
            <div className="pt-2 space-y-2">
              <Link
                to="/login"
                onClick={() => setIsOpen(false)}
                className="block px-4 py-3 rounded-lg font-bold text-gray-900 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-center"
              >
                Login
              </Link>
              <Link
                to="/register"
                onClick={() => setIsOpen(false)}
                className="block px-4 py-3 rounded-lg font-bold bg-gradient-to-r from-[#EF4444] to-[#DC2626] text-white hover:shadow-lg transition-all text-center"
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
