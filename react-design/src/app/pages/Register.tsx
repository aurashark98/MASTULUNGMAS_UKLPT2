import React from "react";
import { motion } from "framer-motion";
import { Mail, Lock, User, Phone, Eye, EyeOff } from "lucide-react";
import { useState } from "react";
import { Link } from "react-router-dom";

export function Register() {
  const [showPassword, setShowPassword] = useState(false);
  const [showConfirmPassword, setShowConfirmPassword] = useState(false);

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
            Buat Akun Baru
          </h1>
          <p className="text-[#374151] dark:text-gray-300 font-bold">
            Bergabung dengan ribuan pengguna MTM
          </p>
        </div>

        {/* Register Form */}
        <div className="bg-white dark:bg-[#1E1E1E] rounded-2xl shadow-xl border border-[#E5E7EB] dark:border-gray-800 p-8">
          <form className="space-y-5">
            {/* Name */}
            <div>
              <label className="block text-sm font-black text-[#111827] dark:text-gray-300 mb-2 uppercase tracking-wider">
                Nama Lengkap
              </label>
              <div className="relative">
                <User className="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-[#6B7280]" />
                <input
                  type="text"
                  placeholder="Nama Anda"
                  className="w-full pl-11 pr-4 py-3 bg-white dark:bg-[#252525] border border-[#E5E7EB] dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#EF4444] dark:focus:ring-[#EF5350] focus:border-transparent transition-all font-bold"
                />
              </div>
            </div>

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

            {/* Phone */}
            <div>
              <label className="block text-sm font-black text-[#111827] dark:text-gray-300 mb-2 uppercase tracking-wider">
                Nomor Telepon
              </label>
              <div className="relative">
                <Phone className="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-[#6B7280]" />
                <input
                  type="tel"
                  placeholder="08xxxxxxxxxx"
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

            {/* Confirm Password */}
            <div>
              <label className="block text-sm font-black text-[#111827] dark:text-gray-300 mb-2 uppercase tracking-wider">
                Konfirmasi Password
              </label>
              <div className="relative">
                <Lock className="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-[#6B7280]" />
                <input
                  type={showConfirmPassword ? "text" : "password"}
                  placeholder="••••••••"
                  className="w-full pl-11 pr-12 py-3 bg-white dark:bg-[#252525] border border-[#E5E7EB] dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#EF4444] dark:focus:ring-[#EF5350] focus:border-transparent transition-all font-bold"
                />
                <button
                  type="button"
                  onClick={() => setShowConfirmPassword(!showConfirmPassword)}
                  className="absolute right-3 top-1/2 -translate-y-1/2 text-[#6B7280] hover:text-[#111827] dark:hover:text-gray-300"
                >
                  {showConfirmPassword ? <EyeOff className="w-5 h-5" /> : <Eye className="w-5 h-5" />}
                </button>
              </div>
            </div>

            {/* Terms */}
            <div className="flex items-start">
              <input
                type="checkbox"
                className="mt-1 w-4 h-4 text-[#EF4444] border-[#E5E7EB] rounded focus:ring-[#EF4444]"
              />
              <label className="ml-2 text-sm text-[#374151] dark:text-gray-300 font-bold">
                Saya setuju dengan{" "}
                <a href="#" className="text-[#DC2626] dark:text-[#EF5350] font-black hover:underline">
                  Syarat & Ketentuan
                </a>{" "}
                dan{" "}
                <a href="#" className="text-[#DC2626] dark:text-[#EF5350] hover:underline">
                  Kebijakan Privasi
                </a>
              </label>
            </div>

            {/* Submit Button */}
            <motion.button
              whileHover={{ scale: 1.02 }}
              whileTap={{ scale: 0.98 }}
              type="submit"
              className="w-full py-4 bg-gradient-to-r from-[#EF4444] to-[#F59E0B] text-white rounded-xl font-black shadow-lg shadow-[#EF4444]/30 hover:shadow-xl hover:shadow-[#EF4444]/40 transition-all"
            >
              Daftar Sekarang
            </motion.button>
          </form>

          {/* Login Link */}
          <div className="mt-8 text-center">
            <p className="text-[#374151] dark:text-gray-300 font-bold">
              Sudah punya akun?{" "}
              <Link
                to="/login"
                className="text-[#DC2626] dark:text-[#EF5350] font-black hover:underline"
              >
                Masuk di sini
              </Link>
            </p>
          </div>
        </div>

        {/* Mitra Register */}
        <div className="mt-8 text-center">
          <p className="text-sm text-[#6B7280] dark:text-gray-400 font-bold">
            Ingin bergabung sebagai mitra?{" "}
            <Link
              to="/mitra-register"
              className="text-[#EA580C] dark:text-[#A67C52] font-black hover:underline"
            >
              Daftar Mitra
            </Link>
          </p>
        </div>
      </motion.div>
    </div>
  );
}
