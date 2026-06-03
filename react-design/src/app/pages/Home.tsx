import { motion } from "motion/react";
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
    <section className="relative overflow-hidden bg-gradient-to-b from-white via-red-50/30 to-white dark:from-[#121212] dark:via-red-950/10 dark:to-[#121212] py-20 md:py-32">
      {/* Background Pattern */}
      <div className="absolute inset-0 opacity-5">
        <div className="absolute inset-0" style={{
          backgroundImage: `radial-gradient(circle at 1px 1px, rgb(211 47 47) 1px, transparent 0)`,
          backgroundSize: '40px 40px'
        }} />
      </div>

      <div className="container mx-auto px-4 relative z-10">
        <div className="grid md:grid-cols-2 gap-12 items-center">
          {/* Left Content */}
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
          >
            <motion.div
              initial={{ opacity: 0, scale: 0.9 }}
              animate={{ opacity: 1, scale: 1 }}
              transition={{ delay: 0.2 }}
              className="inline-flex items-center gap-2 px-4 py-2 bg-red-100 dark:bg-red-950/30 rounded-full mb-6"
            >
              <Sparkles className="w-4 h-4 text-[#D32F2F]" />
              <span className="text-sm font-medium text-[#D32F2F] dark:text-[#EF5350]">
                Platform Gotong Royong Digital
              </span>
            </motion.div>

            <h1 className="text-4xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6 font-poppins leading-tight">
              Bantuan Apa Pun,{" "}
              <span className="text-transparent bg-clip-text bg-gradient-to-r from-[#D32F2F] to-[#8B5A2B]">
                Kini Dalam Satu Klik
              </span>
            </h1>

            <p className="text-lg text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
              Mas Tulung Mas menghubungkan masyarakat dengan mitra terpercaya untuk membantu kebutuhan sehari-hari secara cepat, aman, dan profesional.
            </p>

            <div className="flex flex-col sm:flex-row gap-4">
              <motion.button
                whileHover={{ scale: 1.05 }}
                whileTap={{ scale: 0.95 }}
                className="px-8 py-4 bg-gradient-to-r from-[#D32F2F] to-[#B71C1C] text-white rounded-full font-semibold shadow-lg shadow-[#D32F2F]/30 hover:shadow-xl hover:shadow-[#D32F2F]/40 transition-all flex items-center justify-center gap-2 group"
              >
                Pesan Bantuan
                <ArrowRight className="w-5 h-5 group-hover:translate-x-1 transition-transform" />
              </motion.button>
              <motion.button
                whileHover={{ scale: 1.05 }}
                whileTap={{ scale: 0.95 }}
                className="px-8 py-4 bg-white dark:bg-[#1E1E1E] border-2 border-[#8B5A2B] dark:border-[#A67C52] text-[#8B5A2B] dark:text-[#A67C52] rounded-full font-semibold hover:bg-[#8B5A2B] hover:text-white dark:hover:bg-[#A67C52] dark:hover:text-white transition-all"
              >
                Jadi Mitra Tulung
              </motion.button>
            </div>
          </motion.div>

          {/* Right Visual */}
          <motion.div
            initial={{ opacity: 0, x: 30 }}
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
                          <span className="text-xs font-semibold text-[#D32F2F] dark:text-[#EF5350]">
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
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <h2 className="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4 font-poppins">
            Layanan Kami
          </h2>
          <p className="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
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
              className="group p-8 bg-white dark:bg-[#1E1E1E] rounded-2xl border border-gray-100 dark:border-gray-800 hover:border-[#D32F2F] dark:hover:border-[#EF5350] hover:shadow-xl hover:shadow-[#D32F2F]/10 transition-all duration-300"
            >
              <div className="w-14 h-14 bg-gradient-to-br from-red-50 to-amber-50 dark:from-red-950/20 dark:to-amber-950/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <service.icon className="w-7 h-7 text-[#D32F2F] dark:text-[#EF5350]" />
              </div>
              <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-3">
                {service.title}
              </h3>
              <p className="text-gray-600 dark:text-gray-300 leading-relaxed">
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
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <h2 className="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4 font-poppins">
            Cara Kerja
          </h2>
          <p className="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
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
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <h2 className="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4 font-poppins">
            Mengapa Pilih MTM?
          </h2>
          <p className="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
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
              <feature.icon className="w-10 h-10 text-[#D32F2F] dark:text-[#EF5350] mb-4" />
              <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-2">
                {feature.title}
              </h3>
              <p className="text-gray-600 dark:text-gray-300">
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
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <h2 className="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4 font-poppins">
            Dampak Komunitas
          </h2>
          <p className="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
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
              <div className={`text-4xl font-bold bg-gradient-to-r ${item.color} bg-clip-text text-transparent mb-2`}>
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
      text: "MTM sangat membantu saya saat sibuk kuliah. Mitra yang datang selalu profesional dan tepat waktu!",
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
    <section className="py-20 bg-white dark:bg-[#121212]">
      <div className="container mx-auto px-4">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <h2 className="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4 font-poppins">
            Testimoni Pengguna
          </h2>
          <p className="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
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
              className="p-6 bg-gradient-to-br from-white/80 to-white dark:from-[#1E1E1E]/80 dark:to-[#1E1E1E] backdrop-blur-xl rounded-2xl border border-gray-100 dark:border-gray-800 hover:border-[#D32F2F] dark:hover:border-[#EF5350] hover:shadow-xl transition-all"
            >
              <div className="flex items-center gap-4 mb-4">
                <div className="w-12 h-12 bg-gradient-to-br from-[#D32F2F] to-[#8B5A2B] rounded-full flex items-center justify-center text-white font-bold">
                  {testimonial.avatar}
                </div>
                <div>
                  <div className="font-bold text-gray-900 dark:text-white">
                    {testimonial.name}
                  </div>
                  <div className="text-sm text-gray-500 dark:text-gray-400">
                    {testimonial.role}
                  </div>
                </div>
              </div>
              <div className="flex gap-1 mb-4">
                {Array.from({ length: testimonial.rating }).map((_, i) => (
                  <Star
                    key={i}
                    className="w-4 h-4 text-yellow-500 fill-yellow-500"
                  />
                ))}
              </div>
              <p className="text-gray-600 dark:text-gray-300 leading-relaxed">
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
    <section className="py-20 bg-gradient-to-b from-white via-gray-50 to-white dark:from-[#121212] dark:via-[#1A1A1A] dark:to-[#121212]">
      <div className="container mx-auto px-4">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <h2 className="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4 font-poppins">
            Pertanyaan Umum
          </h2>
          <p className="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
            Temukan jawaban untuk pertanyaan yang sering ditanyakan
          </p>
        </motion.div>

        <div className="max-w-3xl mx-auto space-y-4">
          {faqs.map((faq, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: index * 0.1 }}
              className="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-gray-100 dark:border-gray-800 overflow-hidden"
            >
              <button
                onClick={() => setOpenIndex(openIndex === index ? null : index)}
                className="w-full p-6 flex items-center justify-between text-left hover:bg-gray-50 dark:hover:bg-[#252525] transition-colors"
              >
                <span className="font-semibold text-gray-900 dark:text-white pr-4">
                  {faq.question}
                </span>
                <motion.div
                  animate={{ rotate: openIndex === index ? 180 : 0 }}
                  transition={{ duration: 0.3 }}
                >
                  <ArrowRight className="w-5 h-5 text-[#D32F2F] dark:text-[#EF5350] rotate-90" />
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
                <div className="px-6 pb-6 text-gray-600 dark:text-gray-300">
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
      <div className="absolute inset-0 bg-gradient-to-r from-[#D32F2F] to-[#8B5A2B]" />
      <div className="absolute inset-0 opacity-10">
        <div className="absolute inset-0" style={{
          backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`
        }} />
      </div>

      <div className="container mx-auto px-4 relative z-10">
        <motion.div
          initial={{ opacity: 0, scale: 0.9 }}
          whileInView={{ opacity: 1, scale: 1 }}
          viewport={{ once: true }}
          className="text-center"
        >
          <h2 className="text-3xl md:text-5xl font-bold text-white mb-6 font-poppins">
            Gotong Royong Kini Dalam Genggaman
          </h2>
          <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
            Bergabunglah dengan ribuan pengguna yang telah merasakan kemudahan bantuan dalam satu klik
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <motion.button
              whileHover={{ scale: 1.05 }}
              whileTap={{ scale: 0.95 }}
              className="px-8 py-4 bg-white text-[#D32F2F] rounded-full font-semibold shadow-lg hover:shadow-xl transition-all"
            >
              Pesan Sekarang
            </motion.button>
            <motion.button
              whileHover={{ scale: 1.05 }}
              whileTap={{ scale: 0.95 }}
              className="px-8 py-4 bg-transparent border-2 border-white text-white rounded-full font-semibold hover:bg-white hover:text-[#D32F2F] transition-all"
            >
              Gabung Menjadi Mitra
            </motion.button>
          </div>
        </motion.div>
      </div>
    </section>
  );
}

function Footer() {
  return (
    <footer className="bg-[#8B5A2B] dark:bg-[#6D4422] text-white pt-16 pb-8">
      <div className="container mx-auto px-4">
        <div className="grid md:grid-cols-4 gap-8 mb-12">
          <div>
            <div className="flex items-center gap-2 mb-4">
              <div className="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                <span className="text-[#D32F2F] font-bold">M</span>
              </div>
              <span className="text-xl font-bold font-poppins">Mas Tulung Mas</span>
            </div>
            <p className="text-white/80 text-sm leading-relaxed">
              Platform gotong royong digital yang menghubungkan masyarakat dengan mitra terpercaya.
            </p>
          </div>

          <div>
            <h4 className="font-bold mb-4">Layanan</h4>
            <ul className="space-y-2 text-sm text-white/80">
              <li><a href="#" className="hover:text-white transition-colors">Kurir & Logistik</a></li>
              <li><a href="#" className="hover:text-white transition-colors">Asisten Personal</a></li>
              <li><a href="#" className="hover:text-white transition-colors">Jasa Antre</a></li>
              <li><a href="#" className="hover:text-white transition-colors">Pendamping Lansia</a></li>
            </ul>
          </div>

          <div>
            <h4 className="font-bold mb-4">Perusahaan</h4>
            <ul className="space-y-2 text-sm text-white/80">
              <li><a href="#" className="hover:text-white transition-colors">Tentang Kami</a></li>
              <li><a href="#" className="hover:text-white transition-colors">Cara Kerja</a></li>
              <li><a href="#" className="hover:text-white transition-colors">Karir</a></li>
              <li><a href="#" className="hover:text-white transition-colors">Blog</a></li>
            </ul>
          </div>

          <div>
            <h4 className="font-bold mb-4">Newsletter</h4>
            <p className="text-sm text-white/80 mb-4">
              Dapatkan update terbaru dari MTM
            </p>
            <div className="flex gap-2">
              <input
                type="email"
                placeholder="Email Anda"
                className="flex-1 px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white placeholder:text-white/50 focus:outline-none focus:border-white/40"
              />
              <button className="px-4 py-2 bg-[#D32F2F] hover:bg-[#B71C1C] rounded-lg transition-colors">
                <MessageCircle className="w-5 h-5" />
              </button>
            </div>
          </div>
        </div>

        <div className="pt-8 border-t border-white/20 text-center text-sm text-white/60">
          <p>&copy; 2026 Mas Tulung Mas. All rights reserved. Made with ❤️ in Indonesia</p>
        </div>
      </div>
    </footer>
  );
}
