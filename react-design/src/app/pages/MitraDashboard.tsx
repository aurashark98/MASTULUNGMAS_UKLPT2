import { motion } from "motion/react";
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
import { Link } from "react-router";

export function MitraDashboard() {
  return (
    <div className="min-h-screen bg-gray-50 dark:bg-[#121212] pt-24 pb-12">
      <div className="container mx-auto px-4">
        {/* Header */}
        <div className="flex items-center justify-between mb-8">
          <div>
            <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-2 font-poppins">
              Dashboard Mitra
            </h1>
            <p className="text-gray-600 dark:text-gray-300">
              Selamat datang kembali, Ahmad Fauzi
            </p>
          </div>
          <div className="flex items-center gap-3">
            <button className="p-3 bg-white dark:bg-[#1E1E1E] rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-[#252525] transition-colors relative">
              <Bell className="w-5 h-5 text-gray-700 dark:text-gray-300" />
              <span className="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full" />
            </button>
            <Link
              to="/mitra-profile"
              className="flex items-center gap-3 px-4 py-3 bg-white dark:bg-[#1E1E1E] rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-[#252525] transition-colors"
            >
              <div className="w-8 h-8 bg-gradient-to-br from-[#8B5A2B] to-[#D32F2F] rounded-full flex items-center justify-center">
                <span className="text-white text-sm font-bold">AF</span>
              </div>
              <span className="font-medium text-gray-900 dark:text-white">Profil</span>
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
            <div className="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
              <div className="flex items-center justify-between mb-6">
                <h2 className="text-xl font-bold text-gray-900 dark:text-white">
                  Tugas Tersedia
                </h2>
                <button className="px-4 py-2 bg-gray-100 dark:bg-[#252525] text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-200 dark:hover:bg-[#2A2A2A] transition-colors">
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
            <div className="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
              <h2 className="text-xl font-bold text-gray-900 dark:text-white mb-6">
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
            <div className="bg-gradient-to-br from-[#8B5A2B] to-[#D32F2F] rounded-2xl p-6 text-white">
              <h3 className="text-lg font-bold mb-4">Total Pendapatan</h3>
              <div className="text-4xl font-bold mb-2">Rp 4.5jt</div>
              <div className="flex items-center gap-1 text-white/90 text-sm mb-6">
                <TrendingUp className="w-4 h-4" />
                <span>+15% dari bulan lalu</span>
              </div>
              <motion.button
                whileHover={{ scale: 1.05 }}
                whileTap={{ scale: 0.95 }}
                className="w-full py-3 bg-white text-[#8B5A2B] rounded-xl font-semibold hover:shadow-lg transition-all"
              >
                Tarik Saldo
              </motion.button>
            </div>

            {/* Performance */}
            <div className="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
              <h3 className="text-lg font-bold text-gray-900 dark:text-white mb-4">
                Performa Bulan Ini
              </h3>
              <div className="space-y-4">
                <div>
                  <div className="flex items-center justify-between text-sm mb-2">
                    <span className="text-gray-600 dark:text-gray-400">Tingkat Selesai</span>
                    <span className="font-semibold text-gray-900 dark:text-white">96%</span>
                  </div>
                  <div className="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div className="h-full bg-gradient-to-r from-green-500 to-green-600" style={{ width: "96%" }} />
                  </div>
                </div>
                <div>
                  <div className="flex items-center justify-between text-sm mb-2">
                    <span className="text-gray-600 dark:text-gray-400">Respon Cepat</span>
                    <span className="font-semibold text-gray-900 dark:text-white">92%</span>
                  </div>
                  <div className="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div className="h-full bg-gradient-to-r from-blue-500 to-blue-600" style={{ width: "92%" }} />
                  </div>
                </div>
                <div>
                  <div className="flex items-center justify-between text-sm mb-2">
                    <span className="text-gray-600 dark:text-gray-400">Rating Pelanggan</span>
                    <span className="font-semibold text-gray-900 dark:text-white">4.9/5.0</span>
                  </div>
                  <div className="flex gap-1">
                    {[1, 2, 3, 4, 5].map((i) => (
                      <Star
                        key={i}
                        className={`w-5 h-5 ${
                          i < 5
                            ? "text-yellow-500 fill-yellow-500"
                            : "text-gray-300 dark:text-gray-600"
                        }`}
                      />
                    ))}
                  </div>
                </div>
              </div>
            </div>

            {/* Recent Reviews */}
            <div className="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
              <h3 className="text-lg font-bold text-gray-900 dark:text-white mb-4">
                Ulasan Terbaru
              </h3>
              <div className="space-y-4">
                <div className="pb-4 border-b border-gray-100 dark:border-gray-800 last:border-0 last:pb-0">
                  <div className="flex gap-1 mb-2">
                    {[1, 2, 3, 4, 5].map((i) => (
                      <Star key={i} className="w-4 h-4 text-yellow-500 fill-yellow-500" />
                    ))}
                  </div>
                  <p className="text-sm text-gray-700 dark:text-gray-300 mb-2">
                    "Sangat profesional dan tepat waktu!"
                  </p>
                  <p className="text-xs text-gray-500 dark:text-gray-400">
                    Budi Santoso • 2 hari lalu
                  </p>
                </div>
                <div className="pb-4 border-b border-gray-100 dark:border-gray-800 last:border-0 last:pb-0">
                  <div className="flex gap-1 mb-2">
                    {[1, 2, 3, 4, 5].map((i) => (
                      <Star key={i} className="w-4 h-4 text-yellow-500 fill-yellow-500" />
                    ))}
                  </div>
                  <p className="text-sm text-gray-700 dark:text-gray-300 mb-2">
                    "Ramah dan membantu sekali"
                  </p>
                  <p className="text-xs text-gray-500 dark:text-gray-400">
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

function StatCard({ icon: Icon, label, value, change, color }: any) {
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
      <div className="text-2xl font-bold text-gray-900 dark:text-white mb-1">
        {value}
      </div>
      <div className="text-sm text-gray-600 dark:text-gray-400">{label}</div>
    </motion.div>
  );
}

function AvailableTaskCard({ title, location, distance, fee, time, category }: any) {
  return (
    <div className="p-4 bg-gray-50 dark:bg-[#252525] rounded-xl hover:bg-gray-100 dark:hover:bg-[#2A2A2A] transition-colors">
      <div className="flex items-start justify-between mb-3">
        <div className="flex-1">
          <div className="flex items-center gap-2 mb-2">
            <span className="px-2 py-1 bg-[#D32F2F]/10 text-[#D32F2F] dark:bg-[#EF5350]/10 dark:text-[#EF5350] text-xs font-semibold rounded">
              {category}
            </span>
            <span className="text-xs text-gray-500 dark:text-gray-400">{time}</span>
          </div>
          <h4 className="font-semibold text-gray-900 dark:text-white mb-2">
            {title}
          </h4>
          <div className="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
            <div className="flex items-center gap-1">
              <MapPin className="w-4 h-4" />
              <span>{location}</span>
            </div>
            <span>• {distance}</span>
          </div>
        </div>
        <div className="text-right">
          <div className="text-lg font-bold text-[#8B5A2B] dark:text-[#A67C52] mb-2">
            {fee}
          </div>
          <motion.button
            whileHover={{ scale: 1.05 }}
            whileTap={{ scale: 0.95 }}
            className="px-4 py-2 bg-gradient-to-r from-[#D32F2F] to-[#8B5A2B] text-white rounded-lg text-sm font-semibold hover:shadow-lg transition-all"
          >
            Ambil
          </motion.button>
        </div>
      </div>
    </div>
  );
}

function ActiveTaskCard({ title, customer, status, time, fee }: any) {
  return (
    <div className="p-4 bg-blue-50 dark:bg-blue-950/10 rounded-xl border border-blue-200 dark:border-blue-900/30">
      <div className="flex items-start justify-between mb-3">
        <div className="flex-1">
          <h4 className="font-semibold text-gray-900 dark:text-white mb-1">
            {title}
          </h4>
          <p className="text-sm text-gray-600 dark:text-gray-400 mb-2">
            Pelanggan: {customer}
          </p>
          <div className="flex items-center gap-2">
            <span className="px-2 py-1 bg-blue-100 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 text-xs font-semibold rounded">
              {status}
            </span>
            <span className="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
              <Clock className="w-3 h-3" />
              {time}
            </span>
          </div>
        </div>
        <div className="text-right">
          <div className="font-bold text-gray-900 dark:text-white mb-2">
            {fee}
          </div>
          <motion.button
            whileHover={{ scale: 1.05 }}
            whileTap={{ scale: 0.95 }}
            className="px-4 py-2 bg-white dark:bg-[#1E1E1E] border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-semibold hover:bg-gray-50 dark:hover:bg-[#252525] transition-all"
          >
            Detail
          </motion.button>
        </div>
      </div>
    </div>
  );
}
