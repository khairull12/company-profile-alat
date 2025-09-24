/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      },
      colors: {
        primary: {
          DEFAULT: '#1E3A8A',
          '50': '#E8EFFC',
          '100': '#CADCF8',
          '200': '#8EABF0',
          '300': '#5279E6',
          '400': '#214BCD',
          '500': '#1E3A8A',
          '600': '#183072',
          '700': '#132559',
          '800': '#0D1A41',
          '900': '#070F28',
        },
        dark: '#02174C',
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}