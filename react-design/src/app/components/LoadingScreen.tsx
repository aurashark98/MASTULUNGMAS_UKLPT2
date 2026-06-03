import { motion } from "motion/react";
import { useEffect, useState } from "react";

export function LoadingScreen({ onComplete }: { onComplete: () => void }) {
  const [progress, setProgress] = useState(0);

  useEffect(() => {
    const timer = setInterval(() => {
      setProgress((prev) => {
        if (prev >= 100) {
          clearInterval(timer);
          setTimeout(onComplete, 300);
          return 100;
        }
        return prev + 2;
      });
    }, 20);

    return () => clearInterval(timer);
  }, [onComplete]);

  return (
    <motion.div
      initial={{ opacity: 1 }}
      exit={{ opacity: 0 }}
      className="fixed inset-0 z-50 flex items-center justify-center bg-white dark:bg-[#121212]"
    >
      <div className="flex flex-col items-center gap-8">
        {/* MTM Logo Animation */}
        <motion.div
          initial={{ scale: 0.5, opacity: 0 }}
          animate={{ scale: 1, opacity: 1 }}
          transition={{ duration: 0.5 }}
          className="relative"
        >
          {/* Helping Hands forming M */}
          <svg
            width="120"
            height="120"
            viewBox="0 0 120 120"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            {/* Left Hand */}
            <motion.path
              initial={{ pathLength: 0 }}
              animate={{ pathLength: 1 }}
              transition={{ duration: 0.8, delay: 0.2 }}
              d="M20 80 L20 40 L40 60 L50 30"
              stroke="#D32F2F"
              strokeWidth="8"
              strokeLinecap="round"
              strokeLinejoin="round"
              fill="none"
            />
            {/* Right Hand */}
            <motion.path
              initial={{ pathLength: 0 }}
              animate={{ pathLength: 1 }}
              transition={{ duration: 0.8, delay: 0.4 }}
              d="M100 80 L100 40 L80 60 L70 30"
              stroke="#D32F2F"
              strokeWidth="8"
              strokeLinecap="round"
              strokeLinejoin="round"
              fill="none"
            />
            {/* Heart in center */}
            <motion.path
              initial={{ scale: 0 }}
              animate={{ scale: 1 }}
              transition={{ duration: 0.4, delay: 0.8 }}
              d="M60 65 L50 55 C45 50 45 42 50 37 C55 32 63 32 60 40 C57 32 65 32 70 37 C75 42 75 50 70 55 Z"
              fill="#8B5A2B"
              style={{ transformOrigin: "60px 50px" }}
            />
          </svg>
        </motion.div>

        {/* Brand Name */}
        <motion.div
          initial={{ y: 20, opacity: 0 }}
          animate={{ y: 0, opacity: 1 }}
          transition={{ delay: 1 }}
          className="text-center"
        >
          <h1 className="text-3xl font-bold text-[#D32F2F] dark:text-[#EF5350] font-poppins">
            Mas Tulung Mas
          </h1>
          <p className="text-sm text-[#8B5A2B] dark:text-[#A67C52] mt-1">
            Bantuan Apa Pun, Kini Dalam Satu Klik
          </p>
        </motion.div>

        {/* Progress Bar */}
        <div className="w-64 h-1.5 bg-gray-200 dark:bg-gray-800 rounded-full overflow-hidden">
          <motion.div
            className="h-full bg-gradient-to-r from-[#D32F2F] to-[#8B5A2B]"
            style={{ width: `${progress}%` }}
            transition={{ duration: 0.1 }}
          />
        </div>
      </div>
    </motion.div>
  );
}
