import { motion } from "motion/react";
import {
  Bell,
  CheckCircle,
  Clock,
  DollarSign,
  Package,
  Settings,
  Star,
  TrendingUp,
  User,
} from "lucide-react";
import { Link } from "react-router";

export function UserDashboard() {
  return (
    <div className="min-h-screen bg-gray-50 dark:bg-[#121212] pt-24 pb-12">
      <div className="container mx-auto px-4">
        {/* Header */}
        <div className="flex items-center justify-between mb-8">
          <div>
            <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-2 font-poppins">
              Dashboard
            </h1>
            <p className="text-gray-600 dark:text-gray-300">
              Selamat datang kembali, Budi Santoso
            </p>
          </div>
          <div className="flex items-center gap-3">
            <button className="p-3 bg-white dark:bg-[#1E1E1E] rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-[#252525] transition-colors relative">
              <Bell className="w-5 h-5 text-gray-700 dark:text-gray-300" />
              <span className="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full" />
            </button>
            <Link
              to="/profile"
              className="flex items-center gap-3 px-4 py-3 bg-white dark:bg-[#1E1E1E] rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-[#252525] transition-colors"
            >
              <div className="w-8 h-8 bg-gradient-to-br from-[#D32F2F] to-[#8B5A2B] rounded-full flex items-center justify-center">
                <span className="text-white text-sm font-bold">BS</span>
              </div>
              <span className="font-medium text-gray-900 dark:text-white">Profil</span>
            </Link>
          </div>
        </div>

        {/* Stats Cards */}
        <div className="grid md:grid-cols-4 gap-6 mb-8">
          <StatCard
            icon={Package}
            label="Total Tugas"
            value="24"
            change="+3"
            color="blue"
          />
          <StatCard
            icon={Clock}
            label="Tugas Aktif"
            value="3"
            change="+1"
            color="orange"
          />
          <StatCard
            icon={CheckCircle}
            label="Selesai"
            value="21"
            change="+2"
            color="green"
          />
          <StatCard
            icon={Star}
            label="Rating"
            value="4.8"
            change="+0.2"
            color="yellow"
          />
        </div>

        <div className="grid lg:grid-cols-3 gap-6">
          {/* Main Content */}
          <div className="lg:col-span-2 space-y-6">
            {/* Active Tasks */}
            <div className="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
              <div className="flex items-center justify-between mb-6">
                <h2 className="text-xl font-bold text-gray-900 dark:text-white">
                  Tugas Aktif
                </h2>
                <Link
                  to="/tasks"
                  className="text-sm text-[#D32F2F] dark:text-[#EF5350] font-medium hover:underline"
                >
                  Lihat Semua
                </Link>
              </div>
              <div className="space-y-4">
                <TaskCard
                  title="Pengiriman Paket ke Surabaya"
                  mitra="Ahmad Fauzi"
                  status="Dalam Perjalanan"
                  statusColor="blue"
                  time="2 jam lagi"
                />
                <TaskCard
                  title="Antre SIM di Samsat"
                  mitra="Siti Rahmawati"
                  status="Sedang Antre"
                  statusColor="orange"
                  time="1 hari lagi"
                />
                <TaskCard
                  title="Belanja Bulanan"
                  mitra="Eko Prasetyo"
                  status="Menunggu Konfirmasi"
                  statusColor="yellow"
                  time="3 jam lagi"
                />
              </div>
            </div>

            {/* Recent History */}
            <div className="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
              <h2 className="text-xl font-bold text-gray-900 dark:text-white mb-6">
                Riwayat Terakhir
              </h2>
              <div className="space-y-4">
                <HistoryCard
                  title="Perbaikan AC Rumah"
                  mitra="Joko Susanto"
                  date="3 hari yang lalu"
                  amount="Rp 250.000"
                  rating={5}
                />
                <HistoryCard
                  title="Antar Dokumen Kantor"
                  mitra="Dewi Lestari"
                  date="5 hari yang lalu"
                  amount="Rp 50.000"
                  rating={5}
                />
                <HistoryCard
                  title="Pendampingan Ibu ke Rumah Sakit"
                  mitra="Rina Wati"
                  date="1 minggu yang lalu"
                  amount="Rp 150.000"
                  rating={4}
                />
              </div>
            </div>
          </div>

          {/* Sidebar */}
          <div className="space-y-6">
            {/* Quick Actions */}
            <div className="bg-gradient-to-br from-[#D32F2F] to-[#8B5A2B] rounded-2xl p-6 text-white">
              <h3 className="text-lg font-bold mb-4">Perlu Bantuan?</h3>
              <p className="text-white/90 text-sm mb-6">
                Buat permintaan tugas baru dan dapatkan penawaran dari mitra terpercaya
              </p>
              <motion.button
                whileHover={{ scale: 1.05 }}
                whileTap={{ scale: 0.95 }}
                className="w-full py-3 bg-white text-[#D32F2F] rounded-xl font-semibold hover:shadow-lg transition-all"
              >
                Buat Tugas Baru
              </motion.button>
            </div>

            {/* Spending Summary */}
            <div className="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
              <h3 className="text-lg font-bold text-gray-900 dark:text-white mb-4">
                Pengeluaran Bulan Ini
              </h3>
              <div className="mb-4">
                <div className="text-3xl font-bold text-[#D32F2F] dark:text-[#EF5350] mb-1">
                  Rp 1.250.000
                </div>
                <div className="flex items-center gap-1 text-sm text-green-600 dark:text-green-400">
                  <TrendingUp className="w-4 h-4" />
                  <span>12% dari bulan lalu</span>
                </div>
              </div>
              <div className="space-y-3">
                <div className="flex items-center justify-between text-sm">
                  <span className="text-gray-600 dark:text-gray-400">Kurir</span>
                  <span className="font-semibold text-gray-900 dark:text-white">Rp 450.000</span>
                </div>
                <div className="flex items-center justify-between text-sm">
                  <span className="text-gray-600 dark:text-gray-400">Jasa Antre</span>
                  <span className="font-semibold text-gray-900 dark:text-white">Rp 300.000</span>
                </div>
                <div className="flex items-center justify-between text-sm">
                  <span className="text-gray-600 dark:text-gray-400">Asisten</span>
                  <span className="font-semibold text-gray-900 dark:text-white">Rp 500.000</span>
                </div>
              </div>
            </div>

            {/* Top Mitras */}
            <div className="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
              <h3 className="text-lg font-bold text-gray-900 dark:text-white mb-4">
                Mitra Favorit
              </h3>
              <div className="space-y-3">
                <div className="flex items-center gap-3">
                  <div className="w-10 h-10 bg-gradient-to-br from-[#D32F2F] to-[#8B5A2B] rounded-full flex items-center justify-center text-white font-bold text-sm">
                    AF
                  </div>
                  <div className="flex-1">
                    <div className="font-semibold text-gray-900 dark:text-white text-sm">
                      Ahmad Fauzi
                    </div>
                    <div className="flex items-center gap-1">
                      <Star className="w-3 h-3 text-yellow-500 fill-yellow-500" />
                      <span className="text-xs text-gray-600 dark:text-gray-400">4.9 (45)</span>
                    </div>
                  </div>
                </div>
                <div className="flex items-center gap-3">
                  <div className="w-10 h-10 bg-gradient-to-br from-[#D32F2F] to-[#8B5A2B] rounded-full flex items-center justify-center text-white font-bold text-sm">
                    SR
                  </div>
                  <div className="flex-1">
                    <div className="font-semibold text-gray-900 dark:text-white text-sm">
                      Siti Rahmawati
                    </div>
                    <div className="flex items-center gap-1">
                      <Star className="w-3 h-3 text-yellow-500 fill-yellow-500" />
                      <span className="text-xs text-gray-600 dark:text-gray-400">5.0 (32)</span>
                    </div>
                  </div>
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
    blue: "from-blue-500 to-blue-600",
    orange: "from-orange-500 to-orange-600",
    green: "from-green-500 to-green-600",
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

function TaskCard({ title, mitra, status, statusColor, time }: any) {
  const statusColors = {
    blue: "bg-blue-100 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400",
    orange: "bg-orange-100 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400",
    yellow: "bg-yellow-100 dark:bg-yellow-950/30 text-yellow-600 dark:text-yellow-400",
  };

  return (
    <div className="p-4 bg-gray-50 dark:bg-[#252525] rounded-xl hover:bg-gray-100 dark:hover:bg-[#2A2A2A] transition-colors">
      <div className="flex items-start justify-between mb-3">
        <div className="flex-1">
          <h4 className="font-semibold text-gray-900 dark:text-white mb-1">
            {title}
          </h4>
          <p className="text-sm text-gray-600 dark:text-gray-400">
            Mitra: {mitra}
          </p>
        </div>
        <span className={`px-3 py-1 rounded-full text-xs font-semibold ${statusColors[statusColor]}`}>
          {status}
        </span>
      </div>
      <div className="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
        <Clock className="w-4 h-4" />
        <span>{time}</span>
      </div>
    </div>
  );
}

function HistoryCard({ title, mitra, date, amount, rating }: any) {
  return (
    <div className="p-4 bg-gray-50 dark:bg-[#252525] rounded-xl">
      <div className="flex items-start justify-between mb-2">
        <div className="flex-1">
          <h4 className="font-semibold text-gray-900 dark:text-white mb-1">
            {title}
          </h4>
          <p className="text-sm text-gray-600 dark:text-gray-400">
            {mitra} • {date}
          </p>
        </div>
        <div className="text-right">
          <div className="font-semibold text-gray-900 dark:text-white mb-1">
            {amount}
          </div>
          <div className="flex items-center gap-1">
            <Star className="w-4 h-4 text-yellow-500 fill-yellow-500" />
            <span className="text-sm text-gray-600 dark:text-gray-400">{rating}</span>
          </div>
        </div>
      </div>
    </div>
  );
}
