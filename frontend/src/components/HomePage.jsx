import React from 'react';
import Header from './Header';
import Footer from './Footer';

function HomePage() {
  return (
    <div className="bg-red-400 text-white">
      <Header />
      <div className="container mx-auto px-4 py-8">
        <h1 className="text-4xl font-bold mb-6">Vilho Banike</h1>
        <ul className="list-disc list-inside mb-8">
          <li className="mb-2">BSc Biochemistry</li>
          <li className="mb-2">ALX Software Engineering (ongoing)</li>
          <li className="mb-2">Responsive Web Design (freeCodeCamp)</li>
          <li className="mb-2">Frontend Libraries (freeCodeCamp)</li>
          <li className="mb-2">JavaScript Data Structures and Algorithms (freeCodeCamp)</li>
          <li className="mb-2">PHP (SoloLearn)</li>
          <li className="mb-2">SQL (SoloLearn)</li>
          <li className="mb-2">Tech enthusiast and savvy</li>
          <li className="mb-2">Loves coding and solving problems</li>
        </ul>
        <h2 className="text-2xl font-bold mb-4">Why I want to join Scandiweb:</h2>
        <ul className="list-disc list-inside">
          <li className="mb-2">Passionate about web development</li>
          <li className="mb-2">Eager to learn and grow as a junior developer</li>
          <li className="mb-2">Driven to contribute to innovative projects</li>
          <li className="mb-2">Enthusiastic about working in a collaborative team</li>
          <li className="mb-2">Dedicated to delivering high-quality code and user experiences</li>
          <li className="mb-2">Excited about the opportunity to contribute to Scandiweb's success</li>
        </ul>
      </div>
      <Footer />
    </div>
  );
}

export default HomePage;

