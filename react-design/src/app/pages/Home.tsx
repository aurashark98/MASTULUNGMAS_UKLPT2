import React from "react";
import { motion, AnimatePresence } from "framer-motion";
import {
  ArrowRight,
  CheckCircle,
  Clock,
  Heart,
  MessageCircle,
  Package,
  Shield,
  Sparkles,
  Star,
  TrendingUp,
  Users,
  Zap,
} from "lucide-react";
import { useEffect, useRef, useState } from "react";

export function Home() {
  return (
    <div className="min-h-screen pt-20 md:pt-24">
      <HeroSection />
      <StatsSection />
      <ServicesSection />
      <HowItWorksSection />
      <WhyChooseSection />
      <CommunityImpactSection />
      <TestimonialsSection />
      <FAQSection />
      <CTASection />
      <Footer />
    </div>
  );
}

function HeroSection() {
  return (
    <section className="relative overflow-hidden bg-white dark:bg-[#121212] py-20 md:py-32">
      {/* Background Pattern */}
      <div className="absolute inset-0 opacity-[0.03]">
        <div className="absolute inset-0" style={{
          backgroundImage: `radial-gradient(circle at 1px 1px, #EF4444 1px, transparent 0)`,
          backgroundSize: '40px 40px'
        }} />
      </div>

      <div className="container mx-auto px-4 relative z-10">
        <div className="grid md:grid-cols-2 gap-12 items-center">
          {/* Left Content */}
          <motion.div
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
          >
            <motion.div
              animate={{ opacity: 1, scale: 1 }}
              transition={{ delay: 0.2 }}
              className="inline-flex items-center gap-2 px-4 py-2 bg-red-50 dark:bg-red-950/30 rounded-full mb-6 border border-red-100 dark:border-red-900/30"
            >
              <Sparkles className="w-4 h-4 text-red-600 dark:text-red-400" />
              <span className="text-sm font-bold text-red-600 dark:text-red-400 uppercase tracking-wider">
                Platform Gotong Royong Digital
              </span>
            </motion.div>

            <h1 className="text-4xl md:text-7xl font-black mb-6 font-poppins leading-[1.2] tracking-tight py-2">
              <span className="bg-gradient-to-r from-[#EF4444] to-[#F59E0B] bg-clip-text text-transparent py-1 inline-block" style={{ WebkitBackgroundClip: 'text', WebkitTextFillColor: 'transparent' }}>
                Bantuan Apa Pun, Kini Dalam Satu Klik
              </span>
            </h1>

            <p className="text-lg text-gray-700 dark:text-gray-300 mb-8 leading-relaxed font-medium">
              Mas Tulung Mas menghubungkan masyarakat dengan mitra terpercaya untuk membantu kebutuhan sehari-hari secara cepat, aman, dan profesional.
            </p>

            <div className="flex flex-col sm:flex-row gap-4">
              <motion.button
                whileHover={{ scale: 1.02 }}
                whileTap={{ scale: 0.95 }}
                className="px-10 py-4 bg-gradient-to-r from-[#EF4444] to-[#F59E0B] text-white rounded-full font-bold shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 group"
              >
                Pesan Bantuan
                <ArrowRight className="w-5 h-5 group-hover:translate-x-1 transition-transform" />
              </motion.button>
              <motion.button
                whileHover={{ scale: 1.02 }}
                whileTap={{ scale: 0.95 }}
                className="px-10 py-4 bg-white dark:bg-[#1E1E1E] border-2 border-gray-200 dark:border-gray-800 text-gray-900 dark:text-white rounded-full font-bold hover:bg-gray-50 dark:hover:bg-white/5 transition-all"
              >
                Jadi Mitra Tulung
              </motion.button>
            </div>
          </motion.div>

          {/* Right Visual */}
          <motion.div
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.6, delay: 0.3 }}
            className="relative"
          >
            <div className="relative z-10">
              {/* Phone Mockup */}
              <div className="mx-auto w-full max-w-sm aspect-[9/19] bg-gradient-to-br from-gray-800 to-gray-900 rounded-[3rem] p-3 shadow-2xl">
                <div className="w-full h-full bg-white dark:bg-[#1E1E1E] rounded-[2.5rem] overflow-hidden">
                  <div className="p-6 space-y-4">
                    <div className="flex items-center justify-between">
                      <div className="w-20 h-3 bg-gray-300 dark:bg-gray-700 rounded-full" />
                      <div className="w-12 h-3 bg-gray-300 dark:bg-gray-700 rounded-full" />
                    </div>
                    <div className="grid grid-cols-2 gap-3 mt-8">
                      {["Kurir", "Asisten", "Antre", "Teknis"].map((service, i) => (
                        <motion.div
                          key={service}
                          initial={{ opacity: 0, y: 20 }}
                          animate={{ opacity: 1, y: 0 }}
                          transition={{ delay: 0.6 + i * 0.1 }}
                          className="aspect-square bg-gradient-to-br from-red-50 to-amber-50 dark:from-red-950/20 dark:to-amber-950/20 rounded-2xl p-4 flex items-center justify-center"
                        >
                          <span className="text-xs font-semibold text-red-600 dark:text-red-400">
                            {service}
                          </span>
                        </motion.div>
                      ))}
                    </div>
                  </div>
                </div>
              </div>

              {/* Floating Cards */}
              <motion.div
                animate={{ y: [0, -10, 0] }}
                transition={{ duration: 3, repeat: Infinity }}
                className="absolute -right-4 top-20 bg-white dark:bg-[#1E1E1E] p-4 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800"
              >
                <div className="flex items-center gap-2">
                  <div className="w-10 h-10 bg-green-100 dark:bg-green-950/30 rounded-full flex items-center justify-center">
                    <CheckCircle className="w-5 h-5 text-green-600 dark:text-green-400" />
                  </div>
                  <div>
                    <p className="text-xs font-semibold text-gray-900 dark:text-white">Tugas Selesai</p>
                    <p className="text-xs text-gray-500 dark:text-gray-400">+1.200 hari ini</p>
                  </div>
                </div>
              </motion.div>

              <motion.div
                animate={{ y: [0, 10, 0] }}
                transition={{ duration: 3, repeat: Infinity, delay: 1 }}
                className="absolute -left-4 bottom-32 bg-white dark:bg-[#1E1E1E] p-4 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800"
              >
                <div className="flex items-center gap-2">
                  <div className="w-10 h-10 bg-yellow-100 dark:bg-yellow-950/30 rounded-full flex items-center justify-center">
                    <Star className="w-5 h-5 text-yellow-600 dark:text-yellow-400 fill-yellow-600 dark:fill-yellow-400" />
                  </div>
                  <div>
                    <p className="text-xs font-semibold text-gray-900 dark:text-white">Rating 4.9</p>
                    <p className="text-xs text-gray-500 dark:text-gray-400">98% Puas</p>
                  </div>
                </div>
              </motion.div>
            </div>
          </motion.div>
        </div>
      </div>
    </section>
  );
}

function StatsSection() {
  return (
    <section className="py-16 bg-gradient-to-r from-[#D32F2F] to-[#8B5A2B] relative overflow-hidden">
      <div className="absolute inset-0 opacity-10">
        <div className="absolute inset-0" style={{
          backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`
        }} />
      </div>

      <div className="container mx-auto px-4 relative z-10">
        <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
          <StatCard value="10.000" label="Pengguna" suffix="+" />
          <StatCard value="1.500" label="Mitra" suffix="+" />
          <StatCard value="25.000" label="Tugas Selesai" suffix="+" />
          <StatCard value="98" label="Kepuasan" suffix="%" />
        </div>
      </div>
    </section>
  );
}

function StatCard({ value, label, suffix }: { value: string; label: string; suffix: string }) {
  const [count, setCount] = useState(0);
  const [isVisible, setIsVisible] = useState(false);
  const ref = useRef<HTMLDivElement>(null);

  useEffect(() => {
    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          setIsVisible(true);
        }
      },
      { threshold: 0.1 }
    );

    if (ref.current) {
      observer.observe(ref.current);
    }

    return () => observer.disconnect();
  }, []);

  useEffect(() => {
    if (!isVisible) return;

    const target = parseFloat(value.replace(/[^0-9.]/g, ""));
    const duration = 2000;
    const steps = 60;
    const increment = target / steps;
    let current = 0;

    const timer = setInterval(() => {
      current += increment;
      if (current >= target) {
        setCount(target);
        clearInterval(timer);
      } else {
        setCount(current);
      }
    }, duration / steps);

    return () => clearInterval(timer);
  }, [isVisible, value]);

  return (
    <motion.div
      ref={ref}
      initial={{ opacity: 0, y: 20 }}
      whileInView={{ opacity: 1, y: 0 }}
      viewport={{ once: true }}
      className="text-center"
    >
      <div className="text-3xl md:text-5xl font-bold text-white mb-2 font-poppins">
        {Math.floor(count).toLocaleString()}
        {suffix}
      </div>
      <div className="text-white/90 font-medium">{label}</div>
    </motion.div>
  );
}

function ServicesSection() {
  const services = [
    {
      icon: Package,
      title: "Kurir & Logistik",
      description: "Pengiriman barang cepat dan aman ke seluruh kota",
    },
    {
      icon: Users,
      title: "Asisten Personal",
      description: "Bantuan untuk berbagai keperluan pribadi Anda",
    },
    {
      icon: Clock,
      title: "Jasa Antre",
      description: "Hemat waktu dengan layanan antre profesional",
    },
    {
      icon: Heart,
      title: "Pendamping Lansia",
      description: "Perawatan dan pendampingan untuk orang tua tercinta",
    },
    {
      icon: Zap,
      title: "Teknis & Reparasi",
      description: "Perbaikan dan instalasi peralatan rumah tangga",
    },
    {
      icon: Sparkles,
      title: "Custom Task",
      description: "Tugas khusus sesuai kebutuhan Anda",
    },
  ];

  return (
    <section className="py-20 bg-white dark:bg-[#121212]">
      <div className="container mx-auto px-4">
        <motion.div
          animate={{ opacity: 1, y: 0 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <h2 className="text-3xl md:text-6xl font-black mb-4 font-poppins tracking-tight leading-[1.2] py-2">
            <span className="bg-gradient-to-r from-[#EF4444] to-[#F59E0B] bg-clip-text text-transparent py-1 inline-block" style={{ WebkitBackgroundClip: 'text', WebkitTextFillColor: 'transparent' }}>
              Layanan Kami
            </span>
          </h2>
          <p className="text-lg text-gray-700 dark:text-gray-300 max-w-2xl mx-auto font-bold">
            Berbagai solusi untuk memudahkan kehidupan sehari-hari Anda
          </p>
        </motion.div>

        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          {services.map((service, index) => (
            <motion.div
              key={service.title}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: index * 0.1 }}
              whileHover={{ y: -8, scale: 1.02 }}
              className="group p-8 bg-white dark:bg-[#1E1E1E] rounded-2xl border border-[#E5E7EB] dark:border-gray-800 hover:border-[#DC2626] dark:hover:border-[#EF5350] hover:shadow-xl transition-all duration-300 shadow-sm"
            >
              <div className="w-14 h-14 bg-gray-50 dark:bg-white/5 rounded-xl flex items-center justify-center mb-6 group-hover:bg-gradient-to-r group-hover:from-red-500 group-hover:to-orange-400 group-hover:text-white group-hover:scale-110 transition-all border border-gray-100 dark:border-white/5 shadow-sm">
                <service.icon className="w-7 h-7 text-gray-700 dark:text-red-400 group-hover:text-white" />
              </div>
              <h3 className="text-xl font-black text-gray-900 dark:text-white mb-3">
                {service.title}
              </h3>
              <p className="text-gray-600 dark:text-gray-300 leading-relaxed font-medium">
                {service.description}
              </p>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}

function HowItWorksSection() {
  const steps = [
    {
      number: "01",
      title: "Buat Permintaan",
      description: "Jelaskan bantuan yang Anda butuhkan melalui aplikasi",
    },
    {
      number: "02",
      title: "Mitra Memberikan Penawaran",
      description: "Terima penawaran dari mitra terverifikasi di sekitar Anda",
    },
    {
      number: "03",
      title: "Pilih Mitra",
      description: "Bandingkan dan pilih mitra terbaik sesuai kebutuhan",
    },
    {
      number: "04",
      title: "Tugas Selesai",
      description: "Mitra menyelesaikan tugas dan Anda berikan rating",
    },
  ];

  return (
    <section className="py-20 bg-gradient-to-b from-white via-gray-50 to-white dark:from-[#121212] dark:via-[#1A1A1A] dark:to-[#121212]">
      <div className="container mx-auto px-4">
        <motion.div
          animate={{ opacity: 1, y: 0 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <h2 className="text-3xl md:text-5xl font-black mb-4 font-poppins tracking-tight leading-[1.2] py-2">
            <span className="bg-gradient-to-r from-[#EF4444] to-[#F59E0B] bg-clip-text text-transparent py-1 inline-block" style={{ WebkitBackgroundClip: 'text', WebkitTextFillColor: 'transparent' }}>
              Cara Kerja
            </span>
          </h2>
          <p className="text-lg text-gray-700 dark:text-gray-300 max-w-2xl mx-auto font-bold">
            Empat langkah mudah untuk mendapatkan bantuan yang Anda butuhkan
          </p>
        </motion.div>

        <div className="max-w-4xl mx-auto">
          {steps.map((step, index) => (
            <motion.div
              key={step.number}
              initial={{ opacity: 0, x: -30 }}
              whileInView={{ opacity: 1, x: 0 }}
              viewport={{ once: true }}
              transition={{ delay: index * 0.2 }}
              className="relative pl-24 pb-12 last:pb-0"
            >
              {/* Vertical Line */}
              {index !== steps.length - 1 && (
                <div className="absolute left-9 top-20 bottom-0 w-0.5 bg-gradient-to-b from-[#D32F2F] to-[#8B5A2B]" />
              )}

              {/* Number Circle */}
              <div className="absolute left-0 top-0 w-20 h-20 bg-gradient-to-br from-[#D32F2F] to-[#8B5A2B] rounded-full flex items-center justify-center text-2xl font-bold text-white shadow-lg shadow-[#D32F2F]/30">
                {step.number}
              </div>

              {/* Content */}
              <div className="bg-white dark:bg-[#1E1E1E] p-6 rounded-2xl border border-gray-100 dark:border-gray-800 hover:border-[#D32F2F] dark:hover:border-[#EF5350] hover:shadow-xl transition-all">
                <h3 className="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                  {step.title}
                </h3>
                <p className="text-gray-600 dark:text-gray-300">
                  {step.description}
                </p>
              </div>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}

function WhyChooseSection() {
  const features = [
    {
      icon: Shield,
      title: "Mitra Terverifikasi",
      description: "Semua mitra melalui proses verifikasi ketat",
    },
    {
      icon: CheckCircle,
      title: "Pembayaran Aman",
      description: "Sistem pembayaran yang aman dan terpercaya",
    },
    {
      icon: TrendingUp,
      title: "Harga Transparan",
      description: "Tidak ada biaya tersembunyi",
    },
    {
      icon: Zap,
      title: "Respon Cepat",
      description: "Dapatkan bantuan dalam hitungan menit",
    },
    {
      icon: Heart,
      title: "Dukungan Lokal",
      description: "Memberdayakan ekonomi lokal",
    },
    {
      icon: Clock,
      title: "Layanan Fleksibel",
      description: "Tersedia 24/7 sesuai kebutuhan Anda",
    },
  ];

  return (
    <section className="py-20 bg-white dark:bg-[#121212]">
      <div className="container mx-auto px-4">
        <motion.div
          animate={{ opacity: 1, y: 0 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <h2 className="text-3xl md:text-5xl font-black mb-4 font-poppins tracking-tight leading-[1.2] py-2">
            <span className="bg-gradient-to-r from-[#EF4444] to-[#F59E0B] bg-clip-text text-transparent py-1 inline-block" style={{ WebkitBackgroundClip: 'text', WebkitTextFillColor: 'transparent' }}>
              Mengapa Pilih MTM?
            </span>
          </h2>
          <p className="text-lg text-gray-700 dark:text-gray-300 max-w-2xl mx-auto font-bold">
            Platform gotong royong digital terpercaya untuk Indonesia
          </p>
        </motion.div>

        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          {features.map((feature, index) => (
            <motion.div
              key={feature.title}
              initial={{ opacity: 0, scale: 0.9 }}
              whileInView={{ opacity: 1, scale: 1 }}
              viewport={{ once: true }}
              transition={{ delay: index * 0.1 }}
              className="p-6 rounded-2xl border border-gray-100 dark:border-gray-800 hover:bg-gradient-to-br hover:from-red-50 hover:to-amber-50 dark:hover:from-red-950/10 dark:hover:to-amber-950/10 transition-all"
            >
              <feature.icon className="w-10 h-10 text-red-600 dark:text-red-400 mb-4" />
              <h3 className="text-xl font-black text-gray-900 dark:text-white mb-2">
                {feature.title}
              </h3>
              <p className="text-gray-700 dark:text-gray-300 font-bold">
                {feature.description}
              </p>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}

function CommunityImpactSection() {
  return (
    <section className="py-20 bg-gradient-to-b from-white via-amber-50/30 to-white dark:from-[#121212] dark:via-amber-950/5 dark:to-[#121212]">
      <div className="container mx-auto px-4">
        <motion.div
          animate={{ opacity: 1, y: 0 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <h2 className="text-3xl md:text-5xl font-black mb-4 font-poppins tracking-tight leading-[1.2] py-2">
            <span className="bg-gradient-to-r from-[#EF4444] to-[#F59E0B] bg-clip-text text-transparent py-1 inline-block" style={{ WebkitBackgroundClip: 'text', WebkitTextFillColor: 'transparent' }}>
              Dampak Komunitas
            </span>
          </h2>
          <p className="text-lg text-gray-700 dark:text-gray-300 max-w-2xl mx-auto font-bold">
            MTM membantu berbagai lapisan masyarakat Indonesia
          </p>
        </motion.div>

        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
          {[
            { label: "Mahasiswa", value: "35%", color: "from-blue-500 to-blue-600" },
            { label: "Pekerja", value: "40%", color: "from-green-500 to-green-600" },
            { label: "UMKM", value: "15%", color: "from-purple-500 to-purple-600" },
            { label: "Keluarga", value: "10%", color: "from-orange-500 to-orange-600" },
          ].map((item, index) => (
            <motion.div
              key={item.label}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: index * 0.1 }}
              className="text-center p-8 bg-white dark:bg-[#1E1E1E] rounded-2xl border border-gray-100 dark:border-gray-800"
            >
              <div className={`text-4xl font-bold text-red-500 mb-2`}>
                {item.value}
              </div>
              <div className="text-gray-600 dark:text-gray-300 font-medium">
                {item.label}
              </div>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}

function TestimonialsSection() {
  const testimonials = [
    {
      name: "Budi Santoso",
      role: "Mahasiswa",
      rating: 5,
      text: "MTM sangat membantu saya saat sibuk kuliah. Mitra yang datang selalu profesional and tepat waktu!",
      avatar: "BS",
    },
    {
      name: "Siti Nurhaliza",
      role: "Pengusaha UMKM",
      rating: 5,
      text: "Layanan kurir MTM sangat membantu bisnis saya. Pengiriman cepat dan harga terjangkau.",
      avatar: "SN",
    },
    {
      name: "Andi Wijaya",
      role: "Pekerja Kantoran",
      rating: 5,
      text: "Tidak ada lagi stress antre! Jasa antre MTM benar-benar menghemat waktu saya.",
      avatar: "AW",
    },
  ];

  return (
    <section className="py-20 bg-gray-50 dark:bg-[#0F0F0F]">
      <div className="container mx-auto px-4">
        <motion.div
          animate={{ opacity: 1, y: 0 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <h2 className="text-3xl md:text-6xl font-black mb-4 font-poppins tracking-tight leading-[1.2] py-2">
            <span className="bg-gradient-to-r from-[#EF4444] to-[#F59E0B] bg-clip-text text-transparent py-1 inline-block" style={{ WebkitBackgroundClip: 'text', WebkitTextFillColor: 'transparent' }}>
              Testimoni Pengguna
            </span>
          </h2>
          <p className="text-lg text-[#374151] dark:text-gray-300 max-w-2xl mx-auto font-medium">
            Apa kata mereka yang telah menggunakan MTM
          </p>
        </motion.div>

        <div className="grid md:grid-cols-3 gap-6">
          {testimonials.map((testimonial, index) => (
            <motion.div
              key={testimonial.name}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: index * 0.1 }}
              className="p-8 bg-white dark:bg-[#1E1E1E] rounded-3xl border border-[#E5E7EB] dark:border-gray-800 hover:shadow-xl transition-all duration-500 shadow-sm"
            >
              <div className="flex items-center gap-4 mb-6">
                <div className="w-14 h-14 bg-gradient-to-r from-[#EF4444] to-[#F59E0B] rounded-2xl flex items-center justify-center text-white font-black text-xl shadow-md">
                  {testimonial.avatar}
                </div>
                <div>
                  <div className="font-black text-gray-900 dark:text-white text-lg">
                    {testimonial.name}
                  </div>
                  <div className="text-sm text-gray-500 dark:text-gray-400 font-bold">
                    {testimonial.role}
                  </div>
                </div>
              </div>
              <div className="flex gap-1 mb-6">
                {Array.from({ length: testimonial.rating }).map((_, i) => (
                  <Star
                    key={i}
                    className="w-4 h-4 text-amber-500 fill-amber-500"
                  />
                ))}
              </div>
              <p className="text-gray-700 dark:text-gray-300 leading-relaxed font-medium italic">
                "{testimonial.text}"
              </p>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}

function FAQSection() {
  const [openIndex, setOpenIndex] = useState<number | null>(null);

  const faqs = [
    {
      question: "Bagaimana cara memesan layanan MTM?",
      answer: "Cukup download aplikasi, buat akun, pilih layanan yang Anda butuhkan, dan tunggu penawaran dari mitra terverifikasi kami.",
    },
    {
      question: "Apakah mitra MTM sudah terverifikasi?",
      answer: "Ya, semua mitra MTM melalui proses verifikasi identitas dan background check untuk memastikan keamanan Anda.",
    },
    {
      question: "Bagaimana sistem pembayaran di MTM?",
      answer: "Pembayaran dilakukan melalui aplikasi dengan berbagai metode: transfer bank, e-wallet, atau tunai. Dana hanya akan diteruskan ke mitra setelah tugas selesai.",
    },
    {
      question: "Apakah MTM tersedia di kota saya?",
      answer: "Saat ini MTM tersedia di kota-kota besar di Indonesia dan terus berkembang. Cek aplikasi untuk ketersediaan di kota Anda.",
    },
  ];

  return (
    <section className="py-20 bg-white dark:bg-[#121212]">
      <div className="container mx-auto px-4">
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-6xl font-black mb-6 font-poppins tracking-tight leading-[1.2] py-2">
            <span className="bg-gradient-to-r from-[#EF4444] to-[#F59E0B] bg-clip-text text-transparent py-1 inline-block" style={{ WebkitBackgroundClip: 'text', WebkitTextFillColor: 'transparent' }}>
              Pertanyaan Umum
            </span>
          </h2>
          <p className="text-xl text-[#374151] dark:text-gray-400 max-w-2xl mx-auto font-bold">
            Temukan jawaban untuk pertanyaan yang sering ditanyakan
          </p>
        </div>

        <div className="max-w-3xl mx-auto space-y-4">
          {faqs.map((faq, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: index * 0.1 }}
              className="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-[#E5E7EB] dark:border-gray-800 overflow-hidden shadow-sm hover:shadow-md transition-all"
            >
              <button
                onClick={() => setOpenIndex(openIndex === index ? null : index)}
                className="w-full p-6 flex items-center justify-between text-left group"
              >
                <span 
                  className={`font-black pr-4 text-xl transition-all inline-block py-1 ${openIndex === index ? 'text-red-500 dark:text-orange-400' : 'text-gray-900 dark:text-white group-hover:text-red-600'}`}
                >
                  {faq.question}
                </span>
                <motion.div
                  animate={{ rotate: openIndex === index ? 180 : 0 }}
                  transition={{ duration: 0.3 }}
                  className={`w-8 h-8 rounded-full flex items-center justify-center transition-colors ${openIndex === index ? 'bg-gradient-to-r from-red-500 to-orange-400' : 'bg-gray-50 dark:bg-white/5'}`}
                >
                  <ArrowRight className={`w-4 h-4 rotate-90 transition-colors ${openIndex === index ? 'text-white' : 'text-gray-700 dark:text-gray-400'}`} />
                </motion.div>
              </button>
              <motion.div
                initial={false}
                animate={{
                  height: openIndex === index ? "auto" : 0,
                  opacity: openIndex === index ? 1 : 0,
                }}
                transition={{ duration: 0.3 }}
                className="overflow-hidden"
              >
                <div className="px-6 pb-6 text-gray-600 dark:text-gray-300 font-medium leading-relaxed">
                  {faq.answer}
                </div>
              </motion.div>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}

function CTASection() {
  return (
    <section className="py-20 relative overflow-hidden">
      <div className="absolute inset-0 bg-[#0F0F0F]" />
      <div className="absolute inset-0 opacity-[0.05]">
        <div className="absolute inset-0" style={{
          backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`
        }} />
      </div>
      
      {/* Glow Effects */}
      <div className="absolute -top-1/2 -left-1/2 w-full h-full bg-[#EF4444]/10 rounded-full blur-[120px]" />
      <div className="absolute -bottom-1/2 -right-1/2 w-full h-full bg-[#F59E0B]/10 rounded-full blur-[120px]" />

      <div className="container mx-auto px-4 relative z-10">
        <motion.div
          animate={{ opacity: 1, scale: 1 }}
          whileInView={{ opacity: 1, scale: 1 }}
          viewport={{ once: true }}
          className="text-center"
        >
          <h2 className="text-3xl md:text-7xl font-black mb-6 font-poppins tracking-tight leading-[1.2] py-2">
            <span className="bg-gradient-to-r from-[#EF4444] to-[#F59E0B] bg-clip-text text-transparent py-1 inline-block" style={{ WebkitBackgroundClip: 'text', WebkitTextFillColor: 'transparent' }}>
              Siap Memulai Perubahan?
            </span>
          </h2>
          <p className="text-lg text-gray-400 mb-12 max-w-2xl mx-auto font-medium">
            Bergabunglah dengan ekosistem gotong royong digital terbesar di Indonesia. Bantuan kini lebih dekat dari yang Anda bayangkan.
          </p>
          <div className="flex flex-col sm:flex-row gap-6 justify-center">
            <motion.button
              whileHover={{ scale: 1.02 }}
              whileTap={{ scale: 0.95 }}
              className="px-14 py-6 bg-white dark:bg-[#1E1E1E] text-gray-900 dark:text-white rounded-full font-black text-xl shadow-2xl hover:bg-gray-50 transition-all"
            >
              Daftar Sekarang
            </motion.button>
            <motion.button
              whileHover={{ scale: 1.02 }}
              whileTap={{ scale: 0.95 }}
              className="px-14 py-6 bg-transparent border-2 border-white/10 text-white rounded-full font-black text-xl hover:bg-white hover:text-gray-900 transition-all"
            >
              Hubungi Kami
            </motion.button>
          </div>
        </motion.div>
      </div>
    </section>
  );
}

function Footer() {
  return (
    <footer className="bg-gray-50 dark:bg-[#0F0F0F] text-gray-700 dark:text-gray-400 pt-32 pb-16 border-t border-gray-200 dark:border-white/5 relative overflow-hidden">
      <div className="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-orange-400" />
      
      <div className="container mx-auto px-4 relative z-10">
        <div className="grid md:grid-cols-4 gap-16 mb-24">
          <div className="md:col-span-2">
            <div className="flex items-center gap-4 mb-8">
              <img src="/images/logomtm.png" alt="MTM Logo" className="h-16 w-auto object-contain" />
            </div>
            <p className="text-gray-700 dark:text-gray-400 max-w-md leading-relaxed text-lg font-medium">
              Platform digital gotong royong yang menghubungkan masyarakat dengan mitra terpercaya untuk segala jenis bantuan dalam satu klik.
            </p>
          </div>

          <div>
            <h4 className="font-black text-gray-900 dark:text-white mb-8 font-poppins text-lg uppercase tracking-widest">Layanan</h4>
            <ul className="space-y-4">
              {['Kurir Express', 'Asisten Pribadi', 'Jasa Antre', 'Bantuan Teknis', 'Kebersihan Rumah'].map((item) => (
                <li key={item}>
                  <a href="#" className="hover:text-red-600 transition-colors flex items-center gap-2 group font-bold">
                    <span className="w-1.5 h-1.5 rounded-full bg-gray-300 dark:bg-gray-700 group-hover:bg-red-600 transition-colors" />
                    {item}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          <div>
            <h4 className="font-black text-gray-900 dark:text-white mb-8 font-poppins text-lg uppercase tracking-widest">Perusahaan</h4>
            <ul className="space-y-4">
              {['Tentang Kami', 'Karir', 'Syarat & Ketentuan', 'Kebijakan Privasi', 'Pusat Bantuan'].map((item) => (
                <li key={item}>
                  <a href="#" className="hover:text-red-600 transition-colors flex items-center gap-2 group font-bold">
                    <span className="w-1.5 h-1.5 rounded-full bg-gray-300 dark:bg-gray-700 group-hover:bg-red-600 transition-colors" />
                    {item}
                  </a>
                </li>
              ))}
            </ul>
          </div>
        </div>

        <div className="pt-12 border-t border-[#E5E7EB] dark:border-white/5 flex flex-col md:flex-row justify-between items-center gap-8 font-medium">
          <p className="text-sm">
            &copy; {new Date().getFullYear()} <span 
              className="text-[#EF4444] dark:text-[#F59E0B] font-black py-1 inline-block"
            >Mas Tulung Mas</span>. Seluruh hak cipta dilindungi.
          </p>
          <div className="flex items-center gap-6 text-sm">
            <span>Dibuat dengan <span className="text-red-600 animate-pulse">♥</span> untuk Indonesia</span>
            <span className="w-1 h-1 rounded-full bg-gray-300" />
            <span>v1.0.0</span>
          </div>
        </div>
      </div>
    </footer>
  );
}


