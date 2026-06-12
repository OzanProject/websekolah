import "@/App.css";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Home from "@/pages/Home";
import PPDB from "@/pages/PPDB";
import BeritaList from "@/pages/BeritaList";
import BeritaDetail from "@/pages/BeritaDetail";
import { Toaster } from "@/components/ui/sonner";

function App() {
  return (
    <div className="App">
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/ppdb" element={<PPDB />} />
          <Route path="/berita" element={<BeritaList />} />
          <Route path="/berita/:id" element={<BeritaDetail />} />
        </Routes>
      </BrowserRouter>
      <Toaster position="top-right" richColors />
    </div>
  );
}

export default App;
