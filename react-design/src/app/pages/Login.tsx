import React from "react";
import { motion } from "framer-motion";
import { Mail, Lock, Eye, EyeOff } from "lucide-react";
import { useState } from "react";
import { Link } from "react-router-dom";

export function Login() {
  const [showPassword, setShowPassword] = useState(false);

  return (
    <div className="min-h-screen flex items-center justify-center bg-white dark:bg-[#121212] py-12 px-4">
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        className="w-full max-w-md"
      >
        {/* Logo */}
        <div className="text-center mb-8">
          <Link to="/" className="inline-flex items-center gap-3 mb-4">
            <div className="w-12 h-12 bg-gradient-to-br from-[#EF4444] to-[#F59E0B] rounded-full flex items-center justify-center">
              <span className="text-white font-black text-lg">M</span>
            </div>
            <span className="text-2xl font-black text-[#111827] dark:text-white font-poppins">
              Mas Tulung Mas
            </span>
          </Link>
          <h1 className="text-3xl font-black text-[#111827] dark:text-white mb-2 tracking-tight">
            Selamat Datang Kembali
          </h1>
          <p className="text-[#374151] dark:text-gray-300 font-bold">
            Masuk untuk melanjutkan
          </p>
        </div>

        {/* Login Form */}
        <div className="bg-white dark:bg-[#1E1E1E] rounded-2xl shadow-xl border border-[#E5E7EB] dark:border-gray-800 p-8">
          <form className="space-y-6">
            {/* Email */}
            <div>
              <label className="block text-sm font-black text-[#111827] dark:text-gray-300 mb-2 uppercase tracking-wider">
                Email
              </label>
              <div className="relative">
                <Mail className="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-[#6B7280]" />
                <input
                  type="email"
                  placeholder="nama@email.com"
                  className="w-full pl-11 pr-4 py-3 bg-white dark:bg-[#252525] border border-[#E5E7EB] dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#EF4444] dark:focus:ring-[#EF5350] focus:border-transparent transition-all font-bold"
                />
              </div>
            </div>

            {/* Password */}
            <div>
              <label className="block text-sm font-black text-[#111827] dark:text-gray-300 mb-2 uppercase tracking-wider">
                Password
              </label>
              <div className="relative">
                <Lock className="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-[#6B7280]" />
                <input
                  type={showPassword ? "text" : "password"}
                  placeholder="••••••••"
                  className="w-full pl-11 pr-12 py-3 bg-white dark:bg-[#252525] border border-[#E5E7EB] dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#EF4444] dark:focus:ring-[#EF5350] focus:border-transparent transition-all font-bold"
                />
                <button
                  type="button"
                  onClick={() => setShowPassword(!showPassword)}
                  className="absolute right-3 top-1/2 -translate-y-1/2 text-[#6B7280] hover:text-[#111827] dark:hover:text-gray-300"
                >
                  {showPassword ? <EyeOff className="w-5 h-5" /> : <Eye className="w-5 h-5" />}
                </button>
              </div>
            </div>

            {/* Remember & Forgot */}
            <div className="flex items-center justify-between">
              <label className="flex items-center">
                <input
                  type="checkbox"
                  className="w-4 h-4 text-[#EF4444] border-[#E5E7EB] rounded focus:ring-[#EF4444]"
                />
                <span className="ml-2 text-sm text-[#374151] dark:text-gray-300 font-bold">
                  Ingat saya
                </span>
              </label>
              <Link
                to="/forgot-password"
                className="text-sm text-[#DC2626] dark:text-[#EF5350] font-black hover:underline"
              >
                Lupa password?
              </Link>
            </div>

            {/* Submit Button */}
            <motion.button
              whileHover={{ scale: 1.02 }}
              whileTap={{ scale: 0.98 }}
              type="submit"
              className="w-full py-4 bg-gradient-to-r from-[#EF4444] to-[#F59E0B] text-white rounded-xl font-black shadow-lg shadow-[#EF4444]/30 hover:shadow-xl hover:shadow-[#EF4444]/40 transition-all"
            >
              Masuk
            </motion.button>

            {/* Divider */}
            <div className="relative">
              <div className="absolute inset-0 flex items-center">
                <div className="w-full border-t border-[#E5E7EB] dark:border-gray-700" />
              </div>
              <div className="relative flex justify-center text-sm">
                <span className="px-4 bg-white dark:bg-[#1E1E1E] text-[#6B7280] font-bold">
                  Atau masuk dengan
                </span>
              </div>
            </div>

            {/* Social Login */}
            <div className="w-full">
              <button
                type="button"
                className="w-full py-3 border border-[#E5E7EB] dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-[#252525] transition-colors flex items-center justify-center gap-2"
              >
                <svg className="w-5 h-5" viewBox="0 0 24 24">
                  <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                  <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                  <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                  <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span className="text-sm font-black text-[#111827] dark:text-gray-300">Google</span>
              </button>
            </div>
          </form>

          {/* Register Link */}
          <div className="mt-8 text-center">
            <p className="text-[#374151] dark:text-gray-300 font-bold">
              Belum punya akun?{" "}
              <Link
                to="/register"
                className="text-[#DC2626] dark:text-[#EF5350] font-black hover:underline"
              >
                Daftar sekarang
              </Link>
            </p>
          </div>
        </div>

        {/* Mitra Login */}
        <div className="mt-8 text-center">
          <p className="text-sm text-[#6B7280] dark:text-gray-400 font-bold">
            Ingin gabung sebagai mitra?{" "}
            <Link
              to="/mitra-login"
              className="text-[#EA580C] dark:text-[#A67C52] font-black hover:underline"
            >
              Login Mitra
            </Link>
          </p>
        </div>
      </motion.div>
    </div>
  );
}
