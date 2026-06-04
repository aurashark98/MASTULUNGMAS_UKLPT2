import React from "react";
import { useState, useEffect } from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import { LoadingScreen } from "./components/LoadingScreen";
import { Navbar } from "./components/Navbar";
import { ScrollToTop } from "./components/ScrollToTop";
import { Home } from "./pages/Home";
import { Login } from "./pages/Login";
import { Register } from "./pages/Register";
import { UserDashboard } from "./pages/UserDashboard";
import { MitraDashboard } from "./pages/MitraDashboard";

export default function App() {
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    // Simulate initial app load
    const timer = setTimeout(() => {
      setIsLoading(false);
    }, 2000);

    return () => clearTimeout(timer);
  }, []);

  if (isLoading) {
    return <LoadingScreen onComplete={() => setIsLoading(false)} />;
  }

  return (
    <BrowserRouter>
      <div className="min-h-screen bg-white dark:bg-[#121212] text-gray-900 dark:text-white transition-colors duration-300">
        <Routes>
          <Route path="/" element={<><Navbar /><Home /><ScrollToTop /></>} />
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
          <Route path="/dashboard" element={<><Navbar /><UserDashboard /><ScrollToTop /></>} />
          <Route path="/mitra-dashboard" element={<><Navbar /><MitraDashboard /><ScrollToTop /></>} />

          {/* Placeholder routes */}
          <Route path="/layanan" element={<><Navbar /><Placeholder title="Layanan" /><ScrollToTop /></>} />
          <Route path="/cara-kerja" element={<><Navbar /><Placeholder title="Cara Kerja" /><ScrollToTop /></>} />
          <Route path="/tentang" element={<><Navbar /><Placeholder title="Tentang Kami" /><ScrollToTop /></>} />
          <Route path="/kontak" element={<><Navbar /><Placeholder title="Kontak" /><ScrollToTop /></>} />
        </Routes>
      </div>
    </BrowserRouter>
  );
}

function Placeholder({ title }: { title: string }) {
  return (
    <div className="min-h-screen flex items-center justify-center pt-24">
      <div className="text-center">
        <h1 className="text-4xl font-bold text-gray-900 dark:text-white mb-4 font-poppins">
          {title}
        </h1>
        <p className="text-gray-600 dark:text-gray-300">
          Halaman ini sedang dalam pengembangan
        </p>
      </div>
    </div>
  );
}