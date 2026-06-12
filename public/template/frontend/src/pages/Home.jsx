import Navbar from "@/components/site/Navbar";
import Hero from "@/components/site/Hero";
import QuickInfo from "@/components/site/QuickInfo";
import About from "@/components/site/About";
import Sambutan from "@/components/site/Sambutan";
import Stats from "@/components/site/Stats";
import Programs from "@/components/site/Programs";
import News from "@/components/site/News";
import InfoTabs from "@/components/site/InfoTabs";
import Agenda from "@/components/site/Agenda";
import Gallery from "@/components/site/Gallery";
import VideoProfile from "@/components/site/VideoProfile";
import Facilities from "@/components/site/Facilities";
import Testimoni from "@/components/site/Testimoni";
import PPDBCTA from "@/components/site/PPDBCTA";
import Contact from "@/components/site/Contact";
import Footer from "@/components/site/Footer";
import FloatingWA from "@/components/site/FloatingWA";

export default function Home() {
  return (
    <div className="min-h-screen bg-[#FAFAFA]" data-testid="home-page">
      <Navbar />
      <Hero />
      <QuickInfo />
      <About />
      <Sambutan />
      <Stats />
      <Programs />
      <News />
      <InfoTabs />
      <Agenda />
      <Gallery />
      <VideoProfile />
      <Facilities />
      <Testimoni />
      <PPDBCTA />
      <Contact />
      <Footer />
      <FloatingWA />
    </div>
  );
}
