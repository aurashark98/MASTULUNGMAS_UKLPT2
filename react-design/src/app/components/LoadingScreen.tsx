import React from "react";
import { motion } from "framer-motion";
import { useEffect, useState } from "react";

export function LoadingScreen({ onComplete }: { onComplete: () => void }) {
  const [progress, setProgress] = useState(0);

  useEffect(() => {
    const timer = setInterval(() => {
      setProgress((prev: number) => {
        if (prev >= 100) {
          clearInterval(timer);
          setTimeout(onComplete, 500);
          return 100;
        }
        return prev + 1.5;
      });
    }, 20);

    return () => clearInterval(timer);
  }, [onComplete]);

  const brandName = "Mas Tulung Mas";

  return (
    <motion.div
      initial={{ opacity: 1 }}
      exit={{ opacity: 0 }}
      className="fixed inset-0 z-50 flex items-center justify-center bg-white dark:bg-[#0A0A0A] overflow-hidden"
    >
      {/* Animated Background Elements */}
      <div className="absolute inset-0 overflow-hidden pointer-events-none">
        <motion.div
          animate={{
            scale: [1, 1.2, 1],
            opacity: [0.1, 0.2, 0.1],
            x: [0, 50, 0],
            y: [0, -50, 0],
          }}
          transition={{ duration: 10, repeat: Infinity, ease: "linear" }}
          className="absolute -top-1/4 -left-1/4 w-1/2 h-1/2 bg-[#D32F2F] rounded-full blur-[120px]"
        />
        <motion.div
          animate={{
            scale: [1, 1.3, 1],
            opacity: [0.1, 0.15, 0.1],
            x: [0, -30, 0],
            y: [0, 40, 0],
          }}
          transition={{ duration: 12, repeat: Infinity, ease: "linear" }}
          className="absolute -bottom-1/4 -right-1/4 w-1/2 h-1/2 bg-[#8B5A2B] rounded-full blur-[120px]"
        />
      </div>

      <div className="flex flex-col items-center gap-10 relative z-10">
        {/* MTM Logo Animation Container */}
        <div className="relative">
          {/* Outer Glow Ring */}
          <motion.div
            animate={{ rotate: 360 }}
            transition={{ duration: 8, repeat: Infinity, ease: "linear" }}
            className="absolute inset-[-20px] border border-dashed border-[#D32F2F]/20 rounded-full"
          />
          
          <motion.div
            initial={{ scale: 0.8, opacity: 0 }}
            animate={{ scale: 1, opacity: 1 }}
            transition={{ duration: 0.8, ease: "easeOut" }}
            className="relative bg-white dark:bg-[#1A1A1A] p-6 rounded-3xl shadow-2xl border border-gray-100 dark:border-white/5"
          >
            {/* MTM Logo SVG */}
            <svg
              width="100"
              height="100"
              viewBox="0 0 120 120"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              {/* Left Hand */}
              <motion.path
                initial={{ pathLength: 0, opacity: 0 }}
                animate={{ pathLength: 1, opacity: 1 }}
                transition={{ duration: 1.2, delay: 0.2, ease: "easeInOut" }}
                d="M20 80 L20 40 L40 60 L50 30"
                stroke="#D32F2F"
                strokeWidth="10"
                strokeLinecap="round"
                strokeLinejoin="round"
                fill="none"
              />
              {/* Right Hand */}
              <motion.path
                initial={{ pathLength: 0, opacity: 0 }}
                animate={{ pathLength: 1, opacity: 1 }}
                transition={{ duration: 1.2, delay: 0.5, ease: "easeInOut" }}
                d="M100 80 L100 40 L80 60 L70 30"
                stroke="#D32F2F"
                strokeWidth="10"
                strokeLinecap="round"
                strokeLinejoin="round"
                fill="none"
              />
              {/* Heart in center */}
              <motion.path
                initial={{ scale: 0 }}
                animate={{ 
                  scale: [0, 1.2, 1],
                  filter: ["blur(0px)", "blur(2px)", "blur(0px)"]
                }}
                transition={{ 
                  scale: { duration: 0.6, delay: 1.2 },
                  filter: { duration: 2, repeat: Infinity, ease: "easeInOut" }
                }}
                d="M60 65 L50 55 C45 50 45 42 50 37 C55 32 63 32 60 40 C57 32 65 32 70 37 C75 42 75 50 70 55 Z"
                fill="#8B5A2B"
                style={{ transformOrigin: "60px 50px" }}
              />
            </svg>
          </motion.div>
        </div>

        {/* Brand Name & Tagline */}
        <div className="text-center space-y-3">
          <div className="flex justify-center">
            {brandName.split("").map((char, index) => (
              <motion.span
                key={index}
                initial={{ y: 20, opacity: 0 }}
                animate={{ y: 0, opacity: 1 }}
                transition={{ delay: 0.5 + index * 0.05, duration: 0.5 }}
                className={`text-4xl font-black font-poppins ${
                  char === " " ? "mx-1" : ""
                } ${
                  index < 3 || index > 9 ? "text-[#D32F2F]" : "text-gray-800 dark:text-white"
                }`}
              >
                {char}
              </motion.span>
            ))}
          </div>
          
          <motion.p
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ delay: 1.5, duration: 1 }}
            className="text-sm font-medium text-[#8B5A2B] dark:text-[#A67C52] tracking-widest uppercase"
          >
            Bantuan Apa Pun, Kini Dalam Satu Klik
          </motion.p>
        </div>

        {/* Progress Section */}
        <div className="flex flex-col items-center gap-3 w-72">
          <div className="w-full h-2 bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden relative shadow-inner">
            <motion.div
              className="h-full bg-gradient-to-r from-[#D32F2F] via-[#B71C1C] to-[#8B5A2B] relative"
              style={{ width: `${progress}%` }}
              transition={{ duration: 0.1 }}
            >
              {/* Progress Glow Effect */}
              <div className="absolute right-0 top-0 bottom-0 w-8 bg-white/30 blur-md" />
            </motion.div>
          </div>
          <div className="flex flex-col items-center gap-1 w-full">
            <motion.span 
              className="text-[10px] font-bold text-gray-400 uppercase tracking-tighter"
              animate={{ opacity: [0.5, 1, 0.5] }}
              transition={{ duration: 1.5, repeat: Infinity }}
            >
              Sistem Sedang Memuat...
            </motion.span>
            <span className="text-[10px] font-bold text-[#D32F2F] tabular-nums">
              {Math.round(progress)}%
            </span>
          </div>
        </div>
      </div>
    </motion.div>
  );
}
