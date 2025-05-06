/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        primary: { DEFAULT: '#0288D1', dark: '#026da8', light: 'rgba(2, 136, 209, 0.1)' },
        secondary: { DEFAULT: '#4CAF50', dark: '#2E7D32' },
        accent: '#FFC107', 
        danger: '#F44336', 
        success: '#4CAF50',
        warning: '#FF9800', 
        info: '#2196F3', 
        dark: '#1E293B',
        light: '#F8FAFC', 
        // Définition de l'échelle de gris complète au lieu d'une seule couleur
        gray: {
          50: '#F9FAFB',
          100: '#F3F4F6',
          200: '#E5E7EB',
          300: '#D1D5DB',
          400: '#9CA3AF',
          500: '#6B7280',
          600: '#4B5563',
          700: '#374151',
          800: '#1F2937',
          900: '#111827',
          DEFAULT: '#64748B'
        },
        'border-color': '#E2E8F0',
        'card-bg': '#FFFFFF', 
        background: '#F1F5F9'
      },
      animation: { 
        'pulse-short': 'pulse 2s infinite' 
      }
    }
  },
  plugins: [],
}