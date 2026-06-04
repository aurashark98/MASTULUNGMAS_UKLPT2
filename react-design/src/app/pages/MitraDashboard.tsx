import React from "react";
import { motion } from "framer-motion";
import {
  Bell,
  Briefcase,
  CheckCircle,
  Clock,
  DollarSign,
  MapPin,
  Star,
  TrendingUp,
} from "lucide-react";
import { Link } from "react-router-dom";

export function MitraDashboard() {
  return (
    <div className="min-h-screen bg-white dark:bg-[#121212] pt-24 pb-12">
      <div className="container mx-auto px-4">
        {/* Header */}
        <div className="flex items-center justify-between mb-8">
          <div>
            <h1 className="text-3xl font-black text-[#111827] dark:text-white mb-2 font-poppins tracking-tight leading-snug py-1">
              Dashboard Mitra
            </h1>
            <p className="text-[#374151] dark:text-gray-300 font-bold">
              Selamat datang kembali, Ahmad Fauzi
            </p>
          </div>
          <div className="flex items-center gap-3">
            <button className="p-3 bg-white dark:bg-[#1E1E1E] rounded-xl border border-[#E5E7EB] dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-[#252525] transition-colors relative">
              <Bell className="w-5 h-5 text-[#111827] dark:text-gray-300" />
              <span className="absolute top-2 right-2 w-2 h-2 bg-[#EF4444] rounded-full" />
            </button>
            <Link
              to="/mitra-profile"
              className="flex items-center gap-3 px-4 py-3 bg-white dark:bg-[#1E1E1E] rounded-xl border border-[#E5E7EB] dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-[#252525] transition-colors shadow-sm"
            >
              <div className="w-8 h-8 bg-gradient-to-br from-[#EF4444] to-[#F59E0B] rounded-full flex items-center justify-center">
                <span className="text-white text-sm font-black">AF</span>
              </div>
              <span className="font-black text-[#111827] dark:text-white uppercase tracking-wider text-sm">Profil</span>
            </Link>
          </div>
        </div>

        {/* Stats Cards */}
        <div className="grid md:grid-cols-4 gap-6 mb-8">
          <StatCard
            icon={DollarSign}
            label="Pendapatan Bulan Ini"
            value="Rp 4.5jt"
            change="+15%"
            color="green"
          />
          <StatCard
            icon={Briefcase}
            label="Tugas Tersedia"
            value="12"
            change="+3"
            color="blue"
          />
          <StatCard
            icon={CheckCircle}
            label="Selesai"
            value="45"
            change="+8"
            color="purple"
          />
          <StatCard
            icon={Star}
            label="Rating"
            value="4.9"
            change="+0.1"
            color="yellow"
          />
        </div>

        <div className="grid lg:grid-cols-3 gap-6">
          {/* Main Content */}
          <div className="lg:col-span-2 space-y-6">
            {/* Available Tasks */}
            <div className="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-[#E5E7EB] dark:border-gray-700 p-6 shadow-sm">
              <div className="flex items-center justify-between mb-6">
                <h2 className="text-xl font-black text-[#111827] dark:text-white">
                  Tugas Tersedia
                </h2>
                <button className="px-4 py-2 bg-gray-50 dark:bg-[#252525] text-[#374151] dark:text-gray-300 rounded-lg text-sm font-black hover:bg-gray-100 dark:hover:bg-[#2A2A2A] transition-colors border border-[#E5E7EB] dark:border-gray-700">
                  Filter
                </button>
              </div>
              <div className="space-y-4">
                <AvailableTaskCard
                  title="Antar Dokumen ke Kantor"
                  location="Surabaya Pusat"
                  distance="2.5 km"
                  fee="Rp 50.000"
                  time="2 jam lagi"
                  category="Kurir"
                />
                <AvailableTaskCard
                  title="Belanja Bulanan di Supermarket"
                  location="Tunjungan Plaza"
                  distance="3.8 km"
                  fee="Rp 100.000"
                  time="4 jam lagi"
                  category="Asisten"
                />
                <AvailableTaskCard
                  title="Antre Perpanjangan SIM"
                  location="Samsat Surabaya"
                  distance="5.2 km"
                  fee="Rp 150.000"
                  time="1 hari lagi"
                  category="Antre"
                />
              </div>
            </div>

            {/* Active Tasks */}
            <div className="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-[#E5E7EB] dark:border-gray-700 p-6 shadow-sm">
              <h2 className="text-xl font-black text-[#111827] dark:text-white mb-6">
                Tugas Dikerjakan
              </h2>
              <div className="space-y-4">
                <ActiveTaskCard
                  title="Pengiriman Paket ke Gubeng"
                  customer="Budi Santoso"
                  status="Dalam Perjalanan"
                  time="1 jam lagi"
                  fee="Rp 75.000"
                />
                <ActiveTaskCard
                  title="Pendampingan ke Rumah Sakit"
                  customer="Siti Nurhaliza"
                  status="Sedang Berlangsung"
                  time="3 jam lagi"
                  fee="Rp 200.000"
                />
              </div>
            </div>
          </div>

          {/* Sidebar */}
          <div className="space-y-6">
            {/* Earnings Summary */}
            <div className="bg-gradient-to-br from-[#EF4444] to-[#F59E0B] rounded-2xl p-6 text-white shadow-lg shadow-[#EF4444]/20">
              <h3 className="text-lg font-black mb-4">Total Pendapatan</h3>
              <div className="text-4xl font-black mb-2 tracking-tighter">Rp 4.5jt</div>
              <div className="flex items-center gap-1 text-white font-bold text-sm mb-6">
                <TrendingUp className="w-4 h-4" />
                <span>+15% dari bulan lalu</span>
              </div>
              <motion.button
                whileHover={{ scale: 1.05 }}
                whileTap={{ scale: 0.95 }}
                className="w-full py-4 bg-white text-[#DC2626] rounded-xl font-black hover:shadow-xl transition-all"
              >
                Tarik Saldo
              </motion.button>
            </div>

            {/* Performance */}
            <div className="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-[#E5E7EB] dark:border-gray-700 p-6 shadow-sm">
              <h3 className="text-lg font-black text-[#111827] dark:text-white mb-4">
                Performa Bulan Ini
              </h3>
              <div className="space-y-4">
                <div>
                  <div className="flex items-center justify-between text-sm mb-2 font-bold">
                    <span className="text-[#374151] dark:text-gray-400">Tingkat Selesai</span>
                    <span className="font-black text-[#111827] dark:text-white">96%</span>
                  </div>
                  <div className="w-full h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div className="h-full bg-gradient-to-r from-green-500 to-green-600" style={{ width: "96%" }} />
                  </div>
                </div>
                <div>
                  <div className="flex items-center justify-between text-sm mb-2 font-bold">
                    <span className="text-[#374151] dark:text-gray-400">Respon Cepat</span>
                    <span className="font-black text-[#111827] dark:text-white">92%</span>
                  </div>
                  <div className="w-full h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div className="h-full bg-gradient-to-r from-blue-500 to-blue-600" style={{ width: "92%" }} />
                  </div>
                </div>
                <div>
                  <div className="flex items-center justify-between text-sm mb-2 font-bold">
                    <span className="text-[#374151] dark:text-gray-400">Rating Pelanggan</span>
                    <span className="font-black text-[#111827] dark:text-white">4.9/5.0</span>
                  </div>
                  <div className="flex gap-1">
                    {[1, 2, 3, 4, 5].map((i) => (
                      <Star
                        key={i}
                        className={`w-5 h-5 ${
                          i < 5
                            ? "text-yellow-500 fill-yellow-500"
                            : "text-gray-200 dark:text-gray-600"
                        }`}
                      />
                    ))}
                  </div>
                </div>
              </div>
            </div>

            {/* Recent Reviews */}
            <div className="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-[#E5E7EB] dark:border-gray-700 p-6 shadow-sm">
              <h3 className="text-lg font-black text-[#111827] dark:text-white mb-4">
                Ulasan Terbaru
              </h3>
              <div className="space-y-4">
                <div className="pb-4 border-b border-gray-100 dark:border-gray-800 last:border-0 last:pb-0">
                  <div className="flex gap-1 mb-2">
                    {[1, 2, 3, 4, 5].map((i) => (
                      <Star key={i} className="w-4 h-4 text-yellow-500 fill-yellow-500" />
                    ))}
                  </div>
                  <p className="text-sm text-[#374151] dark:text-gray-300 mb-2 font-bold">
                    "Sangat profesional dan tepat waktu!"
                  </p>
                  <p className="text-xs text-[#6B7280] dark:text-gray-400 font-bold">
                    Budi Santoso • 2 hari lalu
                  </p>
                </div>
                <div className="pb-4 border-b border-gray-100 dark:border-gray-800 last:border-0 last:pb-0">
                  <div className="flex gap-1 mb-2">
                    {[1, 2, 3, 4, 5].map((i) => (
                      <Star key={i} className="w-4 h-4 text-yellow-500 fill-yellow-500" />
                    ))}
                  </div>
                  <p className="text-sm text-[#374151] dark:text-gray-300 mb-2 font-bold">
                    "Ramah dan membantu sekali"
                  </p>
                  <p className="text-xs text-[#6B7280] dark:text-gray-400 font-bold">
                    Siti Nurhaliza • 5 hari lalu
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

function StatCard({ icon: Icon, label, value, change, color }: { icon: any, label: string, value: string, change: string, color: 'green' | 'blue' | 'purple' | 'yellow' }) {
  const colorClasses = {
    green: "from-green-500 to-green-600",
    blue: "from-blue-500 to-blue-600",
    purple: "from-purple-500 to-purple-600",
    yellow: "from-yellow-500 to-yellow-600",
  };

  return (
    <motion.div
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      className="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-gray-200 dark:border-gray-700 p-6"
    >
      <div className="flex items-center justify-between mb-4">
        <div className={`w-12 h-12 bg-gradient-to-br ${colorClasses[color]} rounded-xl flex items-center justify-center`}>
          <Icon className="w-6 h-6 text-white" />
        </div>
        <div className="px-2 py-1 bg-green-100 dark:bg-green-950/30 text-green-600 dark:text-green-400 text-xs font-semibold rounded-full">
          {change}
        </div>
      </div>
      <div className="text-2xl font-black text-[#111827] dark:text-white mb-1">
        {value}
      </div>
      <div className="text-sm text-[#374151] dark:text-gray-400 font-bold">{label}</div>
    </motion.div>
  );
}

function AvailableTaskCard({ title, location, distance, fee, time, category }: any) {
  return (
    <div className="p-4 bg-gray-50 dark:bg-[#252525] rounded-xl hover:bg-gray-100 dark:hover:bg-[#2A2A2A] transition-colors border border-[#E5E7EB] dark:border-gray-700">
      <div className="flex items-start justify-between mb-3">
        <div>
          <span className="inline-block px-2 py-1 bg-[#EF4444]/10 text-[#DC2626] text-[10px] font-black rounded mb-2 uppercase tracking-wider">
            {category}
          </span>
          <h4 className="font-black text-[#111827] dark:text-white mb-1">
            {title}
          </h4>
          <div className="flex items-center gap-2 text-xs text-[#6B7280] dark:text-gray-400 font-bold">
            <MapPin className="w-3 h-3" />
            <span>{location} • {distance}</span>
          </div>
        </div>
        <div className="text-right">
          <div className="font-black text-[#DC2626] dark:text-[#EF5350]">
            {fee}
          </div>
          <span className="text-xs text-[#6B7280] dark:text-gray-400 font-bold">{time}</span>
        </div>
      </div>
      <div className="flex items-center gap-4 text-sm text-[#374151] dark:text-gray-400 font-bold">
        <motion.button
          whileHover={{ scale: 1.05 }}
          whileTap={{ scale: 0.95 }}
          className="flex-1 py-2 bg-[#EF4444] text-white rounded-lg font-black"
        >
          Ambil Tugas
        </motion.button>
        <button className="px-4 py-2 border border-[#E5E7EB] dark:border-gray-700 rounded-lg font-black hover:bg-white dark:hover:bg-[#2A2A2A]">
          Detail
        </button>
      </div>
    </div>
  );
}

function ActiveTaskCard({ title, customer, status, time, fee }: any) {
  return (
    <div className="p-4 bg-white dark:bg-[#252525] rounded-xl border border-[#E5E7EB] dark:border-gray-700">
      <div className="flex items-start justify-between mb-4">
        <div>
          <h4 className="font-black text-[#111827] dark:text-white mb-1">
            {title}
          </h4>
          <p className="text-sm text-[#374151] dark:text-gray-400 font-bold mb-2">
            Pelanggan: {customer}
          </p>
          <div className="flex items-center gap-3">
            <span className="px-2 py-1 bg-blue-100 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 text-xs font-black rounded">
              {status}
            </span>
            <span className="text-xs text-[#6B7280] dark:text-gray-400 flex items-center gap-1 font-bold">
              <Clock className="w-3 h-3" />
              {time}
            </span>
          </div>
        </div>
        <div className="text-right">
          <div className="text-xs text-[#6B7280] dark:text-gray-400 font-bold mb-1">Potensi</div>
          <div className="font-black text-[#DC2626] dark:text-[#EF5350]">{fee}</div>
        </div>
      </div>
      <div className="flex gap-2">
        <button className="flex-1 py-2 bg-gradient-to-r from-[#EF4444] to-[#DC2626] text-white rounded-lg text-sm font-black shadow-md">
          Update Status
        </button>
        <button className="px-4 py-2 bg-gray-50 dark:bg-[#1E1E1E] border border-[#E5E7EB] dark:border-gray-700 text-[#374151] dark:text-gray-300 rounded-lg text-sm font-black hover:bg-gray-100 dark:hover:bg-[#252525] transition-all">
          Chat
        </button>
      </div>
    </div>
  );
}
